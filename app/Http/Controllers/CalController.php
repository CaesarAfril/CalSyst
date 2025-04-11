<?php

namespace App\Http\Controllers;

use App\Models\actual_temp_calibration;
use App\Models\Assets;
use App\Models\Category;
use App\Models\Display_calibration;
use App\Models\External_calibration;
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
            $query->where('calibration', 'external');
        })->get();
        $report = External_calibration::with(['asset'])->get();

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
            'status' => 'required|string',
            'next_date' => 'required|date'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = "{$originalFilename}.{$extension}";

            $folder = "calibration/external_calibration";
            $path = $file->storeAs($folder, $filename, 'public');

            External_calibration::create([
                'date' => $request->date,
                'asset_uuid' => $request->asset,
                'path' => $path,
                'filename' => $filename,
                'status' => $request->status,
                'next_calibration_date' => $request->next_date
            ]);

            return redirect()->back();
        }
        return redirect()->back();
    }
}
