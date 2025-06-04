<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AbfValidation;
use App\Models\SuhuAbfAll;
use App\Models\Machine;

use App\Models\FryerProduct;
use App\Models\FryerTemperature;
use App\Models\FryerValidation;
use App\Models\HiCookProduct;
use App\Models\HiCookTemperature;
use App\Models\HiCookValidation;
use App\Models\Validation_asset;
use PDF;
use Illuminate\Support\Facades\Storage;

\Carbon\Carbon::setLocale('id');

use Illuminate\Support\Facades\DB;

class ValidationController extends Controller
{

    public function validation($machine_uuid, $uuid)
    {
        $machine = Machine::firstWhere('uuid', $machine_uuid);
        $asset = Validation_asset::firstWhere('uuid', $uuid);
        if ($machine->machine_name == 'ABF') {
            $dataABF = AbfValidation::where('machine_uuid', $uuid)->latest()->get();
            return view('validation.slaughterhouse.ABF', [
                'dataABF' => $dataABF,
                'asset' => $asset
            ]);
        } elseif ($machine->machine_name == 'Fryer') {
            $dataFryer = FryerValidation::where('machine_uuid', $uuid)->latest()->get();
            return view('validation.further.fryer', [
                'asset' => $asset,
                'dataFryer' => $dataFryer
            ]);
        } elseif ($machine->machine_name == 'Hi Cook') {
            $dataHiCook = HiCookValidation::where('machine_uuid', $uuid)->latest()->get();
            return view('validation.further.hicook', [
                'asset' => $asset,
                'dataHiCook' => $dataHiCook
            ]);
        }
    }

    public function addFryer($uuid)
    {
        $asset = Validation_asset::firstWhere('uuid', $uuid);
        $product = FryerProduct::where('machine_uuid', $uuid)->get();
        return view('validation.store.store_fryer', [
            'asset' => $asset,
            'product' => $product
        ]);
    }

    public function storeFryer(Request $request, $uuid)
    {
        $asset = Validation_asset::firstWhere('uuid', $uuid);
        $validated = $request->validate([
            'fryer_product_id' => 'required|exists:fryer_product,id',
            'ingredient' => 'nullable|string',
            'packaging' => 'nullable|string',
            'machine_name' => 'nullable|string',
            'dimension' => 'nullable|string',
            'target_temperature' => 'nullable|string',
            'start_testing' => 'nullable|date',
            'end_testing' => 'nullable|date',
            'product_infeed_time' => 'nullable|string',
            'initial_core_temperature' => 'nullable|string',
            'final_core_temperature' => 'nullable|string',
            'batch' => 'nullable|string',
            'cooking_time' => 'nullable|string',
            'machine_name_2' => 'nullable|string',
            'machine_brand_2' => 'nullable|string',
            'machine_type_2' => 'nullable|string',
            'machine_speed_conv_2' => 'nullable|string',
            'machine_capacity_2' => 'nullable|string',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'suhu_fryer_1' => 'required|file|mimes:xls,xlsx',
            'distribution_notes' => 'nullable|string',
            'chart_notes' => 'nullable|string',
            'out_of_range_notes' => 'nullable|string',
            'uniformity_notes' => 'nullable|string',
            'transcription_notes' => 'nullable|string',
            'conclusion' => 'nullable|string',
        ]);

        // Ambil nama produk dari ID
        $produk = FryerProduct::find($validated['fryer_product_id']);

        $validated['product_name'] = $produk->product_name;
        if ($produk->setting_min && $produk->setting_max) {
            $validated['setting_machine_temperature'] = "{$produk->setting_min}-{$produk->setting_max}";
        }
        $validated['machine_uuid'] = $uuid;
        // Simpan data utama
        $fryer = FryerValidation::create($validated);

        if ($request->hasFile('suhu_fryer_1')) {
            $file = $request->file('suhu_fryer_1');

            // Baca data dari Excel
            $data = Excel::toArray([], $file)[0]; // Ambil sheet pertama

            // Lewati header (baris pertama)
            $rows = array_slice($data, 1);

            foreach ($rows as $row) {
                FryerTemperature::create([
                    'fryer_validation_id' => $fryer->id,
                    'time' => $row[0] ?? null,
                    'speed' => $row[1] ?? null,
                    'ch1' => $this->parseTemperature($row[2] ?? null),
                    'ch2' => $this->parseTemperature($row[3] ?? null),
                    'ch3' => $this->parseTemperature($row[4] ?? null),
                    'ch4' => $this->parseTemperature($row[5] ?? null),
                    'ch5' => $this->parseTemperature($row[6] ?? null),
                    'ch6' => $this->parseTemperature($row[7] ?? null),
                    'ch7' => $this->parseTemperature($row[8] ?? null),
                    'ch8' => $this->parseTemperature($row[9] ?? null),
                    'ch9' => $this->parseTemperature($row[10] ?? null),
                    'ch10' => $this->parseTemperature($row[11] ?? null),
                    'display_machine' => $this->parseTemperature($row[12] ?? null),
                ]);
            }
        }

        return redirect('/validation/' . $asset->machine_uuid . '/' . $uuid)->with('success', 'Data berhasil disimpan!');
    }
    // NEW CODE
    // ----------------------------------------------------------------------------------------------------------------------------------------

    public function fryer1_addData()
    {
        $produkList = FryerProduct::all();
        return view('validation.store.store_fryer1', compact('produkList'));
    }

