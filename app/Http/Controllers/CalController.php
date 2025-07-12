<?php

namespace App\Http\Controllers;

use App\Models\actual_Temp_calibration;
use App\Models\Assets;
use App\Models\Plant;
use App\Models\Category;
use App\Models\Department;
use App\Models\Display_calibration;
use App\Models\External_calibration;
use App\Models\external_calibration_file;
use App\Models\Scale_calibration;
use App\Models\Temp_calibration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CalController extends Controller
{
    public function internal()
    {
        $category = Category::all();
        return view('calibration.internal', [
            'categories' => $category
        ]);
    }

    public function temperature(Request $request)
    {
        $plant = $request->input('area');
        $report = Temp_calibration::getTemperature($plant, 1);

        return view('calibration.temperatureData', [
            'reports' => $report
        ]);
    }

    public function temperature_pdfPrint($uuid)
    {
        $temperature = Temp_calibration::with(['actual_temps', 'asset'])->where('uuid', $uuid)->firstOrFail();
        $temperature->calibration_date = Carbon::parse($temperature->date)->format('d-m-Y');
        $temperature->ttd_date = Carbon::parse($temperature->date)->locale('id')->translatedFormat('d F Y');

        $pdf = Pdf::loadView('calibration.pdfTemperature', compact('temperature'))->setPaper('legal', 'portrait');

        return $pdf->stream('Temperature.pdf');
    }

    public function display(Request $request)
    {
        $plant = $request->input('area');
        $report = Display_calibration::getDisplay($plant, 1);

        return view('calibration.displayData', [
            'reports' => $report
        ]);
    }

    public function display_pdfPrint($uuid)
    {
        $display = Display_calibration::with(['actual_displays', 'asset'])->where('uuid', $uuid)->firstOrFail();
        $display->calibration_date = Carbon::parse($display->date)->format('d-m-Y');
        $display->ttd_date = Carbon::parse($display->date)->locale('id')->translatedFormat('d F Y');

        $pdf = Pdf::loadView('calibration.pdfDisplay', compact('display'))->setPaper('legal', 'portrait');


        return $pdf->stream('Display.pdf');
    }

    public function scale(Request $request)
    {
        $plant = $request->input('area');
        $report = Scale_calibration::getScale($plant, 1);

        return view('calibration.scaleData', [
            'reports' => $report
        ]);
    }

    public function scale_pdfPrint($uuid)
    {
        $scale = Scale_calibration::with([
            'asset',
            'weighing_performances',
            'repeatability_scale_calibrations',
            'eccentricity_scale_calibration.actual_eccentricity_scale'
        ])->where('uuid', $uuid)->firstOrFail();

        $scale->calibration_date = Carbon::parse($scale->date)->format('d-m-Y');
        $scale->ttd_date = Carbon::parse($scale->date)->locale('id')->translatedFormat('d F Y');
        $pdf = Pdf::loadView('calibration.pdfScale', compact('scale'))
            ->setPaper('legal', 'portrait');

        return $pdf->stream('Scale.pdf');
    }

    public function external(Request $request)
    {
        $plant = $request->input('area');
        $assets = Assets::getExternalAssetDropdown($plant)->get();
        $report = External_calibration::fetchExternalData($plant)->paginate(10);

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

    public function updateFile(Request $request, $uuid, $progress)
    {
        $calibration = external_calibration_file::where('uuid', $uuid)->firstOrFail();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $folder = "calibration/" . strtolower($progress);
            $path = $file->storeAs($folder, $filename, 'public');

            $calibration->update([
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
        $file->update([
            'notes' => $validated['notes'],
            'path' => NULL,
            'filename' => NULL
        ]);

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
        $plant = $request->input('area');
        $today = now();

        $query = Assets::getExpiredAssets($plant, $today, $search);

        $expiredAssets = $query->paginate(10);
        $totalAssets = Assets::count();
        $expiredCount = $query->count();

        return view('calibration.lateCalibration', [
            'totalAssets' => $totalAssets,
            'expiredCount' => $expiredCount,
            'expiredAssets' => $expiredAssets,
            'search' => $search,
        ]);
    }

    public function calibratedAssets(Request $request)
    {
        $plant = $request->input('area');
        $nextYear = now()->addYear()->year;
        $assets = Assets::getCalibratedAsset($plant);

        $missingCalibratedAssets = [];
        $calibratedAssets = [];
        $certifiedAssets = [];

        foreach ($assets as $asset) {
            $latestCalibrationFile = optional($asset->latest_external_calibration)->latestCalibrationFile;

            if (
                $latestCalibrationFile &&
                $latestCalibrationFile->progress === 'Sertifikat' &&
                !is_null($latestCalibrationFile->filename) &&
                !is_null($latestCalibrationFile->path) &&
                Carbon::parse($asset->expired_date)->year === $nextYear
            ) {
                $certifiedAssets[] = $asset;
            }

            // Cek expired date
            $ed = Carbon::parse($asset->expired_date)->year;
            if ($nextYear == $ed) {
                $externalComplete = false;

                if (
                    $latestCalibrationFile &&
                    $latestCalibrationFile->progress === 'Sertifikat' &&
                    !is_null($latestCalibrationFile->filename) &&
                    !is_null($latestCalibrationFile->path)
                ) {
                    $externalComplete = true;
                }

                $hasOtherCalibration = collect([
                    optional($asset->latest_Temp_calibration)->date,
                    optional($asset->latest_display_calibration)->date,
                    optional($asset->latest_scale_calibration)->date,
                ])->filter()->isNotEmpty();

                if ($externalComplete || $hasOtherCalibration) {
                    $calibratedAssets[] = $asset;
                } else {
                    $missingCalibratedAssets[] = $asset;
                }
            }
        }

        $page = request()->get('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $pagedMissingAssets = array_slice($missingCalibratedAssets, $offset, $perPage);

        $missingAssetsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedMissingAssets,
            count($missingCalibratedAssets),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('calibration.calibratedAsset', [
            'missingCalibrationCount' => count($missingCalibratedAssets),
            'missingCalibrationAsset' => $missingAssetsPaginated,
            'calibratedAssets' => $calibratedAssets,
            'certifiedAssets' => $certifiedAssets,
            'certifiedAssetsCount' => count($certifiedAssets),
        ]);
    }
}
