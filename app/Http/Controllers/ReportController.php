<?php

namespace App\Http\Controllers;

use App\Exports\DisplayCalibrationExport;
use App\Exports\TempCalibrationExport;
use App\Models\Actual_display_calibration;
use App\Models\Actual_eccentricity_scale;
use App\Models\Actual_repeatability_scale;
use App\Models\actual_temp_calibration;
use App\Models\Assets;
use App\Models\Display_calibration;
use App\Models\Eccentricity_scale_calibration;
use App\Models\Repeatability_scale_calibration;
use App\Models\Scale_calibration;
use App\Models\temp_calibration;
use App\Models\Weighing_performance;
use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function temperature()
    {
        $report = temp_calibration::with(['actual_temps', 'asset'])->get();

        return view('report.temperatureData', [
            'reports' => $report
        ]);
    }

    public function temperature_addData()
    {
        $asset = Assets::with('department')->where('category_uuid', '3cfc952c-ca24-4f7e-8532-5073b3d66d34')->get();
        return view('report.store_internal_temp', ['assets' => $asset]);
    }

    public function temperature_store(Request $request)
    {
        $asset = Assets::with('plant')->where('uuid', $request->asset)->first();
        $tanggal = Carbon::parse($request->tanggal);
        $monthRoman = $this->toRoman($tanggal->month);
        $year = $tanggal->year;

        // Construct the certificate number
        $certificate = $asset->plant->abbreviaton . '/' . $monthRoman . '/' . $year;
        try {
            \DB::beginTransaction();

            // Insert into temperature_calibration_assets
            $asset = new temp_calibration();
            $asset->date = $request->tanggal;
            $asset->certificate_number = $certificate;
            $asset->asset_uuid = $request->asset;
            $asset->initial_temp = $request->initial_temp;
            $asset->final_temp = $request->final_temp;
            $asset->initial_rh = $request->initial_rh;
            $asset->final_rh = $request->final_rh;
            $asset->avg_stdev_uut = $request->avg_stdev_uut;
            $asset->u1 = $request->u1;
            $asset->u2 = $request->u2;
            $asset->u3 = $request->u3;
            $asset->uc = $request->uc;
            $asset->veff = $request->veff;
            $asset->k = $request->k;
            $asset->u95 = $request->u95;
            $asset->save();

            // Get the newly created uuid
            $tempCalibrationUuid = $asset->uuid;

            // Insert multiple actual temperature calibration records
            foreach ($request->set_suhu as $index => $set_suhu) {
                $actual = new actual_temp_calibration();
                $actual->set_temp = $set_suhu;
                $actual->standar1 = $request->standar1[$index];
                $actual->standar2 = $request->standar2[$index];
                $actual->standar3 = $request->standar3[$index];
                $actual->standar4 = $request->standar4[$index];
                $actual->standar5 = $request->standar5[$index];
                $actual->standar6 = $request->standar6[$index];
                $actual->standar7 = $request->standar7[$index];
                $actual->aktual1 = $request->aktual1[$index];
                $actual->aktual2 = $request->aktual2[$index];
                $actual->aktual3 = $request->aktual3[$index];
                $actual->aktual4 = $request->aktual4[$index];
                $actual->aktual5 = $request->aktual5[$index];
                $actual->aktual6 = $request->aktual6[$index];
                $actual->aktual7 = $request->aktual7[$index];
                $actual->avgprt = $request->avgprt[$index] ?? null;
                $actual->stdevprt = $request->stdevprt[$index] ?? null;
                $actual->avguut = $request->avguut[$index] ?? null;
                $actual->stdevuut = $request->stdevuut[$index] ?? null;
                $actual->uprt = $request->u4prt[$index] ?? null;
                $actual->correction = $request->correction[$index] ?? null;
                $actual->temp_calibration_uuid = $tempCalibrationUuid;
                $actual->save();
            }

            \DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function exportTempExcel($uuid)
    {
        $temperature = temp_calibration::with(['actual_temps', 'asset'])->where('uuid', $uuid)->firstOrFail();
        return Excel::download(new TempCalibrationExport($temperature), 'Temperature_calibration_' . $temperature->asset->merk . '_' . $temperature->asset->type . '.xlsx');
    }

    public function display()
    {
        $report = Display_calibration::with(['actual_displays', 'asset'])->get();

        return view('report.displayData', [
            'reports' => $report
        ]);
    }

    public function display_addData()
    {
        $asset = Assets::with('department')->where('category_uuid', '575261f1-039d-4fc3-bcfa-bff34999dcdc')->get();
        return view('report.store_internal_display', ['assets' => $asset]);
    }

    public function display_store(Request $request)
    {
        $asset = Assets::with('plant')->where('uuid', $request->asset)->first();
        $tanggal = Carbon::parse($request->tanggal);
        $monthRoman = $this->toRoman($tanggal->month);
        $year = $tanggal->year;

        // Construct the certificate number
        $certificate = $asset->plant->abbreviaton . '/' . $monthRoman . '/' . $year;
        try {
            \DB::beginTransaction();

            // Insert into temperature_calibration_assets
            $asset = new Display_calibration();
            $asset->date = $request->tanggal;
            $asset->certificate_number = $certificate;
            $asset->asset_uuid = $request->asset;
            $asset->initial_temp = $request->initial_temp;
            $asset->final_temp = $request->final_temp;
            $asset->initial_rh = $request->initial_rh;
            $asset->final_rh = $request->final_rh;
            $asset->avg_stdev_uut = $request->avg_stdev_uut;
            $asset->u1 = $request->u1;
            $asset->u2 = $request->u2;
            $asset->u3 = $request->u3;
            $asset->uc = $request->uc;
            $asset->veff = $request->veff;
            $asset->k = $request->k;
            $asset->u95 = $request->u95;
            $asset->save();

            // Get the newly created uuid
            $displayCalibrationUuid = $asset->uuid;

            // Insert multiple actual temperature calibration records
            foreach ($request->set_suhu as $index => $set_suhu) {
                $actual = new Actual_display_calibration();
                $actual->set_temp = $set_suhu;
                $actual->standar1 = $request->standar1[$index];
                $actual->standar2 = $request->standar2[$index];
                $actual->standar3 = $request->standar3[$index];
                $actual->standar4 = $request->standar4[$index];
                $actual->standar5 = $request->standar5[$index];
                $actual->aktual1 = $request->aktual1[$index];
                $actual->aktual2 = $request->aktual2[$index];
                $actual->aktual3 = $request->aktual3[$index];
                $actual->aktual4 = $request->aktual4[$index];
                $actual->aktual5 = $request->aktual5[$index];
                $actual->avgprt = $request->avgprt[$index] ?? null;
                $actual->stdevprt = $request->stdevprt[$index] ?? null;
                $actual->avguut = $request->avguut[$index] ?? null;
                $actual->stdevuut = $request->stdevuut[$index] ?? null;
                $actual->uprt = $request->u4prt[$index] ?? null;
                $actual->correction = $request->correction[$index] ?? null;
                $actual->display_calibration_uuid = $displayCalibrationUuid;
                $actual->save();
            }

            \DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function exportDisplayExcel($uuid)
    {
        $display = Display_calibration::with(['actual_displays', 'asset'])->where('uuid', $uuid)->firstOrFail();
        return Excel::download(new DisplayCalibrationExport($display), 'Display_calibration_' . $display->asset->merk . '_' . $display->asset->department->department . '.xlsx');
    }

    public function scale()
    {
        $report = Scale_calibration::with(['asset', 'weighing_performances', 'repeatability_scale_calibrations', 'eccentricity_scale_calibration'])->get();

        return view('report.scaleData', [
            'reports' => $report
        ]);
    }

    public function scale_addData()
    {
        $asset = Assets::with('department')->where('category_uuid', 'b3306ec8-697d-414c-89aa-dc5cea8f5d8f')->get();
        $weight = Weight::all();
        return view('report.store_internal_scale', [
            'assets' => $asset,
            'weights' => $weight
        ]);
    }

    public function scale_store(Request $request)
    {
        $asset = Assets::with('plant')->where('uuid', $request->asset)->first();
        $tanggal = Carbon::parse($request->tanggal);
        $monthRoman = $this->toRoman($tanggal->month);
        $year = $tanggal->year;
        $certificate = $asset->plant->abbreviaton . '/' . $monthRoman . '/' . $year;

        try {
            \DB::beginTransaction();

            $asset = new Scale_calibration();
            $asset->date = $request->tanggal;
            $asset->certificate_number = $certificate;
            $asset->asset_uuid = $request->asset;
            $asset->initial_temp = $request->initial_temp;
            $asset->final_temp = $request->final_temp;
            $asset->initial_rh = $request->initial_rh;
            $asset->final_rh = $request->final_rh;
            $asset->max_weight = $request->max_weight;
            $asset->max_scale = $request->max_scale;
            $asset->scale_resolution = $request->scale_resolution;
            $asset->scale_class = $request->scale_class;
            $asset->weight_resolution = $request->weight_resolution;
            $asset->weight_max = $request->weight_max;
            $asset->weight_min = $request->weight_min;
            $asset->k = $request->k;
            $asset->avg_dev_repeatability = $request->avg_dev_repeatability;
            $asset->UDrift_weight = $request->UDrift_weight;
            $asset->Ureadability = $request->Ureadability;
            $asset->U95 = $request->avg_U95;
            $asset->save();

            $calibrationUuid = $asset->uuid;

            foreach ($request->total as $index => $total) {
                $weighing = new Weighing_performance();
                $weighing->calibration_uuid = $calibrationUuid;
                $weighing->total = $total;
                $weighing->weight_1 = $request->weight_1[$index];
                $weighing->weight_2 = $request->weight_2[$index];
                $weighing->show = $request->show[$index];
                $weighing->correction = $request->correction[$index];
                $weighing->Uweightstd = $request->Uweightstd[$index];
                $weighing->Ubouyancy = $request->Ubouyancy[$index];
                $weighing->Uc = $request->Uc[$index];
                $weighing->U95 = $request->U95[$index];
                $weighing->save();
            }

            foreach ([5, 50, 100] as $percent) {
                // Save main calibration data
                $repeatability = Repeatability_scale_calibration::create([
                    'calibration_uuid' => $calibrationUuid,
                    'weight' => $request->input("weight_{$percent}"),
                    'average' => $request->input("average")[($percent === 5) ? 0 : (($percent === 50) ? 1 : 2)],
                    'sd' => $request->input("sd")[($percent === 5) ? 0 : (($percent === 50) ? 1 : 2)],
                    'Urepeat' => $request->input("Urepeat")[($percent === 5) ? 0 : (($percent === 50) ? 1 : 2)],
                ]);

                // Save actual measurements
                $shownValues = $request->input("repeatability_show_{$percent}");
                $corrections = $request->input("repeatability_correction_{$percent}");

                foreach ($shownValues as $i => $shown) {
                    Actual_repeatability_scale::create([
                        'repeatability_id' => $repeatability->id,
                        'shown' => $shown,
                        'correction' => $corrections[$i] ?? 0,
                    ]);
                }
            }

            $ecc = Eccentricity_scale_calibration::create([
                'calibration_uuid' => $calibrationUuid,
                'weight' => $request->weight_ecc,
                'average' => $request->average_ecc,
                'uecc' => $request->uecc,
            ]);

            // Loop through shown values and calculate corrections
            foreach ($request->eccentricity_show as $shown) {
                if (!is_null($shown)) {
                    $correction = $request->weight_ecc - $shown;
                    $abs_correction = abs($correction);

                    Actual_eccentricity_scale::create([
                        'eccentricity_id' => $ecc->id,
                        'shown' => $shown,
                        'correction' => $correction,
                        'absolute_correction' => $abs_correction,
                    ]);
                }
            }
            \DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    private function toRoman($number)
    {
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $map[$number] ?? '';
    }
}