    public function storeFryer1(Request $request) {}

    public function deleteFryer1($id)
    {
        $dataFryer1 = FryerValidation::findOrFail($id);
        $dataFryer1->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function printFryer1($id, Request $request)
    {
        $dataFryer1 = FryerValidation::with('suhuFryer1')->findOrFail($id);

        $suhuData = $dataFryer1->suhuFryer1;
        $suhuAwal = $suhuData->first();
        $suhuAkhir = $suhuData->last();

        // Hitung durasi
        $duration = $suhuAwal->time && $suhuAkhir->time
            ? Carbon::parse($suhuAwal->time)->diff(Carbon::parse($suhuAkhir->time))
            : null;

        // 1. Ambil input dari DB jika ada, jika tidak gunakan input user
        $settingFromDB = $dataFryer1->setting_machine_temperature;
        $inputRange = $request->input('setting_machine_temperature', $settingFromDB ?? '155-170');

        // 2. Parse range dengan lebih robust
        $rangeParts = preg_split('/\s*-\s*/', trim($inputRange), 2);

        // 3. Validasi dan konversi
        $minSuhu = (float) ($rangeParts[0] ?? 155);
        $maxSuhu = (float) ($rangeParts[1] ?? $minSuhu + 15); // Default range 15° jika hanya 1 nilai

        // Deteksi anomaly dengan range terbaru
        $anomalies = $this->detectTemperatureAnomalies($suhuData, $minSuhu, $maxSuhu);

        $conclusion = $this->generateAnomalyConclusion($anomalies, $minSuhu, $maxSuhu);

        $chartFryer1 = [
            'type' => 'line',
            'data' => [
                'labels' => $suhuData->map(function ($item) {
                    return \Carbon\Carbon::parse($item->time)->format('H:i');
                })->toArray(),
                'datasets' => [
                    [
                        'label' => 'Titik 1',
                        'data' => $suhuData->pluck('ch1')->toArray(),
                        'borderColor' => '#FF6384', // Merah muda
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 2',
                        'data' => $suhuData->pluck('ch2')->toArray(),
                        'borderColor' => '#36A2EB', // Biru
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 3',
                        'data' => $suhuData->pluck('ch3')->toArray(),
                        'borderColor' => '#FFCE56', // Kuning
                        'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 4',
                        'data' => $suhuData->pluck('ch4')->toArray(),
                        'borderColor' => '#4BC0C0', // Cyan
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 5',
                        'data' => $suhuData->pluck('ch5')->toArray(),
                        'borderColor' => '#9966FF', // Ungu
                        'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 6',
                        'data' => $suhuData->pluck('ch6')->toArray(),
                        'borderColor' => '#FF9F40', // Oranye
                        'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 7',
                        'data' => $suhuData->pluck('ch7')->toArray(),
                        'borderColor' => '#8AC249', // Hijau muda
                        'backgroundColor' => 'rgba(138, 194, 73, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 8',
                        'data' => $suhuData->pluck('ch8')->toArray(),
                        'borderColor' => '#EA5F89', // Merah muda tua
                        'backgroundColor' => 'rgba(234, 95, 137, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 9',
                        'data' => $suhuData->pluck('ch9')->toArray(),
                        'borderColor' => '#0B4F6C', // Biru tua
                        'backgroundColor' => 'rgba(11, 79, 108, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 10',
                        'data' => $suhuData->pluck('ch10')->toArray(),
                        'borderColor' => '#63C8CD', // Biru hijau
                        'backgroundColor' => 'rgba(99, 200, 205, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
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
                        'min' => 0,
                        'max' => 0,
                        'title' => [
                            'display' => true,
                            'text' => 'Suhu',
                        ],
                        'ticks' => [
                            'stepSize' => 5
                        ]
                    ],
                    'x' => [
                        'title' => [
                            'display' => true,
                            'text' => 'Waktu',
                        ]
                    ]
                ]
            ]
        ];

        $chartUrlFryer1 = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartFryer1));

        $averagePerChannel = [];
        for ($i = 1; $i <= 10; $i++) {
            $channel = "ch{$i}";
            $values = $suhuData->pluck($channel)->filter(); // buang null/false
            $averagePerChannel[$channel] = $values->count() > 0 ? round($values->avg(), 2) : null;
        }

        $channels = collect(range(1, 10));

