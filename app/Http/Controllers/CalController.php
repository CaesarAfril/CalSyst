<?php

namespace App\Http\Controllers;

use App\Models\actual_temp_calibration;
use App\Models\Assets;
use App\Models\Plant;
use App\Models\Category;
use App\Models\Department;
use App\Models\Display_calibration;
use App\Models\External_calibration;
use App\Models\external_calibration_file;
use App\Models\Scale_calibration;
use App\Models\temp_calibration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CalController extends Controller
{
    public function internal()
    {
        $category = Category::all();
        return view('calibration.internal', [
            'categories' => $category
        ]);
    }

    public function temperature()
    {
        $report = temp_calibration::with(['actual_temps', 'asset'])->get();

        return view('calibration.temperatureData', [
            'reports' => $report
        ]);
    }

    public function temperature_pdfPrint($uuid)
    {
        // Fetch the specification details using UUID
        $temperature = temp_calibration::with(['actual_temps', 'asset'])->where('uuid', $uuid)->firstOrFail();
        $temperature->calibration_date = Carbon::parse($temperature->date)->format('d-m-Y');
        $temperature->ttd_date = Carbon::parse($temperature->date)->locale('id')->translatedFormat('d F Y');
        // Load the view and pass data
        $pdf = Pdf::loadView('calibration.pdfTemperature', compact('temperature'))->setPaper('legal', 'portrait');

        // Return the generated PDF as a response
        return $pdf->stream('Temperature.pdf'); // Open in browser
    }

    public function display()
    {
        $report = Display_calibration::with(['actual_displays', 'asset'])->get();

        return view('calibration.displayData', [
            'reports' => $report
        ]);
    }

    public function display_pdfPrint($uuid)
    {
        // Fetch the specification details using UUID
        $display = Display_calibration::with(['actual_displays', 'asset'])->where('uuid', $uuid)->firstOrFail();
        $display->calibration_date = Carbon::parse($display->date)->format('d-m-Y');
        $display->ttd_date = Carbon::parse($display->date)->locale('id')->translatedFormat('d F Y');
        // Load the view and pass data
        $pdf = Pdf::loadView('calibration.pdfDisplay', compact('display'))->setPaper('legal', 'portrait');

        // Return the generated PDF as a response
        return $pdf->stream('Display.pdf'); // Open in browser
    }

    public function scale()
    {
        $report = Scale_calibration::with(['asset', 'weighing_performances', 'repeatability_scale_calibrations', 'eccentricity_scale_calibration'])->get();

        return view('calibration.scaleData', [
            'reports' => $report
        ]);
    }

    public function scale_pdfPrint($uuid)
    {
        // Fetch the specification details using UUID
        $scale = Scale_calibration::with([
            'asset',
            'weighing_performances',
            'repeatability_scale_calibrations',
            'eccentricity_scale_calibration.actual_eccentricity_scale'
        ])->where('uuid', $uuid)->firstOrFail();

        $scale->calibration_date = Carbon::parse($scale->date)->format('d-m-Y');
        $scale->ttd_date = Carbon::parse($scale->date)->locale('id')->translatedFormat('d F Y');
        // Load the view and pass data
        $pdf = Pdf::loadView('calibration.pdfScale', compact('scale'))
            ->setPaper('legal', 'portrait');

        // Return the generated PDF as a response
        return $pdf->stream('Scale.pdf'); // Open in browser
    }

    public function external()
    {
        $assets = Assets::whereHas('category', function ($query) {
            $query->where('calibration', 'External');
        })->get();
        $report = External_calibration::with(['asset', 'latestCalibrationFile'])->get();

        return view('calibration.externalData', [
            'assets' => $assets,
            'reports' => $report
        ]);
    }

    public function externalStore(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'asset' => 'required|string|exists:assets,uuid',
        ]);

        External_calibration::create([
            'date' => $request->date,
            'asset_uuid' => $request->asset,
            'progress_status' => 'Persiapan Pengajuan',
        ]);

        return redirect()->back();
    }

    public function storeFile(Request $request, $uuid, $progress)
    {
        $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
        $calibration->update(['progress_status' => $progress]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $folder = "calibration/" . strtolower($progress);
            $path = $file->storeAs($folder, $filename, 'public');

            external_calibration_file::create([
                'calibration_uuid' => $uuid,
                'progress' => $progress,
                'upload_date' => $request->date_file,
                'path' => $path,
                'filename' => $filename,
            ]);
        }

        return redirect()->back();
    }

    public function addNotes(Request $request, $uuid)
    {
        $validated = $request->validate(['notes' => 'required']);
        $file = external_calibration_file::where('uuid', $uuid)->firstOrFail();
        $file->update(['notes' => $validated['notes']]);

        return redirect()->back();
    }

    public function approveProgress($uuid, $nextProgress)
    {
        $file = external_calibration_file::where('uuid', $uuid)->firstOrFail();
        $file->update([
            'approval' => '1',
            'progress' => $nextProgress,
        ]);

        $calibration = External_calibration::where('uuid', $file->calibration_uuid)->firstOrFail();
        $calibration->update(['progress_status' => $nextProgress]);

        external_calibration_file::create([
            'calibration_uuid' => $calibration->uuid,
            'progress' => $nextProgress,
        ]);

        return redirect()->back();
    }

    // Example of calling
    public function penawaranFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'Penawaran');
    }

    public function ppbjFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'PPBJ');
    }

    public function negosiasiFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'Negosiasi');
    }

    public function spkFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'SPK');
    }

    public function pelaksanaanFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'Pelaksanaan');
    }

    public function baFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'BA');
    }

    public function pembayaranFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'Pembayaran');
    }
    public function sertifikatFileStore(Request $request, $uuid)
    {
        return $this->storeFile($request, $uuid, 'Sertifikat');
    }

    public function addApprove($uuid)
    {
        return $this->approveProgress($uuid, 'PPBJ');
    }

    public function addApprovePpbj($uuid)
    {
        return $this->approveProgress($uuid, 'Negosiasi');
    }

    public function addApproveNegosiasi($uuid)
    {
        return $this->approveProgress($uuid, 'SPK');
    }

    public function addApproveSpk($uuid)
    {
        return $this->approveProgress($uuid, 'Pelaksanaan');
    }

    public function addApprovePelaksanaan($uuid)
    {
        return $this->approveProgress($uuid, 'BA');
    }

    public function addApproveBa($uuid)
    {
        return $this->approveProgress($uuid, 'Pembayaran');
    }

    public function addApprovePembayaran($uuid)
    {
        return $this->approveProgress($uuid, 'Sertifikat');
    }

    public function addApproveSertifikat($uuid)
    {
        return $this->approveProgress($uuid, 'Sertifikat');
    }

    public function lateCalibration(Request $request)
    {
        $search = $request->input('search');
        $today = now();

        $query = Assets::with(['department', 'plant', 'category'])
            ->whereNotNull('expired_date')
            ->whereDate('expired_date', '<=', $today);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('series_number', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            })
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('category', 'like', "%{$search}%");
                })
                ->orWhereHas('department', function ($q) use ($search) {
                    $q->where('department', 'like', "%{$search}%");
                })
                ->orWhereHas('plant', function ($q) use ($search) {
                    $q->where('plant', 'like', "%{$search}%");
                });
        }

        // Clone the query to get the correct count
        $countQuery = clone $query;

        $expiredAssets = $query->paginate(10);
        $totalAssets = Assets::count();
        $expiredCount = $countQuery->count();

        return view('calibration.lateCalibration', [
            'totalAssets' => $totalAssets,
            'expiredCount' => $expiredCount,
            'expiredAssets' => $expiredAssets,
            'search' => $search,
        ]);
    }

    public function calibratedAssets(Request $request)
    {
        $year = now()->year;
        $assets = Assets::with([
            'department',
            'plant',
            'category',
            'latest_external_calibration',
            'latest_temp_calibration',
            'latest_display_calibration',
            'latest_scale_calibration',
        ])->get();

        // Filter hanya yang expired masih masa depan dan ada kalibrasi terakhir
        $calibratedAssets = $assets->filter(function ($asset) {
            $expired = $asset->expired_date;

            $latestCalibration = collect([
                optional($asset->latest_external_calibration)->certificate_date,
                optional($asset->latest_temp_calibration)->date,
                optional($asset->latest_display_calibration)->date,
                optional($asset->latest_scale_calibration)->date,
            ])->filter()->sortDesc()->first();

            return $expired && Carbon::parse($expired)->isFuture() && $latestCalibration;
        });
        $calibratedCount = $calibratedAssets->count();

        $inProgressAssets = $assets->filter(function ($asset) {
            $expired = $asset->expired_date;    
            $external = optional($asset->latest_external_calibration);

            if (!$external || !$expired || !Carbon::parse($expired)->isFuture()) {
                return false;
            }

            $progress = $external->progress_status ?? '';
            $certDate = $external->certificate_date ?? null;

            if (
                in_array($progress, ['Persiapan Pengajuan', 'Penawaran', 'PPBJ', 'Negosiasi', 'SPK', 'Pelaksanaan', 'BA', 'Pembayaran'])
            ) {
                return true;
            }

            return false;
        });


        return view('calibration.calibratedAsset', [
            'expiredAssets' => $calibratedAssets,
            'calibratedCount' => $calibratedCount,
            'inProgressAssets' => $inProgressAssets,
            'inProgressCount' => $inProgressAssets->count(),
        ]);
    }
}