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
use App\Models\AbfValidation;
use PDF;
use App\Imports\PersebaranSuhuImport;
use App\Imports\PenetrasiSuhuImport;
use Illuminate\Support\Facades\Storage;
\Carbon\Carbon::setLocale('id');

class ValidationController extends Controller
{
    // slaughterhouse
    public function screwChiller()
    {
        return view('validation.slaughterhouse.screwchiller');
    }

    public function screwChiller_addData()
    {
        return view('validation.store.store_screwchiller');
    }

    public function ABF()
    {
        $dataABF = AbfValidation::latest()->get();
        return view('validation.slaughterhouse.ABF', compact('dataABF'));
    }

    public function ABF_addData()
    {
        return view('validation.store.store_ABF');
    }

    public function storeABF(Request $request)
    {
        $validated = $request->validate([
            'start_pengujian' => 'required|date',
            'end_pengujian' => 'required|date',
            'pengujian' => 'required|integer',
            'nama_produk' => 'nullable|string',
            'ingredient' => 'nullable|string',
            'kemasan' => 'nullable|string',
            'nama_mesin' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'kapasitas' => 'nullable|string',
            'susunan' => 'nullable|string',
            'isi_rak' => 'nullable|string',
            'penumpukan' => 'nullable|string',
            'target_suhu' => 'nullable|string',
            'set_thermostat' => 'nullable|string',
            'nama_mesin_2' => 'nullable|string',
            'merek_mesin_2' => 'nullable|string',
            'tipe_mesin_2' => 'nullable|string',
            'freon_mesin_2' => 'nullable|string',
            'kapasitas_mesin_2' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'persebaran_suhu' => 'nullable|mimes:xls,xlsx',
            'penetrasi_suhu' => 'nullable|mimes:xls,xlsx',
        ]);

        // persebaran
        $suhuAwal = null;
        $suhuAkhir = null;
        $jamAwal = null;
        $jamAkhir = null;
        $filePath = null;

        if ($request->hasFile('persebaran_suhu')) {
            $file = $request->file('persebaran_suhu');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/persebaran_suhu', $filename, 'public');

            $importPersebaran = new PersebaranSuhuImport;
            Excel::import($importPersebaran, $file);

            $suhuAwal = $importPersebaran->suhuAwal;
            $suhuAkhir = $importPersebaran->suhuAkhir;
            $jamAwal = $importPersebaran->jamAwal;
            $jamAkhir = $importPersebaran->jamAkhir;
        }

        // penetrasi
        $suhuAwalPenetrasi = null;
        $suhuAkhirPenetrasi = null;
        $filePathPenetrasi = null;

        if ($request->hasFile('penetrasi_suhu')) {
            $filePenetrasi = $request->file('penetrasi_suhu');
            $filenamePenetrasi = time() . '_' . $filePenetrasi->getClientOriginalName();
            $filePathPenetrasi = $filePenetrasi->storeAs('uploads/penetrasi_suhu', $filenamePenetrasi, 'public');

            $importPenetrasi = new PenetrasiSuhuImport;
            Excel::import($importPenetrasi, $filePenetrasi);

            $suhuAwalPenetrasi = $importPenetrasi->suhuAwalPenetrasi;
            $suhuAkhirPenetrasi = $importPenetrasi->suhuAkhirPenetrasi;
        }

        AbfValidation::create(array_merge($validated, [
            'persebaran_suhu' => $filePath,
            'suhu_awal' => $suhuAwal ? json_encode($suhuAwal) : null,
            'suhu_akhir' => $suhuAkhir ? json_encode($suhuAkhir) : null,
            'jam_awal' => $jamAwal,
            'jam_akhir' => $jamAkhir,
            'penetrasi_suhu' => $filePathPenetrasi,
            'suhu_awal_penetrasi' => $suhuAwalPenetrasi ? json_encode($suhuAwalPenetrasi) : null,
            'suhu_akhir_penetrasi' => $suhuAkhirPenetrasi ? json_encode($suhuAkhirPenetrasi) : null,
        ]));

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function deleteABF($id)
    {
        $data = AbfValidation::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function printABF($id)
    {
        $dataABF = AbfValidation::findOrFail($id);

        // Kirim ke view
        $pdf = PDF::loadView('validation.print.print_abf', [
            'dataABF' => $dataABF,
        ])->setOptions(['isRemoteEnabled' => true]);

        return $pdf->stream('laporan-abf-' . $dataABF->nama_produk . '.pdf');
    }

    public function IQF()
    {
        return view('validation.slaughterhouse.IQF');
    }

    public function IQF_addData()
    {
        return view('validation.store.store_IQF');
    }

    // further
    public function fryer1()
    {
        return view('validation.further.fryer1');
    }

    public function fryer1_addData()
    {
        return view('validation.store.store_fryer1');
    }


    public function fryer2()
    {
        return view('validation.further.fryer2');
    }

    public function fryer2_addData()
    {
        return view('validation.store.store_fryer2');
    }

    public function fryerMarel()
    {
        return view('validation.further.fryerMarel');
    }

    public function fryerMarel_addData()
    {
        return view('validation.store.store_fryerMarel');
    }

    public function hiCook()
    {
        return view('validation.further.hicook');
    }

    public function hiCook_addData()
    {
        return view('validation.store.store_hiCook');
    }

    // sausage
    public function smokeHouse()
    {
        return view('validation.sausage.smokehouse');
    }

    public function smokeHouse_addData()
    {
        return view('validation.store.store_smokeHouse');
    }

    // breadcrumb
    public function aging()
    {
        return view('validation.breadcrumb.aging');
    }

    public function aging_addData()
    {
        return view('validation.store.store_aging');
    }
}