        // Hitung statistik untuk tiap channel
        $avg = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->avg('ch' . $ch)]);
        $max = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->max('ch' . $ch)]);
        $min = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->min('ch' . $ch)]);

        $avg['display_machine'] = $suhuData->avg('display_machine');
        $max['display_machine'] = $suhuData->max('display_machine');
        $min['display_machine'] = $suhuData->min('display_machine');

        // Cari MAX & MIN Spot
        $spotValues = [];
        foreach ($suhuData as $row) {
            foreach ($channels as $ch) {
                $spotValues[] = [
                    'channel' => $ch,
                    'value' => $row->{'ch' . $ch},
                ];
            }
        }

        $maxSpot = collect($spotValues)->sortByDesc('value')->first();
        $minSpot = collect($spotValues)->sortBy('value')->first();
        $avgAllSpot = collect($spotValues)->pluck('value')->avg();

        $pdf = PDF::loadView('validation.print.print_fryer1', [
            'dataFryer1' => $dataFryer1,
            'suhuAwal' => $suhuAwal,
            'suhuAkhir' => $suhuAkhir,
            'suhuData' => $suhuData,
            'chartUrlFryer1' => $chartUrlFryer1,
            'anomalies' => $anomalies,
            'minSuhu' => $minSuhu,
            'maxSuhu' => $maxSuhu,
            'conclusion' => $conclusion,
            'duration' => $duration,
            'averagePerChannel' => $averagePerChannel,
            'avg' => $avg,
            'max' => $max,
            'min' => $min,
            'maxSpot' => $maxSpot,
            'minSpot' => $minSpot,
            'avgAllSpot' => $avgAllSpot,

        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-Fryer-' . $dataFryer1->product_name . '.pdf');
    }
    // ----------------------------------------------------------------------------------------------------------------------------------------
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
        $pdf = PDF::loadView('validation.print.print_screwChiller', [])->setOptions(['isRemoteEnabled' => true])
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
            'all_suhu' => 'required|mimes:xls,xlsx',
            'notes_sebaran' => 'nullable|string',
            'notes_grafik' => 'nullable|string',
            'notes_durasi_spike' => 'nullable|string',
            'notes_spike' => 'nullable|string',
            'notes_tabel_penetrasi' => 'nullable|string',
            'notes_grafik_penetrasi' => 'nullable|string',
            'notes_stagnansi' => 'nullable|string',
            'notes_ketercapaian' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
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
        $pdf = PDF::loadView('validation.print.print_IQF', [])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-IQF.pdf');
    }

    // further


    public function fryer2()
    {
        $dataFryer2 = FryerValidation::latest()->get();
        return view('validation.further.fryer2', compact('dataFryer2'));
    }

    public function fryer2_addData()
    {
        $produkList = FryerProduct::all();
        return view('validation.store.store_fryer2', compact('produkList'));
    }

    public function storeFryer2(Request $request)
    {
        $validated = $request->validate([
            'produk_fryer_2_id' => 'required|exists:produk_fryer_2,id',
            'ingredient' => 'nullable|string',
            'kemasan' => 'nullable|string',
            'nama_mesin' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'target_suhu' => 'nullable|string',
            'start_pengujian' => 'nullable|date',
            'end_pengujian' => 'nullable|date',
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
            'suhu_fryer_2' => 'required|file|mimes:xls,xlsx',
            'notes_sebaran' => 'nullable|string',
            'notes_grafik' => 'nullable|string',
            'notes_luar_range' => 'nullable|string',
            'notes_keseragaman' => 'nullable|string',
            'notes_rekaman' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
        ]);

        // Ambil nama produk dari ID
        $produk = FryerProduct::find($validated['produk_fryer_2_id']);

        $validated['nama_produk'] = $produk->nama_produk;
        if ($produk->setting_min && $produk->setting_max) {
            $validated['setting_suhu_mesin'] = "{$produk->setting_min}-{$produk->setting_max}";
        }

        // Simpan data utama
        $fryer2 = FryerValidation::create($validated);

        if ($request->hasFile('suhu_fryer_2')) {
            $file = $request->file('suhu_fryer_2');

            // Baca data dari Excel
            $data = Excel::toArray([], $file)[0]; // Ambil sheet pertama

            // Lewati header (baris pertama)
            $rows = array_slice($data, 1);

            foreach ($rows as $row) {
                FryerTemperature::create([
                    'fryer2_validation_id' => $fryer2->id,
                    'time' => $row[0] ?? null, // Kolom A (Date&Time)
                    'speed' => $row[1] ?? null,      // Kolom B (Speed)
                    'ch1' => $this->parseTemperature($row[2] ?? null),
                    'ch2' => $this->parseTemperature($row[3] ?? null),
                    'ch3' => $this->parseTemperature($row[4] ?? null),
                    'ch4' => $this->parseTemperature($row[5] ?? null),
                    'ch5' => $this->parseTemperature($row[6] ?? null),
                    'ch6' => $this->parseTemperature($row[7] ?? null),
                    'ch7' => $this->parseTemperature($row[8] ?? null),
                    'ch8' => $this->parseTemperature($row[9] ?? null),
                    'ch9' => $this->parseTemperature($row[10] ?? null),
                    'ch10' => $this->parseTemperature($row[11] ?? null),
                    'display_mesin' => $this->parseTemperature($row[12] ?? null),
                ]);
            }
        }

        return redirect('/validation/further/fryer-2')->with('success', 'Data berhasil disimpan!');
    }

    public function deleteFryer2($id)
    {
        $dataFryer2 = FryerValidation::findOrFail($id);
        $dataFryer2->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function printFryer2($id, Request $request)
    {
        $dataFryer2 = FryerValidation::with('suhuFryer2')->findOrFail($id);

        $suhuData = $dataFryer2->suhuFryer2;
        $suhuAwal = $suhuData->first();
        $suhuAkhir = $suhuData->last();

        // Hitung durasi
        $duration = $suhuAwal->time && $suhuAkhir->time
            ? Carbon::parse($suhuAwal->time)->diff(Carbon::parse($suhuAkhir->time))
            : null;

        // 1. Ambil input dari DB jika ada, jika tidak gunakan input user
        $settingFromDB = $dataFryer2->setting_suhu_mesin;
        $inputRange = $request->input('setting_suhu_mesin', $settingFromDB ?? '155-170');

        // 2. Parse range dengan lebih robust
        $rangeParts = preg_split('/\s*-\s*/', trim($inputRange), 2);

        // 3. Validasi dan konversi
        $minSuhu = (float) ($rangeParts[0] ?? 155);
        $maxSuhu = (float) ($rangeParts[1] ?? $minSuhu + 15); // Default range 15° jika hanya 1 nilai

        // Deteksi anomaly dengan range terbaru
        $anomalies = $this->detectTemperatureAnomalies($suhuData, $minSuhu, $maxSuhu);

        $conclusion = $this->generateAnomalyConclusion($anomalies, $minSuhu, $maxSuhu);

        $chartFryer2 = [
            'type' => 'line',
            'data' => [
                'labels' => $suhuData->map(function ($item) {
                    return \Carbon\Carbon::parse($item->time)->format('H:i');
                })->toArray(),
                'datasets' => [
                    [
                        'label' => 'Titik 1',
                        'data' => $suhuData->pluck('ch1')->toArray(),
                        'borderColor' => '#FF6384', // Merah muda
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 2',
                        'data' => $suhuData->pluck('ch2')->toArray(),
                        'borderColor' => '#36A2EB', // Biru
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 3',
                        'data' => $suhuData->pluck('ch3')->toArray(),
                        'borderColor' => '#FFCE56', // Kuning
                        'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 4',
                        'data' => $suhuData->pluck('ch4')->toArray(),
                        'borderColor' => '#4BC0C0', // Cyan
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 5',
                        'data' => $suhuData->pluck('ch5')->toArray(),
                        'borderColor' => '#9966FF', // Ungu
                        'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 6',
                        'data' => $suhuData->pluck('ch6')->toArray(),
                        'borderColor' => '#FF9F40', // Oranye
                        'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 7',
                        'data' => $suhuData->pluck('ch7')->toArray(),
                        'borderColor' => '#8AC249', // Hijau muda
                        'backgroundColor' => 'rgba(138, 194, 73, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 8',
                        'data' => $suhuData->pluck('ch8')->toArray(),
                        'borderColor' => '#EA5F89', // Merah muda tua
                        'backgroundColor' => 'rgba(234, 95, 137, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 9',
                        'data' => $suhuData->pluck('ch9')->toArray(),
                        'borderColor' => '#0B4F6C', // Biru tua
                        'backgroundColor' => 'rgba(11, 79, 108, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 10',
                        'data' => $suhuData->pluck('ch10')->toArray(),
                        'borderColor' => '#63C8CD', // Biru hijau
                        'backgroundColor' => 'rgba(99, 200, 205, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
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
                        'min' => 0,
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

        $chartUrlFryer2 = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartFryer2));

        $averagePerChannel = [];
        for ($i = 1; $i <= 10; $i++) {
            $channel = "ch{$i}";
            $values = $suhuData->pluck($channel)->filter(); // buang null/false
            $averagePerChannel[$channel] = $values->count() > 0 ? round($values->avg(), 2) : null;
        }

        $channels = collect(range(1, 10));

        // Hitung statistik untuk tiap channel
        $avg = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->avg('ch' . $ch)]);
        $max = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->max('ch' . $ch)]);
        $min = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->min('ch' . $ch)]);

        $avg['display_mesin'] = $suhuData->avg('display_mesin');
        $max['display_mesin'] = $suhuData->max('display_mesin');
        $min['display_mesin'] = $suhuData->min('display_mesin');

        // Cari MAX & MIN Spot
        $spotValues = [];
        foreach ($suhuData as $row) {
            foreach ($channels as $ch) {
                $spotValues[] = [
                    'channel' => $ch,
                    'value' => $row->{'ch' . $ch},
                ];
            }
        }

        $maxSpot = collect($spotValues)->sortByDesc('value')->first();
        $minSpot = collect($spotValues)->sortBy('value')->first();
        $avgAllSpot = collect($spotValues)->pluck('value')->avg();

        $pdf = PDF::loadView('validation.print.print_Fryer2', [
            'dataFryer2' => $dataFryer2,
            'suhuAwal' => $suhuAwal,
            'suhuAkhir' => $suhuAkhir,
            'suhuData' => $suhuData,
            'chartUrlFryer2' => $chartUrlFryer2,
            'anomalies' => $anomalies,
            'minSuhu' => $minSuhu,
            'maxSuhu' => $maxSuhu,
            'conclusion' => $conclusion,
            'duration' => $duration,
            'averagePerChannel' => $averagePerChannel,
            'avg' => $avg,
            'max' => $max,
            'min' => $min,
            'maxSpot' => $maxSpot,
            'minSpot' => $minSpot,
            'avgAllSpot' => $avgAllSpot,

        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-Fryer-' . $dataFryer2->nama_produk . '.pdf');
    }

    public function fryerMarel()
    {
        $dataFryerMarel = FryerValidation::latest()->get();
        return view('validation.further.fryerMarel', compact('dataFryerMarel'));
    }

    public function fryerMarel_addData()
    {
        $produkList = FryerProduct::all();
        return view('validation.store.store_fryerMarel', compact('produkList'));
    }

    public function storeFryerMarel(Request $request)
    {
        $validated = $request->validate([
            'produk_fryer_marel_id' => 'required|exists:produk_fryer_marel,id',
            'ingredient' => 'nullable|string',
            'kemasan' => 'nullable|string',
            'nama_mesin' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'target_suhu' => 'nullable|string',
            'start_pengujian' => 'nullable|date',
            'end_pengujian' => 'nullable|date',
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
            'suhu_fryer_marel' => 'required|file|mimes:xls,xlsx',
            'notes_sebaran' => 'nullable|string',
            'notes_grafik' => 'nullable|string',
            'notes_luar_range' => 'nullable|string',
            'notes_keseragaman' => 'nullable|string',
            'notes_rekaman' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
        ]);

        // Ambil nama produk dari ID
        $produk = FryerProduct::find($validated['produk_fryer_marel_id']);

        $validated['nama_produk'] = $produk->nama_produk;
        if ($produk->setting_min && $produk->setting_max) {
            $validated['setting_suhu_mesin'] = "{$produk->setting_min}-{$produk->setting_max}";
        }

        // Simpan data utama
        $fryerMarel = FryerValidation::create($validated);

        if ($request->hasFile('suhu_fryer_marel')) {
            $file = $request->file('suhu_fryer_marel');

            // Baca data dari Excel
            $data = Excel::toArray([], $file)[0]; // Ambil sheet pertama

            // Lewati header (baris pertama)
            $rows = array_slice($data, 1);

            foreach ($rows as $row) {
                FryerTemperature::create([
                    'fryer_marel_validation_id' => $fryerMarel->id,
                    'time' => $row[0] ?? null, // Kolom A (Date&Time)
                    'speed' => $row[1] ?? null,      // Kolom B (Speed)
                    'ch1' => $this->parseTemperature($row[2] ?? null),
                    'ch2' => $this->parseTemperature($row[3] ?? null),
                    'ch3' => $this->parseTemperature($row[4] ?? null),
                    'ch4' => $this->parseTemperature($row[5] ?? null),
                    'ch5' => $this->parseTemperature($row[6] ?? null),
                    'ch6' => $this->parseTemperature($row[7] ?? null),
                    'ch7' => $this->parseTemperature($row[8] ?? null),
                    'ch8' => $this->parseTemperature($row[9] ?? null),
                    'ch9' => $this->parseTemperature($row[10] ?? null),
                    'ch10' => $this->parseTemperature($row[11] ?? null),
                    'display_mesin' => $this->parseTemperature($row[12] ?? null),
                ]);
            }
        }

        return redirect('/validation/further/fryer-marel')->with('success', 'Data berhasil disimpan!');
    }

    public function deleteFryerMarel($id)
    {
        $dataFryerMarel = FryerValidation::findOrFail($id);
        $dataFryerMarel->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function printFryerMarel($id, Request $request)
    {
        $dataFryerMarel = FryerValidation::with('suhuFryerMarel')->findOrFail($id);

        $suhuData = $dataFryerMarel->suhuFryerMarel;
        $suhuAwal = $suhuData->first();
        $suhuAkhir = $suhuData->last();

        // Hitung durasi
        $duration = $suhuAwal->time && $suhuAkhir->time
            ? Carbon::parse($suhuAwal->time)->diff(Carbon::parse($suhuAkhir->time))
            : null;

        // 1. Ambil input dari DB jika ada, jika tidak gunakan input user
        $settingFromDB = $dataFryerMarel->setting_suhu_mesin;
        $inputRange = $request->input('setting_suhu_mesin', $settingFromDB ?? '155-170');

        // 2. Parse range dengan lebih robust
        $rangeParts = preg_split('/\s*-\s*/', trim($inputRange), 2);

        // 3. Validasi dan konversi
        $minSuhu = (float) ($rangeParts[0] ?? 155);
        $maxSuhu = (float) ($rangeParts[1] ?? $minSuhu + 15); // Default range 15° jika hanya 1 nilai

        // Deteksi anomaly dengan range terbaru
        $anomalies = $this->detectTemperatureAnomalies($suhuData, $minSuhu, $maxSuhu);

        $conclusion = $this->generateAnomalyConclusion($anomalies, $minSuhu, $maxSuhu);

        $chartFryerMarel = [
            'type' => 'line',
            'data' => [
                'labels' => $suhuData->map(function ($item) {
                    return \Carbon\Carbon::parse($item->time)->format('H:i');
                })->toArray(),
                'datasets' => [
                    [
                        'label' => 'Titik 1',
                        'data' => $suhuData->pluck('ch1')->toArray(),
                        'borderColor' => '#FF6384', // Merah muda
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 2',
                        'data' => $suhuData->pluck('ch2')->toArray(),
                        'borderColor' => '#36A2EB', // Biru
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 3',
                        'data' => $suhuData->pluck('ch3')->toArray(),
                        'borderColor' => '#FFCE56', // Kuning
                        'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 4',
                        'data' => $suhuData->pluck('ch4')->toArray(),
                        'borderColor' => '#4BC0C0', // Cyan
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 5',
                        'data' => $suhuData->pluck('ch5')->toArray(),
                        'borderColor' => '#9966FF', // Ungu
                        'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 6',
                        'data' => $suhuData->pluck('ch6')->toArray(),
                        'borderColor' => '#FF9F40', // Oranye
                        'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 7',
                        'data' => $suhuData->pluck('ch7')->toArray(),
                        'borderColor' => '#8AC249', // Hijau muda
                        'backgroundColor' => 'rgba(138, 194, 73, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 8',
                        'data' => $suhuData->pluck('ch8')->toArray(),
                        'borderColor' => '#EA5F89', // Merah muda tua
                        'backgroundColor' => 'rgba(234, 95, 137, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 9',
                        'data' => $suhuData->pluck('ch9')->toArray(),
                        'borderColor' => '#0B4F6C', // Biru tua
                        'backgroundColor' => 'rgba(11, 79, 108, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 10',
                        'data' => $suhuData->pluck('ch10')->toArray(),
                        'borderColor' => '#63C8CD', // Biru hijau
                        'backgroundColor' => 'rgba(99, 200, 205, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
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
                        'min' => 0,
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

        $chartUrlFryerMarel = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartFryerMarel));

        $averagePerChannel = [];
        for ($i = 1; $i <= 10; $i++) {
            $channel = "ch{$i}";
            $values = $suhuData->pluck($channel)->filter(); // buang null/false
            $averagePerChannel[$channel] = $values->count() > 0 ? round($values->avg(), 2) : null;
        }

        $channels = collect(range(1, 10));

        // Hitung statistik untuk tiap channel
        $avg = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->avg('ch' . $ch)]);
        $max = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->max('ch' . $ch)]);
        $min = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->min('ch' . $ch)]);

        $avg['display_mesin'] = $suhuData->avg('display_mesin');
        $max['display_mesin'] = $suhuData->max('display_mesin');
        $min['display_mesin'] = $suhuData->min('display_mesin');

        // Cari MAX & MIN Spot
        $spotValues = [];
        foreach ($suhuData as $row) {
            foreach ($channels as $ch) {
                $spotValues[] = [
                    'channel' => $ch,
                    'value' => $row->{'ch' . $ch},
                ];
            }
        }

        $maxSpot = collect($spotValues)->sortByDesc('value')->first();
        $minSpot = collect($spotValues)->sortBy('value')->first();
        $avgAllSpot = collect($spotValues)->pluck('value')->avg();

        $pdf = PDF::loadView('validation.print.print_fryerMarel', [
            'dataFryerMarel' => $dataFryerMarel,
            'suhuAwal' => $suhuAwal,
            'suhuAkhir' => $suhuAkhir,
            'suhuData' => $suhuData,
            'chartUrlFryerMarel' => $chartUrlFryerMarel,
            'anomalies' => $anomalies,
            'minSuhu' => $minSuhu,
            'maxSuhu' => $maxSuhu,
            'conclusion' => $conclusion,
            'duration' => $duration,
            'averagePerChannel' => $averagePerChannel,
            'avg' => $avg,
            'max' => $max,
            'min' => $min,
            'maxSpot' => $maxSpot,
            'minSpot' => $minSpot,
            'avgAllSpot' => $avgAllSpot,

        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-Fryer-' . $dataFryerMarel->nama_produk . '.pdf');
    }

    public function hiCook()
    {
        $dataHiCook = HiCookValidation::latest()->get();
        return view('validation.further.hicook', compact('dataHiCook'));
    }

    public function hiCook_addData()
    {
        $produkList = HiCookProduct::all();
        return view('validation.store.store_hiCook', compact('produkList'));
    }

    public function storeHiCook(Request $request)
    {
        $validated = $request->validate([
            'produk_hi_cook_id' => 'required|exists:produk_hi_cook,id',
            'ingredient' => 'nullable|string',
            'kemasan' => 'nullable|string',
            'nama_mesin' => 'nullable|string',
            'dimensi' => 'nullable|string',
            'target_suhu' => 'nullable|string',
            'start_pengujian' => 'nullable|date',
            'end_pengujian' => 'nullable|date',
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
            'suhu_hi_cook' => 'required|file|mimes:xls,xlsx',
            'notes_sebaran' => 'nullable|string',
            'notes_grafik' => 'nullable|string',
            'notes_luar_range' => 'nullable|string',
            'notes_keseragaman' => 'nullable|string',
            'notes_rekaman' => 'nullable|string',
            'kesimpulan' => 'nullable|string',
        ]);

        // Ambil nama produk dari ID
        $produk = HiCookProduct::find($validated['produk_hi_cook_id']);

        $validated['nama_produk'] = $produk->nama_produk;
        if ($produk->min && $produk->max) {
            $validated['setting_suhu_mesin'] = "{$produk->min}-{$produk->max}";
        }

        // Simpan data utama
        $hiCook = HiCookValidation::create($validated);

        if ($request->hasFile('suhu_hi_cook')) {
            $file = $request->file('suhu_hi_cook');

            // Baca data dari Excel
            $data = Excel::toArray([], $file)[0]; // Ambil sheet pertama

            // Lewati header (baris pertama)
            $rows = array_slice($data, 1);

            foreach ($rows as $row) {
                HiCookTemperature::create([
                    'hi_cook_validation_id' => $hiCook->id,
                    'time' => $row[0] ?? null, // Kolom A (Date&Time)
                    'speed' => $row[1] ?? null,      // Kolom B (Speed)
                    'ch1' => $this->parseTemperature($row[2] ?? null),
                    'ch2' => $this->parseTemperature($row[3] ?? null),
                    'ch3' => $this->parseTemperature($row[4] ?? null),
                    'ch4' => $this->parseTemperature($row[5] ?? null),
                    'ch5' => $this->parseTemperature($row[6] ?? null),
                    'ch6' => $this->parseTemperature($row[7] ?? null),
                    'ch7' => $this->parseTemperature($row[8] ?? null),
                    'ch8' => $this->parseTemperature($row[9] ?? null),
                    'ch9' => $this->parseTemperature($row[10] ?? null),
                    'ch10' => $this->parseTemperature($row[11] ?? null),
                    'display_mesin' => $this->parseTemperature($row[12] ?? null),
                ]);
            }
        }

        return redirect('/validation/further/hi-cook')->with('success', 'Data berhasil disimpan!');
    }

    public function deleteHiCook($id)
    {
        $dataHiCook = HiCookValidation::findOrFail($id);
        $dataHiCook->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function printHiCook($id, Request $request)
    {
        $dataHiCook = HiCookValidation::with('suhuHiCook')->findOrFail($id);

        $suhuData = $dataHiCook->suhuHiCook;
        $suhuAwal = $suhuData->first();
        $suhuAkhir = $suhuData->last();

        // Hitung durasi
        $duration = $suhuAwal->time && $suhuAkhir->time
            ? Carbon::parse($suhuAwal->time)->diff(Carbon::parse($suhuAkhir->time))
            : null;

        // 1. Ambil input dari DB jika ada, jika tidak gunakan input user
        $settingFromDB = $dataHiCook->setting_suhu_mesin;
        $inputRange = $request->input('setting_suhu_mesin', $settingFromDB ?? '155-170');

        // 2. Parse range dengan lebih robust
        $rangeParts = preg_split('/\s*-\s*/', trim($inputRange), 2);

        // 3. Validasi dan konversi
        $minSuhu = (float) ($rangeParts[0] ?? 155);
        $maxSuhu = (float) ($rangeParts[1] ?? $minSuhu + 15); // Default range 15° jika hanya 1 nilai

        // Deteksi anomaly dengan range terbaru
        $anomalies = $this->detectTemperatureAnomalies($suhuData, $minSuhu, $maxSuhu);

        $conclusion = $this->generateAnomalyConclusion($anomalies, $minSuhu, $maxSuhu);

        $chartHiCook = [
            'type' => 'line',
            'data' => [
                'labels' => $suhuData->map(function ($item) {
                    return \Carbon\Carbon::parse($item->time)->format('H:i');
                })->toArray(),
                'datasets' => [
                    [
                        'label' => 'Titik 1',
                        'data' => $suhuData->pluck('ch1')->toArray(),
                        'borderColor' => '#FF6384', // Merah muda
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 2',
                        'data' => $suhuData->pluck('ch2')->toArray(),
                        'borderColor' => '#36A2EB', // Biru
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 3',
                        'data' => $suhuData->pluck('ch3')->toArray(),
                        'borderColor' => '#FFCE56', // Kuning
                        'backgroundColor' => 'rgba(255, 206, 86, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 4',
                        'data' => $suhuData->pluck('ch4')->toArray(),
                        'borderColor' => '#4BC0C0', // Cyan
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 5',
                        'data' => $suhuData->pluck('ch5')->toArray(),
                        'borderColor' => '#9966FF', // Ungu
                        'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 6',
                        'data' => $suhuData->pluck('ch6')->toArray(),
                        'borderColor' => '#FF9F40', // Oranye
                        'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 7',
                        'data' => $suhuData->pluck('ch7')->toArray(),
                        'borderColor' => '#8AC249', // Hijau muda
                        'backgroundColor' => 'rgba(138, 194, 73, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 8',
                        'data' => $suhuData->pluck('ch8')->toArray(),
                        'borderColor' => '#EA5F89', // Merah muda tua
                        'backgroundColor' => 'rgba(234, 95, 137, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 9',
                        'data' => $suhuData->pluck('ch9')->toArray(),
                        'borderColor' => '#0B4F6C', // Biru tua
                        'backgroundColor' => 'rgba(11, 79, 108, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'label' => 'Titik 10',
                        'data' => $suhuData->pluck('ch10')->toArray(),
                        'borderColor' => '#63C8CD', // Biru hijau
                        'backgroundColor' => 'rgba(99, 200, 205, 0.2)',
                        'borderWidth' => 2,
                        'fill' => false
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
                        'min' => 0,
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

        $chartUrlHiCook = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($chartHiCook));

        $averagePerChannel = [];
        for ($i = 1; $i <= 10; $i++) {
            $channel = "ch{$i}";
            $values = $suhuData->pluck($channel)->filter(); // buang null/false
            $averagePerChannel[$channel] = $values->count() > 0 ? round($values->avg(), 2) : null;
        }

        $channels = collect(range(1, 10));

        // Hitung statistik untuk tiap channel
        $avg = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->avg('ch' . $ch)]);
        $max = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->max('ch' . $ch)]);
        $min = $channels->mapWithKeys(fn($ch) => ['ch' . $ch => $suhuData->min('ch' . $ch)]);

        $avg['display_mesin'] = $suhuData->avg('display_mesin');
        $max['display_mesin'] = $suhuData->max('display_mesin');
        $min['display_mesin'] = $suhuData->min('display_mesin');

        // Cari MAX & MIN Spot
        $spotValues = [];
        foreach ($suhuData as $row) {
            foreach ($channels as $ch) {
                $spotValues[] = [
                    'channel' => $ch,
                    'value' => $row->{'ch' . $ch},
                ];
            }
        }

        $maxSpot = collect($spotValues)->sortByDesc('value')->first();
        $minSpot = collect($spotValues)->sortBy('value')->first();
        $avgAllSpot = collect($spotValues)->pluck('value')->avg();

        $pdf = PDF::loadView('validation.print.print_HiCook', [
            'dataHiCook' => $dataHiCook,
            'suhuAwal' => $suhuAwal,
            'suhuAkhir' => $suhuAkhir,
            'suhuData' => $suhuData,
            'chartUrlHiCook' => $chartUrlHiCook,
            'anomalies' => $anomalies,
            'minSuhu' => $minSuhu,
            'maxSuhu' => $maxSuhu,
            'conclusion' => $conclusion,
            'duration' => $duration,
            'averagePerChannel' => $averagePerChannel,
            'avg' => $avg,
            'max' => $max,
            'min' => $min,
            'maxSpot' => $maxSpot,
            'minSpot' => $minSpot,
            'avgAllSpot' => $avgAllSpot,

        ])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-Fryer-' . $dataHiCook->nama_produk . '.pdf');
    }

    private function parseTemperature($value)
    {
        if (is_null($value)) {
            return null;
        }

        // Ubah koma menjadi titik untuk format desimal
        return str_replace(',', '.', $value);
    }

    private function detectTemperatureAnomalies($suhuData, $minSuhu, $maxSuhu)
    {
        $anomalies = [];
        $currentAnomalies = [];

        foreach ($suhuData as $data) {
            $waktu = \Carbon\Carbon::parse($data->time);

            for ($i = 1; $i <= 10; $i++) {
                $suhu = $data["ch{$i}"] ?? null;
                $isAnomaly = $suhu !== null && ($suhu < $minSuhu || $suhu > $maxSuhu);

                if ($isAnomaly) {
                    if (!isset($currentAnomalies[$i])) {
                        // Catat suhu awal saat pertama kali anomaly terjadi
                        $currentAnomalies[$i] = [
                            'titik' => $i,
                            'start_time' => $waktu,
                            'end_time' => $waktu,
                            'suhu_awal_anomali' => $suhu,
                            'suhu_terakhir' => $suhu,
                            'status' => $suhu < $minSuhu ? 'Rendah' : 'Tinggi'
                        ];
                    } else {
                        $currentAnomalies[$i]['end_time'] = $waktu;
                        $currentAnomalies[$i]['suhu_terakhir'] = $suhu;
                    }
                } elseif (isset($currentAnomalies[$i])) {
                    $currentAnomalies[$i]['duration'] =
                        $currentAnomalies[$i]['start_time']->diffInMinutes($currentAnomalies[$i]['end_time']);
                    $anomalies[] = $currentAnomalies[$i];
                    unset($currentAnomalies[$i]);
                }
            }
        }

        // Tambahkan anomaly yang masih berlangsung
        foreach ($currentAnomalies as $anomaly) {
            $anomaly['duration'] = $anomaly['start_time']->diffInMinutes($anomaly['end_time']);
            $anomalies[] = $anomaly;
        }

        return $anomalies;
    }

    private function generateAnomalyConclusion($anomalies)
    {
        $totalAnomalies = count($anomalies);

        // Inisialisasi variabel analisis
        $stats = [
            'low' => 0,
            'high' => 0,
            'points' => [],
            'durations' => [],
            'examples' => []
        ];

        foreach ($anomalies as $anomaly) {
            $stats[$anomaly['status'] === 'Rendah' ? 'low' : 'high']++;
            $stats['points'][$anomaly['titik']] = true;
            $stats['durations'][] = $anomaly['duration'];
            $stats['examples'][] = "Titik {$anomaly['titik']} ({$anomaly['duration']} menit)";
        }

        // Hitung statistik
        $pointList = implode(', ', array_keys($stats['points']));
        $avgDuration = round(array_sum($stats['durations']) / $totalAnomalies);
        $minDuration = min($stats['durations']);
        $maxDuration = max($stats['durations']);

        // Bangun kesimpulan deskriptif
        $conclusion = "<p class='conclusion'>Hasil analisis menunjukkan ";
        $conclusion .= "terdiri dari {$stats['low']} anomaly di bawah range dan {$stats['high']} anomaly di atas range. ";
        $conclusion .= "Penyimpangan terjadi di <strong>$pointList</strong> dengan durasi bervariasi antara $minDuration-$maxDuration menit ";
        $conclusion .= "(rata-rata $avgDuration detik per kejadian). ";
        $conclusion .= "Anomali tercepat terjadi selama $minDuration menit, sementara yang terlama mencapai $maxDuration menit. ";

        return $conclusion;
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
        $pdf = PDF::loadView('validation.print.print_smokeHouse', [])->setOptions(['isRemoteEnabled' => true])
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
        $pdf = PDF::loadView('validation.print.print_smokeHouse_fessmann', [])->setOptions(['isRemoteEnabled' => true])
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
        $pdf = PDF::loadView('validation.print.print_aging', [])->setOptions(['isRemoteEnabled' => true])
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
        $pdf = PDF::loadView('validation.print.print_autoclave1', [])->setOptions(['isRemoteEnabled' => true])
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
        $pdf = PDF::loadView('validation.print.print_autoclave2', [])->setOptions(['isRemoteEnabled' => true])
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
        $pdf = PDF::loadView('validation.print.print_ovenmemert1', [])->setOptions(['isRemoteEnabled' => true])
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
        $pdf = PDF::loadView('validation.print.print_ovenmemert2', [])->setOptions(['isRemoteEnabled' => true])
            ->setPaper('F4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('laporan-ovenmemert2.pdf');
    }
}