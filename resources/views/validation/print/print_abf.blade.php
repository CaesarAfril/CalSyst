<!DOCTYPE html>
<html>
<head>
    <title>Laporan Validasi ABF</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
        }

        .table-bordered {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            padding: 2px;
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
            <td style="padding: 2px;">Waktu Mulai Pengujian</td>
            <td style="padding: 2px;">{{ \Carbon\Carbon::parse($dataABF->start_pengujian)->translatedFormat('d F Y') }}</td>
            <td style="padding: 2px;">{{ \Carbon\Carbon::parse($dataABF->start_pengujian)->format('H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 2px;">Waktu Akhir Pengujian</td>
            <td style="padding: 2px;">{{ \Carbon\Carbon::parse($dataABF->end_pengujian)->translatedFormat('d F Y') }}</td>
            <td style="padding: 2px;">{{ \Carbon\Carbon::parse($dataABF->end_pengujian)->format('H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 2px;">Pengujian ke</td>
            <td colspan="2" style="padding: 2px;">{{ $dataABF ->pengujian }}</td>
        </tr>
    </table>

    <table class="table-bordered mb-3" style="width: 50%;">
        <tr>
            <td style="padding: 2px;">Nama Produk</td>
            <td style="padding: 2px;">{{ $dataABF ->nama_produk }}</td>
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
            <td style="padding: 2px;">Merek</td>
            <td colspan="2" style="padding: 2px;">{{ $dataABF ->merek_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 2px;">Tipe</td>
            <td colspan="2" style="padding: 2px;">{{ $dataABF ->tipe_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 2px;">Freon</td>
            <td colspan="2" style="padding: 2px;">{{ $dataABF ->freon_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 2px;">Kapasitas</td>
            <td colspan="2" style="padding: 2px;">{{ $dataABF ->kapasitas_mesin_2 }}</td>
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
        <p style="text-align: center;"> <strong>Tabel 1.</strong> Hasil Pengukuran Persebaran Suhu Pada Ruang {{ $dataABF ->nama_mesin }}</p>

        <div>
            <p>Berdasarkan tabel di atas, dapat diperoleh informasi berupa:</p>
            <ul>
                <li>1. {!! $hasil !!}</li>
                <li>2. {!! $hasilTerlambat !!}</li>
                <li>3. {!! $hasilSelisih !!}</li>
            </ul>
        </div>
    </div>
        
    {{-- Grafik 1. Persebaran suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut:</p>
        <img src="{{ $chartUrl }}" style="width: 100%; margin: auto;">
        <p style="text-align: center;"> <strong>Grafik 1.</strong>  Persebaran Suhu Ruang {{ $dataABF->nama_mesin }} </p>
    </div>

    {{-- spike func --}}
    @php
        function getSpikeDetails($data) {
            $channels = ['ch1', 'ch2', 'ch3', 'ch4', 'ch5', 'ch7', 'ch8', 'ch9']; // exclude ch6, ch10
            $averaged = [];

            // 1. Hitung rata-rata setiap baris
            foreach ($data as $row) {
                $sum = 0;
                foreach ($channels as $ch) {
                    $sum += $row->$ch;
                }
                $averaged[] = $sum / count($channels);
            }

            // 2. Deteksi spike
            $threshold = 1;
            $cooldown = 2; // 2 langkah = 10 menit (karena interval 5 menit)
            $spikes = [];
            $lastSpikeEnd = -100;
            $i = 1;

            while ($i < count($averaged)) {
                $diff = $averaged[$i] - $averaged[$i - 1];
                if ($diff > $threshold && ($i - $lastSpikeEnd) > $cooldown) {
                    $start = $i;
                    $duration = 1;
                    while (
                        ($i + 1 < count($averaged)) &&
                        ($averaged[$i + 1] - $averaged[$i] > 0.2)
                    ) {
                        $duration++;
                        $i++;
                    }
                    $end = $i;
                    $spikes[] = ['start' => $start, 'duration' => $duration, 'end' => $end];
                    $lastSpikeEnd = $end;
                }
                $i++;
            }

            return $spikes;
        }

        function formatDuration($minutes) {
            if ($minutes < 60) {
                return $minutes . ' menit';
            } else {
                return round($minutes / 60, 1) . ' jam';
            }
        }

        function formatSpikeNarrative($spikes) {
            $texts = [];
            for ($i = 0; $i < count($spikes); $i++) {
                $startHour = round(($spikes[$i]['start'] * 5) / 60, 1); // index * 5 menit => jam
                $durationMinutes = $spikes[$i]['duration'] * 5; // langkah * 5 menit
                $durationFormatted = formatDuration($durationMinutes);

                if ($i == 0) {
                    $texts[] = "Spike pertama terjadi pada $startHour jam sejak ABF dinyalakan, dan terjadi selama $durationFormatted";
                } else {
                    $prevEndMinute = $spikes[$i - 1]['end'] * 5;
                    $currStartMinute = $spikes[$i]['start'] * 5;
                    $sincePrevEnd = round(($currStartMinute - $prevEndMinute) / 60, 1);
                    $ordinalText = match($i + 1) {
                        2 => "kedua",
                        3 => "ketiga",
                        4 => "keempat",
                        5 => "kelima",
                        6 => "keenam",
                        7 => "ketujuh",
                        8 => "kedelapan",
                        default => "ke-" . ($i + 1),
                    };
                    $label = ($i == count($spikes) - 1) ? "Spike terakhir ($ordinalText)" : "Spike $ordinalText";
                    $texts[] = "$label terjadi pada $sincePrevEnd jam setelah spike " . ($i == 1 ? "pertama" : "kedua") . ", selama $durationFormatted";
                }
            }

            return implode('. ', $texts) . ".";
        }

        function formatSpikeSummary($spikes) {
            $total = count($spikes);

            if ($total <= 1) {
                return "Total terjadinya spike pada running ABF kali ini sebanyak $total kali.";
            }

            $totalIntervalMinutes = 0;
            for ($i = 1; $i < $total; $i++) {
                $prevEnd = $spikes[$i - 1]['end'] * 5; // menit
                $currStart = $spikes[$i]['start'] * 5; // menit
                $interval = $currStart - $prevEnd;
                $totalIntervalMinutes += $interval;
            }

            $averageIntervalJam = round(($totalIntervalMinutes / ($total - 1)) / 60, 1);

            return "Total terjadinya spike pada running ABF kali ini sebanyak $total kali, dengan interval $averageIntervalJam jam sekali.";
        }

        function formatMenitJam($menit) {
            $jam = round($menit / 60, 1);
            return "$menit menit, atau $jam jam";
        }

        function generateSpikeTableRows($spikes) {
            $rows = [];

            if (count($spikes) === 0) return '';

            // Durasi dari ON ABF ke Spike 1
            $firstStart = $spikes[0]['start'] * 5;
            $rows[] = "<tr><td style='padding: 4px;'>Durasi dari ON ABF ke Spike 1</td><td colspan='2' style='padding: 4px;'>" . formatMenitJam($firstStart) . "</td></tr>";

            // Spike 1
            $durasi1 = $spikes[0]['duration'] * 5;
            $rows[] = "<tr><td style='padding: 4px;'>Durasi Spike 1</td><td colspan='2' style='padding: 4px;'>{$durasi1} menit</td></tr>";

            for ($i = 1; $i < count($spikes); $i++) {
                $prevEnd = $spikes[$i - 1]['end'] * 5;
                $thisStart = $spikes[$i]['start'] * 5;
                $selisih = $thisStart - $prevEnd;
                $rows[] = "<tr><td style='padding: 4px;'>Durasi dari Spike $i ke Spike " . ($i + 1) . "</td><td colspan='2' style='padding: 4px;'>" . formatMenitJam($selisih) . "</td></tr>";

                $durasi = $spikes[$i]['duration'] * 5;
                $durasiFormat = ($durasi < 60) ? "$durasi menit" : formatMenitJam($durasi);
                $rows[] = "<tr><td style='padding: 4px;'>Durasi Spike " . ($i + 1) . "</td><td colspan='2' style='padding: 4px;'>$durasiFormat</td></tr>";
            }

            // Interval rata-rata
            if (count($spikes) > 1) {
                $totalInterval = 0;
                for ($i = 1; $i < count($spikes); $i++) {
                    $prevEnd = $spikes[$i - 1]['end'] * 5;
                    $currStart = $spikes[$i]['start'] * 5;
                    $totalInterval += ($currStart - $prevEnd);
                }
                $rataJam = round(($totalInterval / (count($spikes) - 1)) / 60, 1);
                $rows[] = "<tr><td style='padding: 4px;'>Interval terjadinya Spike</td><td colspan='2' style='padding: 4px;'>{$rataJam} jam sekali</td></tr>";
            }

            return implode("\n", $rows);
        }

        $spikeDetails = getSpikeDetails($suhuData);
    @endphp

    {{-- tabel 2 durasi keseluruhan spike --}}
    <div class="row mb-3">

        <p>
            Terdapat peristiwa lonjakan suhu sesaat (spike) sebanyak {{ count($spikeDetails) }} kali selama proses blast freezing.
            {{ formatSpikeNarrative($spikeDetails) }} {{ formatSpikeSummary($spikeDetails) }}
        </p>

        <p>Data terkait durasi spike dituangkan dalam tabel berikut ini:</p>

        <table class="table-bordered mb-3" style="width: 80%; margin: auto;">
            <tr>
                <td style="padding: 4px;"></td>
                <td colspan="2" style="padding: 4px;">Durasi</td>
            </tr>
            {!! generateSpikeTableRows($spikeDetails) !!}
        </table>
        <p style="text-align: center;"> <strong>Tabel 2.</strong> Durasi Keseluruhan Terjadinya Spike</p>

    </div>

    {{-- tabel 3 durasi ketiga spike  --}}
    <div class="row mb-3">
        @php
            $channels = ['ch1', 'ch2', 'ch3', 'ch4', 'ch5', 'ch7', 'ch8', 'ch9'];

            function menitKeJamMenit($index, $data) {
                // Pastikan data sudah diurutkan berdasarkan waktu
                if (!isset($data[$index]->time)) {
                    throw new Exception("Data tidak memiliki timestamp yang valid");
                }
                
                // Ambil timestamp langsung dari data
                $timestamp = strtotime($data[$index]->time);
                
                // Format ke H:i:s
                return date("H:i:s", $timestamp);
            }

            function extractSpikeTableData($spike, $data, $channels) {
                $rows = [];
                $startIndex = $spike['start'];
                $endIndex = $spike['end'];

                foreach ($channels as $channel) {
                    $startValue = $data[$startIndex]->$channel;
                    $peakValue = $startValue;
                    $peakIndex = $startIndex;

                    for ($i = $startIndex; $i <= $endIndex; $i++) {
                        if ($data[$i]->$channel > $peakValue) {
                            $peakValue = $data[$i]->$channel;
                            $peakIndex = $i;
                        }
                    }

                    $endValue = $data[$endIndex]->$channel;

                    $rows[$channel] = [
                        'jam_mulai' => menitKeJamMenit($startIndex, $data),
                        'suhu_awal' => $startValue,
                        'durasi_start_to_peak' => ($peakIndex - $startIndex) * 5,
                        'suhu_puncak' => $peakValue,
                        'durasi_puncak' => 5, // asumsikan 1 data point puncak
                        'suhu_akhir' => $endValue,
                        'durasi_peak_to_end' => ($endIndex - $peakIndex) * 5,
                        'total_durasi' => ($endIndex - $startIndex) * 5,
                        'jam_berakhir' => menitKeJamMenit($endIndex, $data),
                    ];
                }

                return $rows;
            }

            function getTimeDiffInHours($prevEndIndex, $currentStartIndex, $data) {
                $time1 = strtotime($data[$prevEndIndex]->time);
                $time2 = strtotime($data[$currentStartIndex]->time);
                $diffInSeconds = $time2 - $time1;
                return round($diffInSeconds / 3600, 1); // konversi ke jam, 1 desimal
            }

            $spikeSummaries = [];
        @endphp

        @foreach ($spikeDetails as $index => $spike)
            @php
                $tableData = extractSpikeTableData($spike, $suhuData, $channels);

                // Ringkasan spike per item
                $jamMulai = menitKeJamMenit($spike['start'], $suhuData);
                $jamSelesai = menitKeJamMenit($spike['end'], $suhuData);

                $durasiStartToPeak = [];
                $durasiPeakToEnd = [];
                $durasiTotal = [];
                $selisihNaik = [];
                $selisihTurun = [];

                foreach ($channels as $ch) {
                    $d = $tableData[$ch];
                    $durasiStartToPeak[] = $d['durasi_start_to_peak'];
                    $durasiPeakToEnd[] = $d['durasi_peak_to_end'];
                    $durasiTotal[] = $d['total_durasi'];
                    $selisihNaik[] = round($d['suhu_puncak'] - $d['suhu_awal'], 1);
                    $selisihTurun[] = round($d['suhu_puncak'] - $d['suhu_akhir'], 1);
                }

                $summaryText = "Spike ke-" . ($index + 1) . " ";
                if ($index == 0) {
                    $summaryText .= "dimulai pada jam $jamMulai - $jamSelesai. ";
                } else {
                    $durasiSejakSebelumnya = getTimeDiffInHours($spikeDetails[$index - 1]['end'], $spike['start'], $suhuData);
                    $summaryText .= "dimulai pada $durasiSejakSebelumnya jam sejak spike sebelumnya, yakni pada jam $jamMulai - $jamSelesai. ";
                }

                $summaryText .= "Kenaikan suhu awal hingga puncak terjadi selama " . min($durasiStartToPeak) . " - " . max($durasiStartToPeak) . " menit dengan kenaikan suhu sebesar " . min($selisihNaik) . " - " . max($selisihNaik) . " &deg;C, ";
                $summaryText .= "dengan durasi spike di puncaknya selama 5 menit. ";
                $summaryText .= "Penurunan suhu dari puncak spike sampai ke akhir terjadi selama " . min($durasiPeakToEnd) . " - " . max($durasiPeakToEnd) . " menit dengan penurunan suhu sebesar " . min($selisihTurun) . " - " . max($selisihTurun) . " &deg;C. ";
                $summaryText .= "Total durasi spike adalah " . min($durasiTotal) . " - " . max($durasiTotal) . " menit.";
            @endphp

            <div style="page-break-inside: avoid; margin-bottom: 30px;">
                <table class="table-bordered mb-3" style="width: 100%; margin: auto;">
                    <thead>
                        <tr>
                            <th></th>
                            @foreach ($channels as $ch)
                                <th>{{ str_replace('ch', 'Titik ', $ch) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $labels = [
                                'jam_mulai' => 'Dimulai pada jam',
                                'suhu_awal' => 'Suhu awal',
                                'durasi_start_to_peak' => 'Durasi Start to Peak (menit)',
                                'suhu_puncak' => 'Suhu Puncak',
                                'durasi_puncak' => 'Durasi Puncak (menit)',
                                'suhu_akhir' => 'Suhu Akhir',
                                'durasi_peak_to_end' => 'Durasi Peak to End (menit)',
                                'total_durasi' => 'Total Durasi Spike (menit)',
                                'jam_berakhir' => 'Berakhir pada jam',
                            ];
                        @endphp

                        @foreach ($labels as $key => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                @foreach ($channels as $ch)
                                    <td>{{ $tableData[$ch][$key] }}</td>
                                @endforeach
                            </tr>
                        @endforeach

                        <tr>
                            <td>Spike yang ke</td>
                            <td colspan="{{ count($channels) }}">{{ $index + 1 }}</td>
                        </tr>
                    </tbody>
                </table>

                <p style="text-align: center;">
                    <strong>Tabel {{ $index + 3 }}.</strong>
                    Durasi Terjadinya Spike {{ $index + 1 }}
                </p>

                <p>{!! $summaryText !!}</p>
            </div>
        @endforeach
    </div>

    {{-- uji penetrasi suhu --}}
    <div class="row mb-3">
        <h3 style="margin-bottom: 1rem;">UJI PENETRASI SUHU</h3>
        <p class="mb-3">Sama seperti uji perataan suhu, uji penetrasi suhu {{ $dataABF->nama_mesin }} dimulai pada tanggal {{ \Carbon\Carbon::parse($dataABF->start_pengujian)->translatedFormat('d F Y') }} pukul {{ \Carbon\Carbon::parse($dataABF->start_pengujian)->format('H:i:s') }} dan berakhir pada {{ \Carbon\Carbon::parse($dataABF->end_pengujian)->translatedFormat('d F Y') }} pukul {{ \Carbon\Carbon::parse($dataABF->end_pengujian)->format('H:i:s') }}. Hal yang membedakan adalah uji ini dilakukan dengan cara menanamkan thermologger ke bagian dada ayam griller, dada ayam dibelah, probe diletakkan di posisi daging terdalam, kemudian ayam dijahit kembali. Interval pembacaan thermologger ini diset sama seperti Midilogger, yakni setiap 5 menit sekali. Selama periode tersebut, informasi terkait penetrasi suhu griller adalah sebagai berikut:
        </p>

        @php
            $dataPenetrasi = collect([
                'titik1' => ['awal' => $suhuAwal->titik1, 'akhir' => $suhuAkhir->titik1],
                'titik2' => ['awal' => $suhuAwal->titik2, 'akhir' => $suhuAkhir->titik2],
                'titik3' => ['awal' => $suhuAwal->titik3, 'akhir' => $suhuAkhir->titik3],
                'titik4' => ['awal' => $suhuAwal->titik4, 'akhir' => $suhuAkhir->titik4],
            ]);

            // Hitung durasi dalam menit
            $start = Carbon::parse($suhuAwal->time);
            $end = Carbon::parse($suhuAkhir->time);
            $durasiMenitPenetrasi = $start->diffInMinutes($end);

            // Hitung penurunan dan kecepatan
            $hasilPenetrasi = $dataPenetrasi->map(function ($nilai) use ($durasiMenitPenetrasi) {
                if (is_numeric($nilai['awal']) && is_numeric($nilai['akhir'])) {
                    $selisih = $nilai['awal'] - $nilai['akhir'];
                    return [
                        'awal' => $nilai['awal'],
                        'akhir' => $nilai['akhir'],
                        'selisih' => $selisih,
                        'kecepatan' => $selisih / $durasiMenitPenetrasi,
                    ];
                }
                return null;
            })->filter();

            // Titik tercepat dan terlama
            $sorted = $hasilPenetrasi->sortByDesc('kecepatan');
            $titikTercepatPenetrasi = $sorted->keys()->first();
            $tercepatPenetrasi = $sorted->first();

            $titikTerlamaPenetrasi = $sorted->keys()->last();
            $terlamaPenetrasi = $sorted->last();

            // Ambil semua nilai suhu awal dan akhir untuk hitung min-maks
            $suhuAwalCollection = $dataPenetrasi->pluck('awal')->filter(fn($v) => is_numeric($v));
            $suhuAkhirCollection = $dataPenetrasi->pluck('akhir')->filter(fn($v) => is_numeric($v));

            // Min-maks suhu awal
            $minAwal = $suhuAwalCollection->min();
            $maxAwal = $suhuAwalCollection->max();
            $selisihMinMaxAwal = $maxAwal - $minAwal;
            $titikMinAwal = $suhuAwalCollection->search($minAwal) + 1;
            $titikMaxAwal = $suhuAwalCollection->search($maxAwal) + 1;

            // Min-maks suhu akhir
            $minAkhir = $suhuAkhirCollection->min();
            $maxAkhir = $suhuAkhirCollection->max();
            $selisihMinMaxAkhir = $maxAkhir - $minAkhir;
            $titikMinAkhir = $suhuAkhirCollection->search($minAkhir) + 1;
            $titikMaxAkhir = $suhuAkhirCollection->search($maxAkhir) + 1;
        @endphp

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
                <td class="tg-0pky">SUHU AWAL</td>
                <td class="tg-0pky">{{ $suhuAwal->titik1 ?? '-' }}</td>
                <td class="tg-0pky">{{ $suhuAwal->titik2 ?? '-' }}</td>
                <td class="tg-0pky">{{ $suhuAwal->titik3 ?? '-' }}</td>
                <td class="tg-0pky">{{ $suhuAwal->titik4 ?? '-' }}</td>
                </tr>
                <tr>
                <td class="tg-0pky">Durasi sejak start ABF (menit)</td>
                <td class="tg-0pky" colspan="4">0</td>
                </tr>
                <tr>
                <td class="tg-0pky">yakni pada jam </td>
                <td class="tg-0pky" colspan="4">{{ $suhuAwal->time ?? '-' }}</td>
                </tr>
                <tr>
                <td class="tg-0pky">SUHU AKHIR</td>
                <td class="tg-0pky">{{ $suhuAkhir->titik1 ?? '-' }}</td>
                <td class="tg-0pky">{{ $suhuAkhir->titik2 ?? '-' }}</td>
                <td class="tg-0pky">{{ $suhuAkhir->titik3 ?? '-' }}</td>
                <td class="tg-0pky">{{ $suhuAkhir->titik4 ?? '-' }}</td>
                </tr>
                <tr>
                <td class="tg-0pky">Durasi sejak start ABF</td>
                <td class="tg-0pky" colspan="4">{{ $durasi }}</td>
                </tr>
                <tr>
                <td class="tg-0pky">yakni pada jam </td>
                <td class="tg-0pky" colspan="4">{{ $suhuAkhir->time ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Tabel.</strong> Hasil Ketercapaian Suhu Produk</p>

        <div>
            <p>Berdasarkan tabel di atas, dapat diperoleh informasi berupa:</p>
            <ul>

                <li>
                    1. Durasi penurunan suhu tercepat terjadi pada {{ ucfirst(str_replace('titik', 'titik ', $titikTerlamaPenetrasi)) }},
                    yakni dalam {{ $durasi }} dapat menurunkan suhu sebesar
                    {{ number_format($terlamaPenetrasi['selisih'], 2) }} &deg;C
                    (dari {{ number_format($terlamaPenetrasi['awal'], 2) }} &deg;C menuju {{ number_format($terlamaPenetrasi['akhir'], 2) }} &deg;C).
                </li>
                <li>
                    2. Durasi penurunan suhu terlama terjadi pada {{ ucfirst(str_replace('titik', 'titik ', $titikTercepatPenetrasi)) }},
                    karena dalam {{ $durasi }} dapat menurunkan suhu sebesar
                    {{ number_format($tercepatPenetrasi['selisih'], 2) }} &deg;C
                    (dari {{ number_format($tercepatPenetrasi['awal'], 2) }} &deg;C menuju {{ number_format($tercepatPenetrasi['akhir'], 2) }} &deg;C).
                </li>
                <li>
                    3. Secara keseluruhan, selisih suhu awal antar titik menunjukkan perbedaan min-maks sebesar
                    {{ number_format($selisihMinMaxAwal, 1) }} &deg;C
                    ({{ number_format($maxAwal, 1) }} &deg;C pada sampel {{ $titikMaxAwal }},
                    dan {{ number_format($minAwal, 1) }} &deg;C pada sampel {{ $titikMinAwal }}),
                    sedangkan suhu akhir menunjukkan selisih min-maks sebesar
                    {{ number_format($selisihMinMaxAkhir, 1) }} &deg;C
                    ({{ number_format($minAkhir, 1) }} &deg;C pada sampel {{ $titikMinAkhir }},
                    dan {{ number_format($maxAkhir, 1) }} &deg;C pada sampel {{ $titikMaxAkhir }}).
                </li>
            </ul>
        </div>
    </div>

    {{-- grafik penetrasi suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut: </p>
        <img src="{{ $chartUrlPenetrasi }}" style="width: 100%; margin: auto;">
        <p style="text-align: center;"> <strong>Grafik 2.</strong> Penetrasi Produk (Griller) Pada ABF 6</p>

        <p>Data terkait stagnansi suhu ini dituangkan ke dalam tabel sebagai berikut:</p>
    </div>

    {{-- tabel stagnansi --}}
    <div class="row mb-3 justify-content-center">
        @php
            function generateStagnationTable($suhuData) {
                $titikColumns = ['titik1', 'titik2', 'titik3', 'titik4'];
                $results = [];

                $suhuArray = $suhuData->map(function ($item) {
                    $item->carbon_time = Carbon::parse($item->time);
                    return $item;
                })->values();

                foreach ($titikColumns as $column) {
                    $found = false;

                    for ($i = 0; $i < count($suhuArray) - 12; $i++) {
                        $startData = $suhuArray[$i];
                        $startTime = $startData->carbon_time;
                        $startTemp = $startData->$column;

                        $currentIndex = $i;
                        $currentTemp = $startTemp;
                        $endTime = $startTime;
                        $endTemp = $currentTemp;
                        $totalDrop = 0;
                        $durationMinutes = 0;

                        // Loop per jam (12 data = 1 jam jika 5 menit sekali)
                        while (true) {
                            if (!isset($suhuArray[$currentIndex + 12])) break;

                            $nextData = $suhuArray[$currentIndex + 12];
                            $nextTemp = $nextData->$column;
                            $drop = $nextTemp - $currentTemp;

                            if (abs($drop) < 1) {
                                // masih stagnan
                                $endTime = $nextData->carbon_time;
                                $endTemp = $nextTemp;
                                $totalDrop += $drop;
                                $durationMinutes += 60;
                                $currentTemp = $nextTemp;
                                $currentIndex += 12;
                            } else {
                                break;
                            }
                        }

                        if ($durationMinutes > 0) {
                            $results[$column] = [
                                'start_time' => $startTime->format('H:i:s'),
                                'start_temp' => number_format($startTemp, 1),
                                'end_time' => $endTime->format('H:i:s'),
                                'end_temp' => number_format($endTemp, 1),
                                'duration' => floor($durationMinutes / 60) . "j " . str_pad($durationMinutes % 60, 2, '0', STR_PAD_LEFT) . "'",
                                'temp_drop' => number_format($endTemp - $startTemp, 1),
                            ];
                            $found = true;
                            break; // hanya ambil stagnasi pertama
                        }
                    }

                    if (!$found) {
                        $results[$column] = [
                            'start_time' => '00:00:00',
                            'start_temp' => '0',
                            'end_time' => '00:00:00',
                            'end_temp' => '0',
                            'duration' => '0j 00\'',
                            'temp_drop' => '0'
                        ];
                    }
                }

                return $results;
            }

            function generateStagnationAnalysis($stagnationData) {
                $longest = [
                    'duration' => '0j 00\'',
                    'point' => '',
                    'temp_drop' => 0,
                    'start_temp' => 0,
                    'end_temp' => 0
                ];
                
                $shortest = [
                    'duration' => '99j 99\'',
                    'point' => '',
                    'temp_drop' => 0,
                    'start_temp' => 0,
                    'end_temp' => 0
                ];
                
                foreach ($stagnationData as $point => $data) {
                    // Skip if no stagnation found
                    if ($data['duration'] === '0j 00\'') {
                        continue;
                    }
                    
                    // Parse duration to minutes for comparison
                    $durationParts = explode(' ', $data['duration']);
                    $hours = (int)str_replace('j', '', $durationParts[0]);
                    $minutes = (int)str_replace("'", '', $durationParts[1]);
                    $totalMinutes = $hours * 60 + $minutes;
                    
                    // Parse longest duration in minutes
                    $longestParts = explode(' ', $longest['duration']);
                    $longestMinutes = (int)str_replace('j', '', $longestParts[0]) * 60 + 
                                    (int)str_replace("'", '', $longestParts[1]);
                    
                    // Parse shortest duration in minutes
                    $shortestParts = explode(' ', $shortest['duration']);
                    $shortestMinutes = (int)str_replace('j', '', $shortestParts[0]) * 60 + 
                                    (int)str_replace("'", '', $shortestParts[1]);
                    
                    // Find longest duration
                    if ($totalMinutes > $longestMinutes) {
                        $longest = [
                            'duration' => $data['duration'],
                            'point' => $point,
                            'start_temp' => $data['start_temp'],
                            'end_temp' => $data['end_temp'],
                            'temp_drop' => (float)$data['temp_drop']
                        ];
                    }
                    
                    // Find shortest duration
                    if ($totalMinutes > 0 && $totalMinutes < $shortestMinutes) {
                        $shortest = [
                            'duration' => $data['duration'],
                            'point' => $point,
                            'start_temp' => $data['start_temp'],
                            'end_temp' => $data['end_temp'],
                            'temp_drop' => (float)$data['temp_drop']
                        ];
                    }
                }
                
                // Generate analysis text
                $analysis = "Berdasarkan tabel di atas, ";
                
                if (!empty($longest['point'])) {
                    $pointName = ucfirst(str_replace('titik', 'titik ', $longest['point']));
                    $analysis .= $pointName . " menjadi titik dengan durasi stagnansi suhu terlama, ";
                    $analysis .= "yakni pada rentang " . $longest['duration'] . " dengan menurunkan suhu sebesar " . 
                                number_format(abs($longest['temp_drop']), 1) . "&deg;C ";
                    $analysis .= "(diawali dari suhu " . $longest['start_temp'] . "&deg;C hingga mencapai " . $longest['end_temp'] . "&deg;C)";
                }
                
                if (!empty($shortest['point']) && $shortest['duration'] !== '99j 99\'') {
                    $pointName = ucfirst(str_replace('titik', 'titik ', $shortest['point']));
                    $analysis .= ", dan titik dengan stagnansi suhu tercepat terdapat pada " . $pointName . ", ";
                    $analysis .= "yakni selama " . $shortest['duration'] . " dengan penurunan suhu sebesar " . 
                                number_format(abs($shortest['temp_drop']), 1) . "&deg;C ";
                    $analysis .= "(diawali dari suhu " . $shortest['start_temp'] . "&deg;C hingga mencapai suhu " . $shortest['end_temp'] . "&deg;C)";
                } elseif (empty($longest['point'])) {
                    $analysis .= "tidak ditemukan periode stagnansi yang signifikan";
                }
                
                return $analysis;
            }

            $stagnationData = generateStagnationTable($suhuData);
            $analysisText = generateStagnationAnalysis($stagnationData);
        @endphp

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
              <td class="tg-0pky" style="font-weight: bold">terjadi mulai dari jam</td>
              <td class="tg-0pky">{{ $stagnationData['titik1']['start_time'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik2']['start_time'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik3']['start_time'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik4']['start_time'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">pada suhu (C)</td>
              <td class="tg-0pky">{{ $stagnationData['titik1']['start_temp'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik2']['start_temp'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik3']['start_temp'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik4']['start_temp'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">hingga jam </td>
              <td class="tg-0pky">{{ $stagnationData['titik1']['end_time'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik2']['end_time'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik3']['end_time'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik4']['end_time'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">pada suhu (C)</td>
              <td class="tg-0pky">{{ $stagnationData['titik1']['end_temp'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik2']['end_temp'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik3']['end_temp'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik4']['end_temp'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">total durasi stagnan</td>
              <td class="tg-0pky">{{ $stagnationData['titik1']['duration'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik2']['duration'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik3']['duration'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik4']['duration'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">total penurunan suhu saat stagnan (C)</td>
              <td class="tg-0pky">{{ $stagnationData['titik1']['temp_drop'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik2']['temp_drop'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik3']['temp_drop'] }}</td>
              <td class="tg-0pky">{{ $stagnationData['titik4']['temp_drop'] }}</td>
            </tr>
          </tbody>
        </table>

        <p style="text-align: center;"> <strong>Tabel.</strong> Durasi Stagnansi Suhu Inti Produk
        </p>
        <p>
           {!! $analysisText !!}
        </p>
        <p>
            Uji penetrasi suhu ini selain dapat melihat pergerakan suhu dari waktu ke waktu, juga menghasilkan data terkait pencapaian suhu griller pada -18 C sesuai standard yang ditetapkan oleh QC. Data terkait pencapaian suhu griller tersebut dituangkan dalam tabel 8 sebagai berikut:
        </p>
    </div>

    {{-- tabel ketercapaian suhu --}}
    <div class="row mb-3">
        @php
            function generateTemperatureAchievementTable($suhuData) {
                $titikColumns = ['titik1', 'titik2', 'titik3', 'titik4'];
                $results = [
                    '0c' => ['durations' => [], 'times' => []],
                    '-18c' => ['durations' => [], 'times' => []],
                    'narratives' => [
                        '0c' => '',
                        '-18c' => '',
                        'penurunan_terlama' => '',
                    ]
                ];

                $startTime = Carbon::parse($suhuData->first()->time);
                $startTimeStr = $startTime->format('H:i');
                $dropDurations = []; // waktu penurunan dari 0°C ke -18°C per titik

                foreach ($titikColumns as $column) {
                    $first0c = null;
                    $firstBelow18c = null;

                    foreach ($suhuData as $data) {
                        $currentTime = Carbon::parse($data->time);

                        // 0°C
                        if ($data->$column <= 0 && !$first0c) {
                            $first0c = $currentTime;

                            if ($first0c->lt($startTime)) {
                                $first0c->addDay();
                            }

                            $duration = $startTime->diffInMinutes($first0c) / 60;
                            $results['0c']['durations'][$column] = number_format($duration, 1);
                            $results['0c']['times'][$column] = $currentTime->format('H:i:s');
                        }

                        // -18°C
                        if ($data->$column <= -18 && !$firstBelow18c) {
                            $firstBelow18c = $currentTime;

                            if ($firstBelow18c->lt($startTime)) {
                                $firstBelow18c->addDay();
                            }

                            $duration = $startTime->diffInMinutes($firstBelow18c) / 60;
                            $results['-18c']['durations'][$column] = number_format($duration, 1);
                            $results['-18c']['times'][$column] = $currentTime->format('H:i:s');
                        }

                        if ($first0c && $firstBelow18c) break;
                    }

                    if (!$first0c) {
                        $results['0c']['durations'][$column] = 'N/A';
                        $results['0c']['times'][$column] = 'N/A';
                    }

                    if (!$firstBelow18c) {
                        $results['-18c']['durations'][$column] = 'N/A';
                        $results['-18c']['times'][$column] = 'N/A';
                    }

                    // Hitung durasi penurunan dari 0°C ke -18°C jika keduanya valid
                    if ($first0c && $firstBelow18c) {
                        $dropDurations[$column] = $first0c->diffInMinutes($firstBelow18c) / 60; // jam
                    }
                }

                // Narasi 0°C
                $times0c = collect($results['0c']['times'])->filter(fn($t) => $t !== 'N/A');
                if ($times0c->isNotEmpty()) {
                    $earliest0c = $times0c->sort()->first();
                    $latest0c = $times0c->sortDesc()->first();

                    $earliestTitik = $times0c->filter(fn($t) => $t === $earliest0c)->keys()->map(fn($t) => ucfirst($t))->join(' dan ');
                    $latestTitik = $times0c->filter(fn($t) => $t === $latest0c)->keys()->map(fn($t) => ucfirst($t))->join(' dan ');

                    $results['narratives']['0c'] = "Tabel tersebut menjelaskan bahwa sejak mesin ABF dinyalakan pada jam {$startTimeStr}, griller mencapai suhu 0,0 &deg;C mulai dari jam {$earliest0c} ({$earliestTitik}) hingga {$latest0c} ({$latestTitik}).";
                }

                // Narasi -18°C
                $times18c = collect($results['-18c']['times'])->filter(fn($t) => $t !== 'N/A');
                if ($times18c->isNotEmpty()) {
                    $earliest18c = $times18c->sort()->first();
                    $latest18c = $times18c->sortDesc()->first();

                    $earliestTitik18 = $times18c->filter(fn($t) => $t === $earliest18c)->keys()->map(fn($t) => ucfirst($t))->join(' dan ');
                    $latestTitik18 = $times18c->filter(fn($t) => $t === $latest18c)->keys()->map(fn($t) => ucfirst($t))->join(' dan ');

                    $results['narratives']['-18c'] = "Griller mencapai suhu -18,0 &deg;C mulai dari jam {$earliest18c} ({$earliestTitik18}) hingga {$latest18c} ({$latestTitik18}).";
                }

                // Narasi penurunan terlama
                if (!empty($dropDurations)) {
                    $maxDropTitik = collect($dropDurations)->sortDesc()->keys()->first();
                    $results['narratives']['penurunan_terlama'] = "Artinya, sejak pencapaian suhu nol hingga pencapaian target pada suhu -18&nbsp;&deg;C, " . ucfirst($maxDropTitik) . " memiliki penurunan yang terlama dibandingkan dengan titik yang lain.";
                }

                return $results;
            }

            $achievementData = generateTemperatureAchievementTable($suhuData);
        @endphp

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
                <td class="tg-0pky" style="background-color: rgb(181, 218, 255);"></td>
                <td class="tg-rleq" colspan="4" style="background-color: rgb(181, 218, 255); font-weight: bold;">Mencapai 0,0 &deg;C dari start</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">durasi</td>
                <td class="tg-0pky">{{ $achievementData['0c']['durations']['titik1'] }} Jam</td>
                <td class="tg-0pky">{{ $achievementData['0c']['durations']['titik2'] }} Jam</td>
                <td class="tg-0pky">{{ $achievementData['0c']['durations']['titik3'] }} Jam</td>
                <td class="tg-0pky">{{ $achievementData['0c']['durations']['titik4'] }} Jam</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">pada jam</td>
                <td class="tg-0pky">{{ $achievementData['0c']['times']['titik1'] }}</td>
                <td class="tg-0pky">{{ $achievementData['0c']['times']['titik2'] }}</td>
                <td class="tg-0pky">{{ $achievementData['0c']['times']['titik3'] }}</td>
                <td class="tg-0pky">{{ $achievementData['0c']['times']['titik4'] }}</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="background-color: rgb(181, 218, 255);"></td>
                <td class="tg-0pky" colspan="4" style="background-color: rgb(181, 218, 255);font-weight: bold;">Mencapai -18,0 &deg;C dari Start </td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">durasi</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['durations']['titik1'] }} Jam</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['durations']['titik2'] }} Jam</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['durations']['titik3'] }} Jam</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['durations']['titik4'] }} Jam</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">pada jam</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['times']['titik1'] }}</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['times']['titik2'] }}</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['times']['titik3'] }}</td>
                <td class="tg-0pky">{{ $achievementData['-18c']['times']['titik4'] }}</td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Tabel.</strong> Ketercapaian Suhu Produk
        </p>
        <p>{!! $achievementData['narratives']['0c'] !!} {!! $achievementData['narratives']['-18c'] !!} {!! $achievementData['narratives']['penurunan_terlama'] !!}</p>
           
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
