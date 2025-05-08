<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AbfValidation;
use App\Models\SuhuAbfAll;
use PDF;
use App\Imports\PersebaranSuhuImport;
use App\Imports\PenetrasiSuhuImport;
use Illuminate\Support\Facades\Storage;
\Carbon\Carbon::setLocale('id');
use Illuminate\Support\Facades\DB;

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
            'all_suhu' => 'required|mimes:xls,xlsx'
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

        $abf = AbfValidation::create(array_merge($validated, [
            'persebaran_suhu' => $filePath,
            'suhu_awal' => $suhuAwal ? json_encode($suhuAwal) : null,
            'suhu_akhir' => $suhuAkhir ? json_encode($suhuAkhir) : null,
            'jam_awal' => $jamAwal,
            'jam_akhir' => $jamAkhir,
            'penetrasi_suhu' => $filePathPenetrasi,
            'suhu_awal_penetrasi' => $suhuAwalPenetrasi ? json_encode($suhuAwalPenetrasi) : null,
            'suhu_akhir_penetrasi' => $suhuAkhirPenetrasi ? json_encode($suhuAkhirPenetrasi) : null,
        ]));

        $path = $request->file('all_suhu')->getRealPath();
        $data = Excel::toArray([], $path)[0];

        // Cari start row (judul 'Time' biasanya di baris ke-x)
        $startRow = 1;
        while ($startRow < count($data) && strtolower($data[$startRow][0]) !== 'time') {
            $startRow++;
        }

        DB::beginTransaction();
        try {
            for ($i = $startRow + 1; $i < count($data); $i++) {
                $row = $data[$i];
                if (count($row) < 15)
                    continue;

                SuhuAbfAll::create([
                    'abf_validation_id' => $abf->id,
                    'time' => isset($row[0]) ? date('H:i:s', strtotime($row[0])) : null,
                    'ch1' => (float) str_replace(',', '.', $row[1]),
                    'ch2' => (float) str_replace(',', '.', $row[2]),
                    'ch3' => (float) str_replace(',', '.', $row[3]),
                    'ch4' => (float) str_replace(',', '.', $row[4]),
                    'ch5' => (float) str_replace(',', '.', $row[5]),
                    'ch6' => (float) str_replace(',', '.', $row[6]),
                    'ch7' => (float) str_replace(',', '.', $row[7]),
                    'ch8' => (float) str_replace(',', '.', $row[8]),
                    'ch9' => (float) str_replace(',', '.', $row[9]),
                    'ch10' => (float) str_replace(',', '.', $row[10]),
                    'titik1' => (float) str_replace(',', '.', $row[11]),
                    'titik2' => (float) str_replace(',', '.', $row[12]),
                    'titik3' => (float) str_replace(',', '.', $row[13]),
                    'titik4' => (float) str_replace(',', '.', $row[14]),
                ]);
            }

            DB::commit();
            return back()->with('success', 'Data suhu berhasil diunggah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        // return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }
    public function deleteABF($id)
    {
        $data = AbfValidation::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    // public function printABF($id)
    // {
    //     $dataABF = AbfValidation::findOrFail($id);
    //     $suhuData = SuhuAbfAll::where('abf_validation_id', $id)
    //         ->orderBy('time')
    //         ->get();

    //     $suhuAwal = $suhuData->first();
    //     $suhuAkhir = $suhuData->last();

    //     $dummyDate = '1970-01-01';
    //     $labels = $suhuData->map(function ($item) use ($dummyDate) {
    //         return \Carbon\Carbon::createFromFormat('H:i:s', $item->time)
    //             ->setDateFrom(\Carbon\Carbon::parse($dummyDate))
    //             ->toIso8601String();
    //     })->toArray();

    //     $startTime = $labels[0];
    //     $endTime = end($labels);

    //     $chartConfig = [
    //         'type' => 'line',
    //         'data' => [
    //             'labels' => $labels,
    //             'datasets' => [
    //                 [
    //                     'label' => 'Tilt 1 (ch1)',
    //                     'data' => $suhuData->pluck('ch1')->toArray(),
    //                     'borderColor' => 'rgb(255, 99, 132)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'Tilt 2 (ch2)',
    //                     'data' => $suhuData->pluck('ch2')->toArray(),
    //                     'borderColor' => 'rgb(54, 162, 235)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'Tilt 3 (ch3)',
    //                     'data' => $suhuData->pluck('ch3')->toArray(),
    //                     'borderColor' => 'rgb(255, 206, 86)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'Tilt 4 (ch4)',
    //                     'data' => $suhuData->pluck('ch4')->toArray(),
    //                     'borderColor' => 'rgb(75, 192, 192)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'Tilt 5 (ch5)',
    //                     'data' => $suhuData->pluck('ch5')->toArray(),
    //                     'borderColor' => 'rgb(153, 102, 255)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'Tilt 6 (ch6)',
    //                     'data' => $suhuData->pluck('ch6')->toArray(),
    //                     'borderColor' => 'rgb(255, 159, 64)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'Tilt 7 (ch7)',
    //                     'data' => $suhuData->pluck('ch7')->toArray(),
    //                     'borderColor' => 'rgb(138, 194, 74)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'Tilt 8 (ch8)',
    //                     'data' => $suhuData->pluck('ch8')->toArray(),
    //                     'borderColor' => 'rgb(234, 95, 137)',
    //                     'fill' => false
    //                 ],
    //                 [
    //                     'label' => 'T1.9 CENTER (ch9)',
    //                     'data' => $suhuData->pluck('ch9')->toArray(),
    //                     'borderColor' => 'rgb(11, 79, 108)',
    //                     'fill' => false,
    //                     'borderWidth' => 2
    //                 ]
    //             ]
    //         ],
    //         'options' => [
    //             'responsive' => true,
    //             'plugins' => [
    //                 'title' => [
    //                     'display' => true,
    //                     'text' => 'Grafik Sebaran Suhu Terhadap Waktu'
    //                 ],
    //                 'legend' => [
    //                     'position' => 'bottom'
    //                 ]
    //             ],
    //             'scales' => [
    //                 'y' => [
    //                     'min' => -30,
    //                     'max' => 0,
    //                     'title' => [
    //                         'display' => true,
    //                         'text' => 'Suhu (°C)'
    //                     ],
    //                     'ticks' => [
    //                         'stepSize' => 5
    //                     ]
    //                 ],
    //                 'x' => [
    //                     'type' => 'time',
    //                     'time' => [
    //                         'parser' => "YYYY-MM-DDTHH:mm:ssZ",
    //                         'unit' => 'minute',
    //                         'displayFormats' => [
    //                             'minute' => 'HH:mm'
    //                         ],
    //                         'tooltipFormat' => 'HH:mm'
    //                     ],
    //                     'min' => $startTime,
    //                     'max' => $endTime,
    //                     'title' => [
    //                         'display' => true,
    //                         'text' => 'Waktu'
    //                     ]
    //                 ]
    //             ]
    //         ]
    //     ];

    //     $chartUrl = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartConfig));

    //     dd($chartUrl);

    //     $pdf = PDF::loadView('validation.print.print_abf', [
    //         'dataABF' => $dataABF,
    //         'suhuAwal' => $suhuAwal,
    //         'suhuAkhir' => $suhuAkhir,
    //         'suhuData' => $suhuAkhir,
    //         'chartUrl' => $chartUrl
    //     ])->setOptions(['isRemoteEnabled' => true]);

    //     return $pdf->stream('laporan-abf-' . $dataABF->nama_produk . '.pdf');
    // }

    public function printABF($id)
    {
        $dataABF = AbfValidation::findOrFail($id);
        $suhuData = SuhuAbfAll::where('abf_validation_id', $id)
            ->orderBy('time')
            ->get();

        $suhuAwal = $suhuData->first();
        $suhuAkhir = $suhuData->last();

        $startTime = \Carbon\Carbon::parse($suhuData->first()->time)->format('Y-m-d H:i:s');
        $endTime = \Carbon\Carbon::parse($suhuData->last()->time)->format('Y-m-d H:i:s');

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $suhuData->map(function ($item) {
                    return \Carbon\Carbon::parse($item->time)->format('H:i');
                })->toArray(),
                'datasets' => [
                    [
                        'label' => 'Tilt 1 (ch1)',
                        'data' => $suhuData->pluck('ch1')->toArray(),
                        'borderColor' => 'rgb(255, 99, 132)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Tilt 2 (ch2)',
                        'data' => $suhuData->pluck('ch2')->toArray(),
                        'borderColor' => 'rgb(54, 162, 235)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Tilt 3 (ch3)',
                        'data' => $suhuData->pluck('ch3')->toArray(),
                        'borderColor' => 'rgb(255, 206, 86)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Tilt 4 (ch4)',
                        'data' => $suhuData->pluck('ch4')->toArray(),
                        'borderColor' => 'rgb(75, 192, 192)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Tilt 5 (ch5)',
                        'data' => $suhuData->pluck('ch5')->toArray(),
                        'borderColor' => 'rgb(153, 102, 255)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Tilt 6 (ch6)',
                        'data' => $suhuData->pluck('ch6')->toArray(),
                        'borderColor' => 'rgb(255, 159, 64)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Tilt 7 (ch7)',
                        'data' => $suhuData->pluck('ch7')->toArray(),
                        'borderColor' => 'rgb(138, 194, 74)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Tilt 8 (ch8)',
                        'data' => $suhuData->pluck('ch8')->toArray(),
                        'borderColor' => 'rgb(234, 95, 137)',
                        'fill' => false
                    ],
                    [
                        'label' => 'T1.9 CENTER (ch9)',
                        'data' => $suhuData->pluck('ch9')->toArray(),
                        'borderColor' => 'rgb(11, 79, 108)',
                        'fill' => false,
                        'borderWidth' => 2
                    ]
                ]
            ],
            'options' => [
                'responsive' => true,
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Grafik Sebaran Suhu Terhadap Waktu'
                    ],
                    'legend' => [
                        'position' => 'bottom'
                    ]
                ],
                'scales' => [
                    'y' => [
                        'min' => -30,
                        'max' => 0,
                        'title' => [
                            'display' => true,
                            'text' => 'Suhu (°C)'
                        ],
                        'ticks' => [
                            'stepSize' => 5
                        ]
                    ],
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => 'minute',
                            'displayFormats' => [
                                'minute' => 'HH:mm'
                            ]
                        ],
                        'min' => $startTime,
                        'max' => $endTime,
                        'title' => [
                            'display' => true,
                            'text' => 'Waktu'
                        ]
                    ]
                ]
            ]
        ];

        // Generate chart URL
        $chartUrl = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartConfig));

        $pdf = PDF::loadView('validation.print.print_abf', [
            'dataABF' => $dataABF,
            'suhuAwal' => $suhuAwal,
            'suhuAkhir' => $suhuAkhir,
            'suhuData' => $suhuAkhir,
            'chartUrl' => $chartUrl
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