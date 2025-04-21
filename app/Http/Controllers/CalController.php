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

    // PENAWARAN
    // public function penawaranFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
    //     $update = $calibration->update([
    //         'progress_status' => 'Penawaran'
    //     ]);
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/penawaran";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotes(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApprove($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->save();

    //     $calibration = External_calibration::where('uuid', $approvalConfirm->calibration_uuid)->firstOrFail();
    //     $calibration->progress_status = 'PPBJ';
    //     $calibration->save();

    //     external_calibration_file::create([
    //         'calibration_uuid' => $calibration->uuid,
    //         'progress' => $calibration->progress_status,
    //     ]);
    //     return redirect()->back();
    // }

    // // PPBJ
    // public function ppbjFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
    //     $update = $calibration->update([
    //         'progress_status' => 'PPBJ'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/ppbj";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotesPpbj(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApprovePpbj($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->progress = 'Negosiasi';
    //     $approvalConfirm->save();

    //     $calibration = External_calibration::where('uuid', $approvalConfirm->calibration_uuid)->firstOrFail();
    //     $calibration->progress_status = 'Negosiasi';
    //     $calibration->save();

    //     external_calibration_file::create([
    //         'calibration_uuid' => $calibration->uuid,
    //         'progress' => $calibration->progress_status,
    //     ]);
    //     return redirect()->back();
    // }

    // // NEGOSIASI
    // public function negosiasiFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();

    //     $update = $calibration->update([
    //         'progress_status' => 'Negosiasi'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/negosiasi";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotesNegosiasi(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApproveNegosiasi($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->progress = 'SPK';
    //     $approvalConfirm->save();

    //     $calibration = External_calibration::where('uuid', $approvalConfirm->calibration_uuid)->firstOrFail();
    //     $calibration->progress_status = 'SPK';
    //     $calibration->save();

    //     external_calibration_file::create([
    //         'calibration_uuid' => $calibration->uuid,
    //         'progress' => $calibration->progress_status,
    //     ]);
    //     return redirect()->back();
    // }

    // // SPK
    // public function spkFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
    //     $update = $calibration->update([
    //         'progress_status' => 'SPK'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/spk";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotesSpk(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApproveSpk($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->progress = 'Pelaksanaan';
    //     $approvalConfirm->save();

    //     $calibration = External_calibration::where('uuid', $approvalConfirm->calibration_uuid)->firstOrFail();
    //     $calibration->progress_status = 'Pelaksanaan';
    //     $calibration->save();

    //     external_calibration_file::create([
    //         'calibration_uuid' => $calibration->uuid,
    //         'progress' => $calibration->progress_status,
    //     ]);
    //     return redirect()->back();
    // }

    // // PELAKSANAAN
    // public function pelaksanaanFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
    //     $update = $calibration->update([
    //         'progress_status' => 'Pelaksanaan'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/pelaksanaan";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotesPelaksanaan(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApprovePelaksanaan($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->progress = 'BA';
    //     $approvalConfirm->save();

    //     $calibration = External_calibration::where('uuid', $approvalConfirm->calibration_uuid)->firstOrFail();
    //     $calibration->progress_status = 'BA';
    //     $calibration->save();

    //     external_calibration_file::create([
    //         'calibration_uuid' => $calibration->uuid,
    //         'progress' => $calibration->progress_status,
    //     ]);
    //     return redirect()->back();
    // }

    // // BA
    // public function baFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
    //     $update = $calibration->update([
    //         'progress_status' => 'BA'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/ba";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotesBa(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApproveBa($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->progress = 'Pembayaran';
    //     $approvalConfirm->save();

    //     $calibration = External_calibration::where('uuid', $approvalConfirm->calibration_uuid)->firstOrFail();
    //     $calibration->progress_status = 'Pembayaran';
    //     $calibration->save();

    //     external_calibration_file::create([
    //         'calibration_uuid' => $calibration->uuid,
    //         'progress' => $calibration->progress_status,
    //     ]);
    //     return redirect()->back();
    // }

    // // PEMBAYARAN
    // public function pembayaranFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
    //     $update = $calibration->update([
    //         'progress_status' => 'Pembayaran'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/pembayaran";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotesPembayaran(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApprovePembayaran($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->progress = 'Sertifikat';
    //     $approvalConfirm->save();

    //     $calibration = External_calibration::where('uuid', $approvalConfirm->calibration_uuid)->firstOrFail();
    //     $calibration->progress_status = 'Sertifikat';
    //     $calibration->save();

    //     external_calibration_file::create([
    //         'calibration_uuid' => $calibration->uuid,
    //         'progress' => $calibration->progress_status,
    //     ]);
    //     return redirect()->back();
    // }

    // // SERTIFIKAT
    // public function sertifikatFileStore(Request $request, $uuid)
    // {
    //     $calibration = External_calibration::where('uuid', $uuid)->firstOrFail();
    //     $update = $calibration->update([
    //         'progress_status' => 'Sertifikat'
    //     ]);

    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = "{$originalFilename}.{$extension}";
    //         $folder = "calibration/sertifikat";
    //         $path = $file->storeAs($folder, $filename, 'public');

    //         external_calibration_file::create([
    //             'calibration_uuid' => $uuid,
    //             'progress' => $calibration->progress_status,
    //             'upload_date' => $request->date_file,
    //             'path' => $path,
    //             'filename' => $filename,
    //         ]);

    //         return redirect()->back();
    //     }
    //     return redirect()->back();
    // }

    // public function addNotesSertifikat(Request $request, $uuid)
    // {
    //     $validatedData = $request->validate([
    //         'notes' => 'required'
    //     ]);
    //     $calibrations = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $calibrations->notes = $validatedData['notes'];
    //     $calibrations->save();

    //     return redirect()->back();
    // }

    // public function addApproveSertifikat($uuid)
    // {
    //     $approvalConfirm = external_calibration_file::where('uuid', $uuid)->FirstOrFail();
    //     $approvalConfirm->approval = '1';
    //     $approvalConfirm->save();

    //     return redirect()->back();
    // }

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
        return $this->approveProgress($uuid, '');
    }
}