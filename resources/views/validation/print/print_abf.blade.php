<!DOCTYPE html>
<html>
<head>
    <title>Laporan Validasi ABF</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }

        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }

        /* Transparent Border Table */
        .table-transparent {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-transparent th,
        .table-transparent td {
            border: none;
            padding: 2px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        h2, h3, h4,h5 {
            margin-bottom: unset;
            padding-bottom: unset;
        }

        ul, ol {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;
        overflow:hidden;padding:2px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;
        font-weight:normal;overflow:hidden;padding:2px;word-break:normal;}
        .tg .tg-0lax{text-align:left;vertical-align:top}
    </style>
</head>
<body>
    {{-- header --}}
    <table class="table-transparent">
        <tr>
            <td style="width: 10%;">
                <img src="{{ storage_path('app/logo.png') }}" alt="Company Logo" style="width: 50px;">
            </td>
            <td>
                <h2 style="text-align: center; text-transform: uppercase;">HASIL VALIDASI MESIN <span>{{ $dataABF->nama_mesin }}</span> <br> <span>{{ $dataABF->lokasi }}</span> </h2>
            </td>
        </tr>
    </table>

    {{-- penetrasi suhu dingin --}}
    <h3 style="text-transform: uppercase; margin-top: 2rem;">penetrasi suhu dingin</h3>
    <table class="table-bordered mb-3" style="width: 40%;">
        <tr>
            <td style="padding: 4px;">Waktu Mulai Pengujian</td>
            <td style="padding: 4px;">{{ \Carbon\Carbon::parse($dataABF->start_pengujian)->translatedFormat('d F Y') }}</td>
            <td style="padding: 4px;">{{ \Carbon\Carbon::parse($dataABF->start_pengujian)->format('H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;">Waktu Akhir Pengujian</td>
            <td style="padding: 4px;">{{ \Carbon\Carbon::parse($dataABF->end_pengujian)->translatedFormat('d F Y') }}</td>
            <td style="padding: 4px;">{{ \Carbon\Carbon::parse($dataABF->end_pengujian)->format('H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;">Pengujian ke</td>
            <td colspan="2" style="padding: 4px;">{{ $dataABF ->pengujian }}</td>
        </tr>
    </table>

    <table class="table-bordered mb-3" style="width: 50%;">
        <tr>
            <td style="padding: 4px;">Nama Produk</td>
            <td style="padding: 4px;">{{ $dataABF ->nama_produk }}</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: .75rem;">
        <tr>
            <td style="width: 30%; border: 1px solid black; vertical-align: top; padding: 5px;">
                Ingredient <br>
                Kemasan <br>
                Nama Mesin <br>
                Dimensi (p x l x t) <br>
                Kapasitas ABF <br>
                Jumlah susunan dalam Rak <br>
                Isi rak saat pengujian <br>
                Penumpukan produk <br>
                Target Suhu Inti Produk <br>
                Set Suhu Thermostat
            </td>
            <td style="width: 70%; border: 1px solid black; vertical-align: top; padding: 5px;">
                {{ $dataABF ->ingredient }} <br>
                {{ $dataABF ->kemasan }} <br>
                {{ $dataABF ->nama_mesin }} <br>
                {{ $dataABF ->dimensi }} <br>
                {{ $dataABF ->kapasitas }} <br>
                {{ $dataABF ->susunan }} <br>
                {{ $dataABF ->isi_rak }} <br>
                {{ $dataABF ->penumpukan }} <br>
                {{ $dataABF ->target_suhu }} <br>
                {{ $dataABF ->set_thermostat }}
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 1rem; margin-bottom: unset;">Nama Mesin</h3>
    <p>{{ $dataABF ->nama_mesin_2 }}</p>
    <table class="table-bordered mb-3" style="width: 40%;">
        <tr>
            <td style="padding: 4px;">Merek</td>
            <td colspan="2" style="padding: 4px;">{{ $dataABF ->merek_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;">Tipe</td>
            <td colspan="2" style="padding: 4px;">{{ $dataABF ->tipe_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;">Freon</td>
            <td colspan="2" style="padding: 4px;">{{ $dataABF ->freon_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 4px;">Kapasitas</td>
            <td colspan="2" style="padding: 4px;">{{ $dataABF ->kapasitas_mesin_2 }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 1rem; margin-bottom: unset;">Lokasi</h3>
    <p>{{ $dataABF ->lokasi }}</p>
    <p>{{ $dataABF ->alamat }}</p>

    {{-- identifikasi --}}
    <div class="row mb-3">
        <h3>A. IDENTIFIKASI</h3>
        <ul style="list-style-type: none;">
            <li>1. Melakukan validasi kesesuaian distribusi suhu dalam ruang ABF</li>
            <li>2. Melakukan validasi kesesuaian penetrasi suhu pada produk Griller Yamiku pada saat proses blast freezing</li>
        </ul>
    </div>

    {{-- tujuan --}}
    <div class="row mb-3">
        <h3>B. TUJUAN</h3>
        <ul style="list-style-type: none;">
            <li>1. Mengetahui kinerja persebaran suhu ABF</li>
            <li>2. Mengetahui lama waktu yang dibutuhkan griller untuk mencapai suhu -18 °C</li>
        </ul>
    </div>

    {{-- peralatan --}}
    <div class="row mb-3">
        <h3>C. PERALATAN & LAYOUT</h3>
        <table width="100%" style="text-align: center;">
            <tr>
                <td width="50%">
                    @php
                        $path = public_path('storage/image/midilogger.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="midilogger" style="width: 80%; margin-bottom: 10px;">
                    <p>Midilogger Thermologger GL-260</p>
                </td>
                <td width="50%">
                    @php
                        $path = public_path('storage/image/ebro.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="thermologger" style="width: 80%; margin-bottom: 10px;">
                    <p>EBRO EBI-11 thermologger</p>
                </td>
            </tr>
        </table>

        <table width="100%" style="text-align: center;">
            <tr>
                <td width="50%">
                    <p><strong>LAYOUT PENEMPATAN SENSOR SEBARAN SUHU 9 TITIK</strong></p>
                    @php
                        $path = public_path('storage/image/layout1.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="probe" style="width: 80%; margin-bottom: 10px;">
                    <p><em>Gambar 1. Peletakan probe sensor suhu Thermocouple Tipe K untuk persebaran suhu</em></p>
                </td>
                <td width="50%">
                    <p><strong>LAYOUT PENEMPATAN SENSOR CORE TEMPERATURE PRODUK</strong></p>
                    @php
                        $path = public_path('storage/image/layout2.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="core" style="width: 80%; margin-bottom: 10px;">
                    <p><em>Gambar 2. Peletakan griller yang terisi thermologger</em></p>
                </td>
            </tr>
        </table>        
    </div>

    {{-- metode uji --}}
    <div class="row mb-3">
        <h3>D. METODE UJI</h3>
        <h5>Persebaran Suhu ABF</h5>
        <ul style="list-style-type: none;">
            <li>1. Probe Thermocouple Tipe K diletakkan pada setiap sisi ABF (gambar 1).</li>
            <li>2. Probe disambungkan ke Midilogger</li>
            <li>3. Midilogger diatur untuk interval pembacaan suhu setiap 5 menit</li>
            <li>4. Pintu ABF ditutup, dan perekaman suhu midilogger diaktifkan.</li>
            <li>5. Selesai</li>
        </ul>
    </div>
    
    {{-- penetrasi suhu produk --}}
    <div class="row mb-3">
        <h5>Penetrasi Suhu Produk</h5>
        <ul style="list-style-type: none;">
            <li>1. Thermologger EBRO EBI-11 diaktifkan, dan interval pembacaan diatur setiap 5 menit</li>
            <li>2. EBRO diletakkan pada griller bagian dada, dengan cara dibedah dan dijahit kembali</li>
            <li>3. Griller yang sudah terisi EBRO diletakkan pda titik yang direncanakan (gambar 2)</li>
            <li>4. Selesai</li>
        </ul>
    </div>

    {{-- tabel 1 uji persebaran suhu --}}
    <div class="row mb-3">
        <h3 style="margin-bottom: 1rem;">E. HASIL UJI PERSEBARAN SUHU</h3>
        <p>Uji persebaran suhu <span>{{ $dataABF->nama_mesin }}</span> dimulai pada tanggal <span>{{ \Carbon\Carbon::parse($dataABF->start_pengujian)->translatedFormat('d F Y') }}</span> pukul {{ \Carbon\Carbon::parse($dataABF->start_pengujian)->format('H:i:s') }} dan berakhir pada <span>{{ \Carbon\Carbon::parse($dataABF->end_pengujian)->translatedFormat('d F Y') }}</span> pukul {{ \Carbon\Carbon::parse($dataABF->end_pengujian)->format('H:i:s') }}. Selama periode tersebut, informasi terkait persebaran suhu adalah sebagai berikut:</p>

        {{-- @php
            // $suhuAwal = json_decode($dataABF->suhu_awal, true);
            // $suhuAkhir = json_decode($dataABF->suhu_akhir, true);
            // $suhuAkhirTercepat = null;

            $penurunanTerbesar = null;
            $titikTerbesar = null;

            foreach ($suhuAwal as $index => $awal) {
                $akhir = $suhuAkhir[$index] ?? null;
                if (!is_null($awal) && !is_null($akhir)) {
                    $penurunan = $awal - $akhir;

                    if (is_null($penurunanTerbesar) || $penurunan > $penurunanTerbesar) {
                        $penurunanTerbesar = $penurunan;

                        // Penyesuaian nomor titik
                        if ($index <= 5) {
                            $titikTerbesar = $index; // titik 1–5
                        } else {
                            $titikTerbesar = $index + 1; // lompatin ch6 yg tidak ada
                        }
                    }
                }
            }

            $hasil = "Durasi penurunan suhu tercepat terjadi pada titik {$titikTerbesar}, yakni dapat menurunkan suhu sebesar " .
                    number_format($penurunanTerbesar, 2) . " &deg;C (dari " .
                    number_format($suhuAwal[$titikTerbesar <= 5 ? $titikTerbesar : $titikTerbesar - 1], 2) .
                    " &deg;C ke " .
                    number_format($suhuAkhir[$titikTerbesar <= 5 ? $titikTerbesar : $titikTerbesar - 1], 2) . " &deg;C)";
                    
            // penurunan terlama
            $penurunanTerlambat = null;
            $titikTerlambat = null;

            foreach ($suhuAwal as $index => $awal) {
                $akhir = $suhuAkhir[$index] ?? null;
                if (!is_null($awal) && !is_null($akhir)) {
                    $penurunan = $awal - $akhir;

                    if ($penurunan >= 0 && (is_null($penurunanTerlambat) || $penurunan < $penurunanTerlambat)) {
                        $penurunanTerlambat = $penurunan;

                        // Penyesuaian nomor titik
                        if ($index <= 5) {
                            $titikTerlambat = $index;
                        } else {
                            $titikTerlambat = $index + 1;
                        }
                    }
                }
            }

            $awalSuhu = $suhuAwal[$titikTerlambat <= 5 ? $titikTerlambat : $titikTerlambat - 1];
            $akhirSuhu = $suhuAkhir[$titikTerlambat <= 5 ? $titikTerlambat : $titikTerlambat - 1];

            $hasilTerlambat = "Durasi penurunan suhu terlambat terjadi pada titik {$titikTerlambat}, yakni dapat menurunkan suhu sebesar " .
                            number_format($penurunanTerlambat, 2) . " &deg;C (dari " .
                            number_format($awalSuhu, 2) . " &deg;C ke " .
                            number_format($akhirSuhu, 2) . " &deg;C)";
                            $minSuhu = null;

            // selisih suhu antar titik terendah-tertinggi sebesar
            $maxSuhu = null;
            $titikMin = null;
            $titikMax = null;

            foreach ($suhuAkhir as $index => $value) {
                if (!is_null($value)) {
                    $floatValue = floatval($value);

                    if (is_null($minSuhu) || $floatValue < $minSuhu) {
                        $minSuhu = $floatValue;
                        $titikMin = $index <= 5 ? $index : $index + 1;
                    }

                    if (is_null($maxSuhu) || $floatValue > $maxSuhu) {
                        $maxSuhu = $floatValue;
                        $titikMax = $index <= 5 ? $index : $index + 1;
                    }
                }
            }

            $selisihSuhu = $minSuhu - $maxSuhu;

            $hasilSelisih = "Pada suhu akhir, selisih suhu antar titik terendah-tertinggi sebesar " .
                            number_format($selisihSuhu, 2) . " &deg;C " .
                            "((" . number_format($minSuhu, 2) . " &deg;C pada titik {$titikMin}) - (" .
                            number_format($maxSuhu, 2) . " &deg;C pada titik {$titikMax})).";
        @endphp --}}

        @php
            $penurunanMax = null;
            $titikMax = null;
            $suhuAwalMax = null;
            $suhuAkhirMax = null;

            for ($i = 1; $i <= 10; $i++) {
                $chKey = 'ch' . $i;

                if (isset($suhuAwal->$chKey) && isset($suhuAkhir->$chKey)) {
                    $awal = floatval($suhuAwal->$chKey);
                    $akhir = floatval($suhuAkhir->$chKey);
                    $penurunan = $awal - $akhir;

                    if (is_null($penurunanMax) || $penurunan > $penurunanMax) {
                        $penurunanMax = $penurunan;
                        $titikMax = $i;
                        $suhuAwalMax = $awal;
                        $suhuAkhirMax = $akhir;
                    }
                }
            }

            $penurunanMaxFormatted = number_format($penurunanMax, 2, ',', '.');
            $suhuAwalFormatted = number_format($suhuAwalMax, 2, ',', '.');
            $suhuAkhirFormatted = number_format($suhuAkhirMax, 2, ',', '.');

            $hasil = "Durasi penurunan suhu tercepat terjadi pada titik {$titikMax}, yakni dapat menurunkan suhu sebesar {$penurunanMaxFormatted} &deg;C (dari {$suhuAwalFormatted} &deg;C ke {$suhuAkhirFormatted} &deg;C)";

            // penurunan suhu terlama
            $penurunanMin = null;
            $titikMin = null;
            $suhuAwalMin = null;
            $suhuAkhirMin = null;

            for ($i = 1; $i <= 10; $i++) {
                // skip ch6 karena tidak digunakan
                if ($i === 6) continue;

                $chKey = 'ch' . $i;

                if (isset($suhuAwal->$chKey) && isset($suhuAkhir->$chKey)) {
                    $awal = floatval($suhuAwal->$chKey);
                    $akhir = floatval($suhuAkhir->$chKey);
                    $penurunan = $awal - $akhir;

                    // hanya hitung jika penurunan positif (suhu turun)
                    if ($penurunan > 0 && (is_null($penurunanMin) || $penurunan < $penurunanMin)) {
                        $penurunanMin = $penurunan;
                        $titikMin = $i;
                        $suhuAwalMin = $awal;
                        $suhuAkhirMin = $akhir;
                    }
                }
            }

            $penurunanMinFormatted = number_format($penurunanMin, 2, ',', '.');
            $suhuAwalMinFormatted = number_format($suhuAwalMin, 2, ',', '.');
            $suhuAkhirMinFormatted = number_format($suhuAkhirMin, 2, ',', '.');

            $hasilTerlambat = "Durasi penurunan suhu terlambat terjadi pada titik {$titikMin}, yakni dapat menurunkan suhu sebesar {$penurunanMinFormatted} &deg;C (dari {$suhuAwalMinFormatted} &deg;C ke {$suhuAkhirMinFormatted} &deg;C)";

            // selisih akhir
            $suhuAkhirData = [];

            for ($i = 1; $i <= 10; $i++) {
                if ($i === 6) continue; // lewati ch6
                $chKey = 'ch' . $i;

                if (isset($suhuAkhir->$chKey)) {
                    $suhu = floatval($suhuAkhir->$chKey);
                    $suhuAkhirData[$i] = $suhu;
                }
            }

            $minTitik = array_key_first($suhuAkhirData);
            $maxTitik = array_key_first($suhuAkhirData);
            $minSuhu = $suhuAkhirData[$minTitik];
            $maxSuhu = $suhuAkhirData[$maxTitik];

            foreach ($suhuAkhirData as $titik => $suhu) {
                if ($suhu < $minSuhu) {
                    $minSuhu = $suhu;
                    $minTitik = $titik;
                }

                if ($suhu > $maxSuhu) {
                    $maxSuhu = $suhu;
                    $maxTitik = $titik;
                }
            }

            $selisih = $minSuhu - $maxSuhu;
            $selisihFormatted = number_format($selisih, 2, ',', '.');
            $minSuhuFormatted = number_format($minSuhu, 2, ',', '.');
            $maxSuhuFormatted = number_format($maxSuhu, 2, ',', '.');

            $hasilSelisih = "Pada suhu akhir, selisih suhu antar titik terendah-tertinggi sebesar {$selisihFormatted} &deg;C (({$minSuhuFormatted} &deg;C pada titik {$minTitik}) - ({$maxSuhuFormatted} &deg;C pada titik {$maxTitik})).";
        @endphp

        <table class="table-bordered" style="width: 80%; margin: auto;">
            <thead>
                <tr>
                <th class="tg-0lax"></th>
                <th class="tg-0lax">Titik 1</th>
                <th class="tg-0lax">Titik 2</th>
                <th class="tg-0lax">titik 3</th>
                <th class="tg-0lax">titik 4</th>
                <th class="tg-0lax">titik 5</th>
                <th class="tg-0lax">titik 7</th>
                <th class="tg-0lax">titik 8</th>
                <th class="tg-0lax">titik 9 (center)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tg-0lax">SUHU AWAL</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch1 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch2 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch3 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch4 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch5 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch7 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch8 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch9 ?? '-' }}</td>
                </tr>
                <tr>
                <td class="tg-0lax">Durasi sejak start ABF (menit)</td>
                <td class="tg-0lax" colspan="8">0</td>
                </tr>
                <tr>
                <td class="tg-0lax">yakni pada jam </td>
                <td class="tg-0lax" colspan="8">{{ $suhuAwal->time ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="tg-0lax">SUHU AKHIR</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch1 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch2 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch3 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch4 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch5 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch7 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch8 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch9 ?? '-' }}</td>
                </tr>
                <tr>
                <td class="tg-0lax">Durasi sejak start ABF</td>
                <td class="tg-0lax" colspan="8">
                    @php
                        use Carbon\Carbon;

                        $jamAwal = isset($suhuAwal->time) ? Carbon::parse($suhuAwal->time) : null;
                        $jamAkhir = isset($suhuAkhir->time) ? Carbon::parse($suhuAkhir->time) : null;

                        $durasi = '-';
                        if ($jamAwal && $jamAkhir) {
                            if ($jamAkhir->lt($jamAwal)) {
                                $jamAkhir->addDay();
                            }

                            $totalMenit = $jamAkhir->diffInMinutes($jamAwal);
                            $jam = floor($totalMenit / 60);
                            $menit = $totalMenit % 60;
                            $durasi = $jam . ' jam ' . $menit . ' menit';
                        }
                    @endphp
                    
                    {{ $durasi }}
                </td>
                </tr>
                <tr>
                <td class="tg-0lax">yakni pada jam </td>
                <td class="tg-0lax" colspan="8">{{ $suhuAkhir->time ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Table 1.</strong> Hasil Pengukuran Persebaran Suhu Pada Ruang {{ $dataABF ->nama_mesin }}</p>

        {{-- <pre>{{ var_dump($suhuAwal) }}</pre> --}}

        <div>
            <p>Berdasarkan tabel di atas, dapat diperoleh informasi berupa:</p>
            <ul>
                <li>1. {!! $hasil !!}</li>
                <li>2. {!! $hasilTerlambat !!}</li>
                <li>3. {!! $hasilSelisih !!}</li>
            </ul>
        </div>
    </div>

    {{-- test grafik --}}
        <img src="{{ $chartUrl }}" style="width: 100%;">

    {{-- Grafik 1. Persebaran suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut:</p>
        {{-- <img src="{{ $chartUrl }}" style="width:100%; max-width:600px; margin: auto;"> --}}
        <p style="text-align: center;"> <strong>Grafik 1.</strong>  Persebaran Ruhu Ruang {{ $dataABF->nama_mesin }} </p>

        <p>Grafik sebaran suhu di atas menunjukkan bahwa pergerakan suhu dari awal ABF dimulai pada jam 16.12 berangsur turun secara linear. Pada saat ABF dinyalakan, suhu pada setiap
            titiknya berbeda-beda (terpaut perbedaan sebesar 10,8 °C, mulai dari titik tertinggi di titik 9 sebesar 9,90 °C dan terendah di titik 1 sebesar -0,90 °C). ABF dimatikan keesokan harinya
            pada jam 09.22, dan Thermocouple tipe K mendeteksi di suhu di setiap titiknya berbeda namun dengan range yang lebih sempit, yakni selisih suhu minimum ke maksimumnya sebesar -
            4,20 °C ((-27,90 °C pada titik 1) - (-23,70 °C pada titik 2)). Hal ini menunjukkan bahwa di suhu awal suhu dapat berbeda karena beberapa faktor, salah satunya adalah adanya aktivitas
            keluar masuk karyawan untuk menata rak satu demi satu hingga terisi penuh. Suhu akhir terdeteksi lebih merata (selisih antar titik tidak terpaut jauh) karena ruang ABF tertutup rapat
            sehingga satu-satunya aliran udara berasal dari hembusan 3 unit blower.</p>
        <p>Namun dalam prosesnya terdapat peristiwa lonjakan suhu sesaat (spike) sebanyak 3 kali selama proses blast freezing. Spike ini disebabkan oleh defrost, di mana pengaturan defrost
                ini acuannya adalah waktu (diatur setiap sekian jam sekali mesin akan mati). Spike pertama terjadi pada 2,9 jam sejak ABF dinyalakan, dan terjadi selama 47 menit. Spike kedua terjadi
                5,3 jam setelah spike pertama, selama 58 menit. Spike terakhir (ketiga) terjadi pada 6,3 jam setelah spike kedua berlangsung, selama 1,1 jam.Total terjadinya spike pada running ABF
                kali ini sebanyak 3 kali, dengan interval 5,2 jam sekali. Data terkait durasi spike dituangkan dalam tabel berikut ini:
        </p>
    </div>

    {{-- tabel 2 durasi keseluruhan spike --}}
    <div class="row mb-3">
        <table class="table-bordered mb-3"style="width: 80%; margin: auto;">
            <tr>
                <td style="padding: 4px;"></td>
                <td colspan="2" style="padding: 4px;">Durasi</td>
            </tr>
            <tr>
                <td style="padding: 4px;">Durasi dari ON ABF ke Spike 1</td>
                <td colspan="2" style="padding: 4px;">176 menit, atau 2,9 jam</td>
            </tr>
            <tr>
                <td style="padding: 4px;">Durasi Spike 1</td>
                <td colspan="2" style="padding: 4px;">47 menit</td>
            </tr>
            <tr>
                <td style="padding: 4px;">Durasi dari Spike 1 ke Spike 2</td>
                <td colspan="2" style="padding: 4px;">320 menit atau 5,3 jam</td>
            </tr>
            <tr>
                <td style="padding: 4px;">Durasi Spike 2</td>
                <td colspan="2" style="padding: 4px;">58 menit</td>
            </tr>
            <tr>
                <td style="padding: 4px;">Durasi dari Spike 2 ke Spike 3</td>
                <td colspan="2" style="padding: 4px;">309 menit atau 6,3 jam</td>
            </tr>
            <tr>
                <td style="padding: 4px;">Durasi Spike 3</td>
                <td colspan="2" style="padding: 4px;">65 menit atau 1,1 jam</td>
            </tr>
            <tr>
                <td style="padding: 4px;">Interval terjadinya Spike</td>
                <td colspan="2" style="padding: 4px;">5,2 jam sekali</td>
            </tr>
            
        </table>
        <p style="text-align: center;"> <strong>Table 2.</strong> Durasi Keseluruhan Terjadinya Spike Pertama, Kedua, dan Ketiga</p>

        <p class="mb-3">Spike pertama dimulai pada titik 1-2, 4, 5, 7-8 dan 9 pada jam 19:07, atau 2,9 jam setelah ABF dimulai yang disusul oleh titik yang lain pada rentang waktu 5 menit. Kenaikan suhu awal
            hingga puncak terjadi selama 5-10 menit, dengan suhu awal sampai suhu di puncak spike mengalami kenaikan sebesar 2-17°C, selama 5-10 menit. Penurunan suhu dari puncak spike
            sampai ke dasar terjadi selama 15-30 menit dengan penurunan suhu 2-17 °C. Total durasi terjadinya spike pertama adalah selama 45 sampai 50 menit. Data terkait peristiwa spike
            pertama dituangkan dalam tabel 3 berikut ini: </p>
    </div>

    {{-- tabel 3 durasi spike 1 --}}
    <div class="row mb-3">
        <table class="table-bordered mb-3" style="width: 100%; margin: auto;">
            <thead>
            <tr>
              <th class="tg-0lax"></th>
              <th class="tg-0lax">Titik 1</th>
              <th class="tg-0lax">Titik 2</th>
              <th class="tg-0lax">titik 3</th>
              <th class="tg-0lax">titik 4</th>
              <th class="tg-0lax">titik 5</th>
              <th class="tg-0lax">titik 7</th>
              <th class="tg-0lax">titik 8</th>
              <th class="tg-0lax">titik 9 (center)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td class="tg-0lax">Dimulai pada jam</td>
              <td class="tg-0lax">19:07:42</td>
              <td class="tg-0lax">19:07:42</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu awal</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Start to Peak (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu Puncak</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Puncak (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu Akhir</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Peak to End (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Total Durasi Spike (Menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Berakhir pada jam</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
            </tr>
            <tr>
              <td class="tg-0lax">Spike yang ke</td>
              <td class="tg-0lax" colspan="8">1</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Table 3.</strong> Durasi Terjadinya Spike Pertama</p>

        <p>
            Spike kedua dimulai pada 5,3 jam sejak spike pertama, yakni pada jam 01:12-01:22. Kenaikan suhu awal hingga puncak terjadi selama 15-25 menit dengan kenaikan suhu awal ke
            puncak sebesar 3-9 C, dengan durasi spike di puncaknya selama 5 menit. Penurunan suhu dari puncak spike sampai ke dasar terjadi selama 5-40 menit dengan penurunan suhu
            sebesar 3-9 C. Total durasi terjadinya spike kedua adalah selama 25 sampai 70 menit. Data terkait peristiwa spike kedua dituangkan dalam tabel 4 berikut ini:
        </p>
    </div>

    {{-- tabel 4 durasi spike 2 --}}
    <div class="row mb-3">
        <table class="table-bordered mb-3" style="width: 100%; margin: auto;">
            <thead>
            <tr>
              <th class="tg-0lax"></th>
              <th class="tg-0lax">Titik 1</th>
              <th class="tg-0lax">Titik 2</th>
              <th class="tg-0lax">titik 3</th>
              <th class="tg-0lax">titik 4</th>
              <th class="tg-0lax">titik 5</th>
              <th class="tg-0lax">titik 7</th>
              <th class="tg-0lax">titik 8</th>
              <th class="tg-0lax">titik 9 (center)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td class="tg-0lax">Dimulai pada jam</td>
              <td class="tg-0lax">19:07:42</td>
              <td class="tg-0lax">19:07:42</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu awal</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Start to Peak (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu Puncak</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Puncak (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu Akhir</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Peak to End (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Total Durasi Spike (Menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Berakhir pada jam</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
            </tr>
            <tr>
              <td class="tg-0lax">Spike yang ke</td>
              <td class="tg-0lax" colspan="8">2</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Table 4.</strong> Durasi Terjadinya Spike Kedua</p>

        <p>
            Spike ketiga terjadi pada 65 menit dari spike kedua, yakni pada jam 07:22-07:27. Kenaikan suhu awal hingga puncak terjadi selama 20-30 menit dengan kenaikan suhu
            awal ke puncak sebesar 4-9 C, dengan durasi spike di puncaknya selama 5-10 menit. Penurunan suhu dari puncak spike sampai ke dasar terjadi selama 15-40 menit
            dengan penurunan suhu sebesar 4-9 C. Total durasi terjadinya spike kedua adalah selama 40 sampai 75 menit. Data terkait peristiwa spike kedua dituangkan dalam
            tabel 5 berikut ini: 
        </p>
    </div>

    {{-- tabel 5 durasi spike 3 --}}
    <div class="row mb-3">
        <table class="table-bordered mb-3" style="width: 100%; margin: auto;">
            <thead>
            <tr>
              <th class="tg-0lax"></th>
              <th class="tg-0lax">Titik 1</th>
              <th class="tg-0lax">Titik 2</th>
              <th class="tg-0lax">titik 3</th>
              <th class="tg-0lax">titik 4</th>
              <th class="tg-0lax">titik 5</th>
              <th class="tg-0lax">titik 7</th>
              <th class="tg-0lax">titik 8</th>
              <th class="tg-0lax">titik 9 (center)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td class="tg-0lax">Dimulai pada jam</td>
              <td class="tg-0lax">19:07:42</td>
              <td class="tg-0lax">19:07:42</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu awal</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Start to Peak (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu Puncak</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Puncak (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Suhu Akhir</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Durasi Peak to End (menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Total Durasi Spike (Menit)</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
              <td class="tg-0lax">0</td>
            </tr>
            <tr>
              <td class="tg-0lax">Berakhir pada jam</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
              <td class="tg-0lax">00:00:00</td>
            </tr>
            <tr>
              <td class="tg-0lax">Spike yang ke</td>
              <td class="tg-0lax" colspan="8">3</td>
            </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Table 5.</strong> Durasi Terjadinya Spike Ketiga</p>
    </div>

    {{-- uji penetrasi suhu --}}
    <div class="row mb-3">
        <h3 style="margin-bottom: 1rem;">UJI PENETRASI SUHU</h3>
        <p class="mb-3">Sama seperti uji perataan suhu, uji penetrasi suhu {{ $dataABF->nama_mesin }} dimulai pada tanggal {{ \Carbon\Carbon::parse($dataABF->start_pengujian)->translatedFormat('d F Y') }} pukul {{ \Carbon\Carbon::parse($dataABF->start_pengujian)->format('H:i:s') }} dan berakhir pada {{ \Carbon\Carbon::parse($dataABF->end_pengujian)->translatedFormat('d F Y') }} pukul {{ \Carbon\Carbon::parse($dataABF->end_pengujian)->format('H:i:s') }}. Hal yang membedakan adalah uji ini dilakukan dengan cara menanamkan thermologger ke bagian dada ayam griller, dada ayam dibelah, probe diletakkan di posisi daging terdalam, kemudian ayam dijahit kembali. Interval pembacaan thermologger ini diset sama seperti Midilogger, yakni setiap 5 menit sekali. Selama periode tersebut, informasi terkait penetrasi suhu griller adalah sebagai berikut:
        </p>

        @php
            $suhuAwalPenetrasi = json_decode($dataABF->suhu_awal_penetrasi, true);
            $suhuAkhirPenetrasi = json_decode($dataABF->suhu_akhir_penetrasi, true);
            
            // Mapping titik names accounting for missing Titik 6
            $titikNamesPenetrasi = [
                1 => "Titik 1",
                2 => "Titik 2",
                3 => "Titik 3",
                4 => "Titik 4",
            ];

            // Initialize variables for fastest drop
            $maxDropPenetrasi = 0;
            $titikTercepatPenetrasi = null;
            $suhuAwalTercepatPenetrasi = null;
            $suhuAkhirTercepatPenetrasi = null;

            // Initialize variables for slowest drop
            $minDropPenetrasi = PHP_FLOAT_MAX;
            $titikTerlambatPenetrasi = null;
            $suhuAwalTerlambatPenetrasi = null;
            $suhuAkhirTerlambatPenetrasi = null;

            foreach ($suhuAwalPenetrasi as $index => $awalPenetrasi) {
                if (!isset($suhuAkhirPenetrasi[$index])) continue;

                $akhirPenetrasi = $suhuAkhirPenetrasi[$index];
                $dropPenetrasi = $awalPenetrasi - $akhirPenetrasi; // Positive value means temperature decreased

                // Check for fastest drop (largest difference)
                if ($dropPenetrasi > $maxDropPenetrasi) {
                    $maxDropPenetrasi = $dropPenetrasi;
                    $titikTercepatPenetrasi = $titikNamesPenetrasi[$index] ?? "Titik ".($index+1);
                    $suhuAwalTercepatPenetrasi = $awalPenetrasi;
                    $suhuAkhirTercepatPenetrasi = $akhirPenetrasi;
                }

                // Check for slowest drop (smallest difference)
                if ($dropPenetrasi < $minDropPenetrasi) {
                    $minDropPenetrasi = $dropPenetrasi;
                    $titikTerlambatPenetrasi = $titikNamesPenetrasi[$index] ?? "Titik ".($index+1);
                    $suhuAwalTerlambatPenetrasi = $awalPenetrasi;
                    $suhuAkhirTerlambatPenetrasi = $akhirPenetrasi;
                }
            }

            // Convert to absolute values for display
            $penurunanTercepatPenetrasi = abs($maxDropPenetrasi);
            $penurunanTerlambatPenetrasi = abs($minDropPenetrasi);

            $filteredAwal = array_values(array_filter($suhuAwalPenetrasi, function($val) {
                return !is_null($val);
            }));
            $filteredAkhir = array_values(array_filter($suhuAkhirPenetrasi, function($val) {
                return !is_null($val);
            }));

            // Ambil suhu awal tertinggi & terendah
            $minAwal = min($filteredAwal);
            $maxAwal = max($filteredAwal);  
            $minIndex = array_search($minAwal, $suhuAwalPenetrasi);
            $maxIndex = array_search($maxAwal, $suhuAwalPenetrasi);
            $selisihAwal = $maxAwal - $minAwal;
            // dd($minAwal, $maxAwal, $selisihAwal, );

            // Cari suhu minimum dan maksimum
            $minAkhir = min($filteredAkhir);
            $maxAkhir = max($filteredAkhir);
            $minIndex = array_search($minAkhir, $suhuAkhirPenetrasi);
            $maxIndex = array_search($maxAkhir, $suhuAkhirPenetrasi);
            $selisihAkhir = $maxAkhir - $minAkhir;

            // Buat output naratif
            $deskripsiSelisihAwal = "Secara keseluruhan, dengan melihat selisih suhu awal dari keempat griller terdapat selisih min-maks sebesar "
                . number_format($selisihAwal, 1, ',', '.') . " &deg;C "
                . "(" . number_format($maxAwal, 1, ',', '.') . " untuk sampel " . $maxIndex
                . " dan " . number_format($minAwal, 1, ',', '.') . " untuk sampel " . $minIndex . ")";

            $deskripsiSelisihAkhir = "Hasil akhir suhu pusat griller pada proses blast freezing griller pada ABF 3 ini memiliki selisih min-maks sebesar " 
                . number_format(abs($selisihAkhir), 1, ',', '.') . " &deg;C "
                . "(" . number_format($minAkhir, 1, ',', '.') . " untuk sampel " . $minIndex
                . " dan " . number_format($maxAkhir, 1, ',', '.') . " untuk sampel " . $maxIndex . ")";
        @endphp

        <table class="table-bordered" style="width: 80%; margin: auto;">
            <tr>
                <td rowspan="2" class="title-row">SUHU AWAL</td>
                <th>Titik 1</th>
                <th>Titik 2</th>
                <th>Titik 3</th>
                <th>Titik 4</th>
            </tr>
            <tr>
                <td>{{ number_format($suhuAwalPenetrasi[1], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwalPenetrasi[2], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwalPenetrasi[3], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwalPenetrasi[4], 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Durasi sejak start ABF (menit)</td>
                <td colspan="9">0</td>
            </tr>
            <tr>
                <td>yakni pada jam</td>
                <td colspan="9">{{ \Carbon\Carbon::parse($dataABF->start_pengujian)->format('H:i:s') }}</td>
            </tr>
            <tr>
                <td rowspan="2" class="title-row">SUHU AKHIR</td>
                <th>Titik 1</th>
                <th>Titik 2</th>
                <th>Titik 3</th>
                <th>Titik 4</th>
            </tr>
            <tr>
                <td>{{ number_format($suhuAkhirPenetrasi[1], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhirPenetrasi[2], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhirPenetrasi[3], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhirPenetrasi[4], 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Durasi sejak start ABF</td>
                <td colspan="9">
                    @php
                        // Pastikan data tersedia
                        if (isset($dataABF->start_pengujian) && isset($dataABF->end_pengujian)) {
                            $start = new DateTime($dataABF->start_pengujian);
                            $end = new DateTime($dataABF->end_pengujian);
        
                            // Jika waktu selesai lebih kecil dari waktu mulai (melewati tengah malam)
                            if ($end < $start) {
                                $end->modify('+1 day');
                            }
        
                            $selisih = $start->diff($end);
                            echo "" . $selisih->h . " jam " . $selisih->i . " menit " . $selisih->s . " detik";
                        } else {
                            echo "Data waktu tidak tersedia";
                        }
                    @endphp
                </td>
            </tr>
            <tr>
                <td>yakni pada jam</td>
                <td colspan="9">{{ \Carbon\Carbon::parse($dataABF->end_pengujian)->format('H:i:s') }}</td>
            </tr>
        </table>
        <p style="text-align: center;"> <strong>Table 6.</strong>  Hasil Ketercapaian Suhu Produk Pada Ruang {{ $dataABF->nama_mesin }}</p>

        {{-- <div>
            <p>Berdasarkan tabel di atas, dapat diperoleh informasi berupa:</p>
            <ul>
                <li>
                    1. Durasi penurunan suhu <strong>tercepat</strong> terjadi pada {{ $titikTercepatPenetrasi }}, yakni dapat menurunkan suhu sebesar {{ number_format($penurunanTercepatPenetrasi, 2, ',', '.') }}&deg;C (dari {{ number_format($suhuAwalTercepatPenetrasi, 2, ',', '.') }}&deg;C ke {{ number_format($suhuAkhirTercepat, 2, ',', '.') }}&deg;C)
                </li>
                <li>
                    2. Durasi penurunan suhu <strong>terlama</strong> terjadi pada {{ $titikTerlambatPenetrasi }}, yakni dapat menurunkan suhu sebesar {{ number_format($penurunanTerlambatPenetrasi, 2, ',', '.') }}&deg;C (dari {{ number_format($suhuAwalTerlambatPenetrasi, 2, ',', '.') }}&deg;C menjadi {{ number_format($suhuAkhirTerlambatPenetrasi, 2, ',', '.') }}&deg;C)
                </li>
                <li>3. {!! $deskripsiSelisihAwal !!} <br> {!! $deskripsiSelisihAkhir !!} </li>
            </ul>
        </div> --}}
    </div>

    {{-- grafik penetrasi suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut: </p>
        {{-- <img src="{{ $chartUrl }}" style="width:100%; max-width:600px; margin: auto;"> --}}
        <p style="text-align: center;"> <strong>Grafik 2.</strong> Penetrasi Produk (Griller) Pada ABF 6</p>

        <p>Grafik tersebut menampilkan kurva dengan 2 pola, yakni melandai selama 6,5 jam kemudian turun (titik 1 dan 2) dan kurva yang langsung bergerak turun namun terjadi
            kenaikan suhu (titik 3 dan 4). Dengan suhu awal yang terpaut 2,5 C (13,4 C untuk sampel 4; dan 10,9 C untuk sampel 1), menghasilkan suhu akhir dengan selisih yang
            cukup jauh, yakni terpaut 5,7 C dengan rincian suhu griller titik 1 sebesar -19,9 C sedangkan suhu griller di titik 2, 3, dan 4 sebesar -23,1 hingga -25,6 C. Berbedanya
            titik 1 terhadap titik 2, 3, dan 4 terjadi karena beberapa hal, utamanya terkait dengan penggunaan rak pendek (yang selisih antar kisinya lebih sempit dibanding rak
            tinggi, kaitannya dengan aliran udara) dan juga banyaknya produk yang dimasukkan ke dalam ABF. Faktor bangunan dinilai tidak berpengaruh besar terhadap hasil
            akhir karena konstruksi dindingnya masih rapat dan tidak ada kebocoran (tidak ada bunga es sebagai indikasi kebocoran). Hanya saja, seal karet pada bagian bawah
            dan samping pintu ABF ini perlu perhatian khusus karena ada celah yang memanjang sepanjang pintu. 
        </p>
        <p>Proses blasting griller kali ini menunjukkan adanya 2 pola penurunan suhu, yakni suhu yang langsung turun secara bertahap dan suhu yang ada stagnansi sebelum
            turun ke minus. Data terkait stagnansi suhu ini dituangkan ke dalam tabel 7 sebagai berikut:</p>
    </div>

    {{-- tabel stagnansi --}}
    <div class="row mb-3 justify-content-center">
        <table class="table-bordered mb-3" style="width: 80%; margin: auto;">
            <thead>
                <tr>
                <th class="tg-0pky"></th>
                <th class="tg-0pky">Titik 1</th>
                <th class="tg-0pky">Titik 2</th>
                <th class="tg-0pky">titik 3</th>
                <th class="tg-0pky">titik 4</th>
                </tr>
            </thead>
          <tbody>
            <tr>
              <td class="tg-0pky">terjadi mulai dari jam</td>
              <td class="tg-0pky">19:07:42</td>
              <td class="tg-0pky">19:07:42</td>
              <td class="tg-0pky">00:00:00</td>
              <td class="tg-0pky">00:00:00</td>
            </tr>
            <tr>
              <td class="tg-0pky">pada suhu (C)</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
            </tr>
            <tr>
              <td class="tg-0pky">hingga jam </td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
            </tr>
            <tr>
              <td class="tg-0pky">pada suhu (C)</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
            </tr>
            <tr>
              <td class="tg-0pky">total durasi stagnan</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
            </tr>
            <tr>
              <td class="tg-0pky">total penurunan suhu saat stagnan (C)</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
              <td class="tg-0pky">0</td>
            </tr>
          </tbody>
        </table>
        <p style="text-align: center;"> <strong>Table 7.</strong> Durasi Stagnansi Suhu Inti Produk
        </p>
        <p>
            Berdasarkan tabel di atas, titik 1 menjadi titik dengan durasi stagnansi suhu terlama, yakni pada rentang 6 jam 40 menit hanya menurunkan suhu sebesar 1,1 C (diawali
            dari suhu -0,9 hingga mencapai -1,9), dan titik dengan stagnansi suhu tercepat terdapat pada titik 3, yakni selama 2 jam dengan penurunan suhu sebesar 0,3 C (diawali
            dari suhu -1,0 hingga mencapai suhu -1,2). Seperti yang dijelaskan sebelumnya, bahwa stagnansi suhu pada titik 1 dan 2 ini kemungkinan penyebabnya adalah
            pemilihan jenis rak yang berbeda, dan juga penataan antar rak yang terlalu rapat. Apabila dilakukan pemilihan rak dan penataan yang pas, maka durasi stagnansi suhu
            pada titik 1 dan 2 dapat diperisingkat. 
        </p>
        <p>
            Uji penetrasi suhu ini selain dapat melihat pergerakan suhu dari waktu ke waktu, juga menghasilkan data terkait pencapaian suhu griller pada -18 C sesuai standard yang ditetapkan oleh QC. Data terkait pencapaian suhu griller tersebut dituangkan dalam tabel 8 sebagai berikut:
        </p>
    </div>

    {{-- tabel ketercapaian suhu --}}
    <div class="row mb-3">
        <table class="table-bordered mb-3" style="width: 80%; margin: auto;">
            <thead>
                <tr>
                <th class="tg-0pky"></th>
                <th class="tg-0pky">Titik 1</th>
                <th class="tg-0pky">Titik 2</th>
                <th class="tg-0pky">titik 3</th>
                <th class="tg-0pky">titik 4</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td class="tg-0pky"></td>
                <td class="tg-rleq" colspan="4">Mencapai 0,0 C dari start</td>
                </tr>
                <tr>
                <td class="tg-0pky">durasi</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                </tr>
                <tr>
                <td class="tg-0pky">pada jam</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                </tr>
                <tr>
                <td class="tg-0pky"></td>
                <td class="tg-0pky" colspan="4">Mencapai -18,0 degC dari Start </td>
                </tr>
                <tr>
                <td class="tg-0pky">durasi</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                </tr>
                <tr>
                <td class="tg-0pky">pada jam</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                <td class="tg-0pky">0</td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Table 8.</strong> Durasi Stagnansi Suhu Inti Produk
        </p>
        <p>Tabel 8 tersebut menjelaskan bahwa sejak mesin ABF dinyalakan pada jam 16:12, griller mencapai suhu 0,0 C mulai dari jam 18:17 (titik 3 dan 4) hingga 19:12 (titik 1).
            Selanjutnya, dari suhu 0,0 C hingga mencapai -18,0 C terjadi mulai dari jam 05:17 (titik 4) hingga 08:57 pagi (titik 1). Artinya, sejak pencapaian suhu nol hingga
            pencapaian target pada suhu -18 C, titik 1 memiliki penurunan yang terlama dibandingkan dengan titik yang lain. Begitu pula dengan titik 2, 3 dan 4 yang dengan durasi
            waktu pencapaian suhu masing-masing dari nol hingga -18 C bersifat linier, tidak ada perubahan durasi yang signifikan yang menghasilkan pencapaian suhu salah satu
            titik lebih cepat dari titik yang lain. Hal ini berarti dapat diketahui bahwa dengan kecepatan blower yang konstan dan ruang yang terus menerus tertutup, maka sifat
            penurunan suhu antar titiknya linier, dan apabila pengguna ingin produknya mencapai suhu -18 C saat proses blasting, maka perlu dilakukan pengaturan terkait
            pemilihan rak produk dan penataannya (dengan catatan kondisi ruang tidak ada kebocoran dan ukuran ayam yang seragam). </p>
    </div>

    {{-- kesimpulan --}}
    <div class="row mb-3">
        <h3 class="mb-3" style="margin-bottom: 1rem;">G. KESIMPULAN</h3>
        <ul style="list-style-type: none;">
            <li>1. Hasil akhir persebaran suhu pada ABF 3 memiliki perbedaan pembacaan pada titik tertinggi-terendah sebesar 3,6 °C. Rentang tersebut tergolong homogen, mengingat
                banyaknya produk yang dimasukkan ke dalam ABF dan pemilihan jenis rak. Apabila user ingin menjadikan hasil validasi ini sebagai acuan, maka dapat menggunakan titik
                yang capaian suhunya tertinggi</li>
            <li>2. Durasi waktu yang dibutuhkan griller pada ABF 3 agar penetrasi suhu mencapai -18 C adalah selama 13,1 jam (tercepat) dan 16,8 jam (terlama). Perlu dilakukan penyesuaian
                dalam hal penataan dan pemilihan rak, apabila user menginginkan hasil yang seragam.
               </li>
        </ul>
    </div>
</body>
</html>
