<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AbfValidation;
use App\Models\FryerMarelValidation;
use App\Models\SuhuAbfAll;
use PDF;
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

    public function printScrewChiller()
    {
        $pdf = PDF::loadView('validation.print.print_screwChiller', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-screwchiller.pdf');
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
            'all_suhu' => 'required|mimes:xls,xlsx'
        ]);

        $abf = AbfValidation::create(array_merge($validated, []));

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
            return redirect('/validation/slaughterhouse/ABF')->with('success', 'Data suhu berhasil diunggah');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function deleteABF($id)
    {
        $data = AbfValidation::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function printABF($id)
    {
        $dataABF = AbfValidation::with('suhuAbfAll')->findOrFail($id);

        $suhuData = $dataABF->suhuAbfAll;

        $suhuAwal = $suhuData->first();
        $suhuAkhir = $suhuData->last();

        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $suhuData->map(function ($item) {
                    return \Carbon\Carbon::parse($item->time)->format('H:i');
                })->toArray(),
                'datasets' => [
                    [
                        'label' => 'Titik 1',
                        'data' => $suhuData->pluck('ch1')->toArray(),
                        'borderColor' => 'rgb(255, 99, 132)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 2',
                        'data' => $suhuData->pluck('ch2')->toArray(),
                        'borderColor' => 'rgb(54, 162, 235)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 3',
                        'data' => $suhuData->pluck('ch3')->toArray(),
                        'borderColor' => 'rgb(255, 206, 86)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 4',
                        'data' => $suhuData->pluck('ch4')->toArray(),
                        'borderColor' => 'rgb(75, 192, 192)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 5',
                        'data' => $suhuData->pluck('ch5')->toArray(),
                        'borderColor' => 'rgb(153, 102, 255)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 7',
                        'data' => $suhuData->pluck('ch7')->toArray(),
                        'borderColor' => 'rgb(138, 194, 74)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 8',
                        'data' => $suhuData->pluck('ch8')->toArray(),
                        'borderColor' => 'rgb(234, 95, 137)',
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik.9 CENTER',
                        'data' => $suhuData->pluck('ch9')->toArray(),
                        'borderColor' => 'rgb(11, 79, 108)',
                        'fill' => false,
                        'borderWidth' => 2
                    ]
                ]
            ],
            'options' => [
                'elements' => [
                    'point' => [
                        'radius' => 0
                    ]
                ],
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
                        'title' => [
                            'display' => true,
                            'text' => 'Waktu'
                        ]
                    ]
                ]
            ]
        ];

        $chartConfigPenetrasi = [
            'type' => 'line',
            'data' => [
                'labels' => $suhuData->map(function ($item) {
                    return \Carbon\Carbon::parse($item->time)->format('H:i');
                })->toArray(),
                'datasets' => [
                    [
                        'label' => 'Titik 1',
                        'data' => $suhuData->pluck('titik1')->toArray(),
                        'borderColor' => 'rgb(255, 99, 132)',
                        'fill' => false,
                    ],
                    [
                        'label' => 'Titik 2',
                        'data' => $suhuData->pluck('titik2')->toArray(),
                        'borderColor' => 'rgb(54, 162, 235)',
                        'fill' => false,
                    ],
                    [
                        'label' => 'Titik 3',
                        'data' => $suhuData->pluck('titik3')->toArray(),
                        'borderColor' => 'rgb(255, 206, 86)',
                        'fill' => false,
                    ],
                    [
                        'label' => 'Titik 4',
                        'data' => $suhuData->pluck('titik4')->toArray(),
                        'borderColor' => 'rgb(75, 192, 192)',
                        'fill' => false,
                    ]
                ]
            ],
            'options' => [
                'elements' => [
                    'point' => [
                        'radius' => 0
                    ]
                ],
                'responsive' => true,
                'plugins' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Grafik Penetrasi Suhu 4 Posisi Pengukuran, Menggunakan Thermologger Ebro'
                    ],
                    'legend' => [
                        'position' => 'bottom'
                    ]
                ],
                'scales' => [
                    'y' => [
                        'min' => -25,
                        'max' => 0,
                        'title' => [
                            'display' => true,
                            'text' => 'Suhu (°C)'
                        ],
                        'ticks' => [
                            'stepSize' => 5,
                        ]
                    ],
                    'x' => [
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

        $chartUrlPenetrasi = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartConfigPenetrasi));

        $pdf = PDF::loadView('validation.print.print_abf', [
            'dataABF' => $dataABF,
            'suhuAwal' => $suhuAwal,
            'suhuAkhir' => $suhuAkhir,
            'suhuData' => $suhuData,
            'chartUrl' => $chartUrl,
            'chartUrlPenetrasi' => $chartUrlPenetrasi,
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

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

    public function printIQF()
    {
        $pdf = PDF::loadView('validation.print.print_IQF', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-IQF.pdf');
    }

    // further
    public function fryer1()
    {
        return view('validation.further.fryer1');
    }

    public function printFryer1()
    {
        $pdf = PDF::loadView('validation.print.print_fryer1', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-fryer1.pdf');
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

    public function printFryer2()
    {
        $pdf = PDF::loadView('validation.print.print_fryer2', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-fryer2.pdf');
    }

    public function fryerMarel()
    {
        return view('validation.further.fryerMarel');
    }

    public function fryerMarel_addData()
    {
        return view('validation.store.store_fryerMarel');
    }

    public function storeFryerMarel(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'nullable|string',
            'ingredient' => 'nullable|string',
            'kemasan' => 'nullable|string',
            'nama_mesin' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'target_suhu' => 'nullable|string',
            'start_pengujian' => 'nullable|date',
            'end_pengujian' => 'nullable|date',
            'setting_suhu_mesin' => 'nullable|string',
            'waktu_produk_infeed' => 'nullable|string',
            'suhu_awal_inti' => 'nullable|string',
            'suhu_akhir_inti' => 'nullable|string',
            'batch' => 'nullable|string',
            'waktu_pemasakan' => 'nullable|string',
            'nama_mesin_2' => 'nullable|string',
            'merek_mesin_2' => 'nullable|string',
            'tipe_mesin_2' => 'nullable|string',
            'speed_conv_mesin_2' => 'nullable|string',
            'kapasitas_mesin_2' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'alamat' => 'nullable|string',
            // 'all_suhu' => $filePath,
        ]);

        FryerMarelValidation::create($validated);


        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function printFryerMarel()
    {
        $pdf = PDF::loadView('validation.print.print_fryerMarel', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-fryer-marel.pdf');
    }

    public function hiCook()
    {
        return view('validation.further.hicook');
    }

    public function hiCook_addData()
    {
        return view('validation.store.store_hiCook');
    }

    public function printHicook()
    {
        $pdf = PDF::loadView('validation.print.print_hiCook', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-hiCook.pdf');
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

    public function printSmokehouse()
    {
        $pdf = PDF::loadView('validation.print.print_smokeHouse', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-smokehouse.pdf');
    }

    public function smokeHouseFessmann()
    {
        return view('validation.sausage.smokehouse_fessmann');
    }

    public function smokeHouseFessmann_addData()
    {
        return view('validation.store.store_smokeHouse_fessmann');
    }

    public function printSmokehouseFessmann()
    {
        $pdf = PDF::loadView('validation.print.print_smokeHouse_fessmann', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-smokehouse-fessmann.pdf');
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

    public function printAging()
    {
        $pdf = PDF::loadView('validation.print.print_aging', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-aging.pdf');
    }

    // laboratory
    public function autoclave1()
    {
        return view('validation.laboratory.autoclave_hl_36_ae');
    }

    public function autoclave1_addData()
    {
        return view('validation.store.store_autoclave1');
    }

    public function printAutoclave1()
    {
        $pdf = PDF::loadView('validation.print.print_autoclave1', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-autoclave1.pdf');
    }

    public function autoclave2()
    {
        return view('validation.laboratory.autoclave_hve_50');
    }

    public function autoclave2_addData()
    {
        return view('validation.store.store_autoclave2');
    }

    public function printAutoclave2()
    {
        $pdf = PDF::loadView('validation.print.print_autoclave2', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-autoclave2.pdf');
    }

    public function ovenMemert1()
    {
        return view('validation.laboratory.ovenmemert1');
    }

    public function ovenMemert1_addData()
    {
        return view('validation.store.store_ovenmemert1');
    }

    public function printOvenmemert1()
    {
        $pdf = PDF::loadView('validation.print.print_ovenmemert1', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-ovenmemert1.pdf');
    }

    public function ovenMemert2()
    {
        return view('validation.laboratory.ovenmemert2');
    }

    public function ovenMemert2_addData()
    {
        return view('validation.store.store_ovenmemert2');
    }

    public function printOvenmemert2()
    {
        $pdf = PDF::loadView('validation.print.print_ovenmemert2', [
        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-ovenmemert2.pdf');
    }
}