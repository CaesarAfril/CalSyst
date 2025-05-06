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
    </style>
</head>
<body>

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

    {{-- format --}}
    <div class="row mb-3">
        <h3>A. IDENTIFIKASI</h3>
        <ul style="list-style-type: none;">
            <li>1. Melakukan validasi kesesuaian distribusi suhu dalam ruang ABF</li>
            <li>2. Melakukan validasi kesesuaian penetrasi suhu pada produk Griller Yamiku pada saat proses blast freezing</li>
        </ul>
    </div>
    <div class="row mb-3">
        <h3>B. TUJUAN</h3>
        <ul style="list-style-type: none;">
            <li>1. Mengetahui kinerja persebaran suhu ABF</li>
            <li>2. Mengetahui lama waktu yang dibutuhkan griller untuk mencapai suhu -18 °C</li>
        </ul>
    </div>
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
    <div class="row mb-3">
        <h5>Penetrasi Suhu Produk</h5>
        <ul style="list-style-type: none;">
            <li>1. Thermologger EBRO EBI-11 diaktifkan, dan interval pembacaan diatur setiap 5 menit</li>
            <li>2. EBRO diletakkan pada griller bagian dada, dengan cara dibedah dan dijahit kembali</li>
            <li>3. Griller yang sudah terisi EBRO diletakkan pda titik yang direncanakan (gambar 2)</li>
            <li>4. Selesai</li>
        </ul>
    </div>

    <div class="row mb-3">
        <h3 style="margin-bottom: 1rem;">E. HASIL UJI PERSEBARAN SUHU</h3>
        <p>Uji persebaran suhu <span>{{ $dataABF->nama_mesin }}</span> dimulai pada tanggal <span>{{ \Carbon\Carbon::parse($dataABF->start_pengujian)->translatedFormat('d F Y') }}</span> pukul {{ \Carbon\Carbon::parse($dataABF->start_pengujian)->format('H:i:s') }} dan berakhir pada <span>{{ \Carbon\Carbon::parse($dataABF->end_pengujian)->translatedFormat('d F Y') }}</span> pukul {{ \Carbon\Carbon::parse($dataABF->end_pengujian)->format('H:i:s') }}. Selama periode tersebut, informasi terkait persebaran suhu adalah sebagai berikut:</p>

        @php
            $suhuAwal = json_decode($dataABF->suhu_awal, true);
            $suhuAkhir = json_decode($dataABF->suhu_akhir, true);
            
            // Mapping titik names accounting for missing Titik 6
            $titikNames = [
                1 => "Titik 1",
                2 => "Titik 2",
                3 => "Titik 3",
                4 => "Titik 4",
                5 => "Titik 5",
                6 => "Titik 7",
                7 => "Titik 8",
                8 => "Titik 9 (Center)"
            ];

            // Initialize variables for fastest drop
            $maxDrop = 0;
            $titikTercepat = null;
            $suhuAwalTercepat = null;
            $suhuAkhirTercepat = null;

            // Initialize variables for slowest drop
            $minDrop = PHP_FLOAT_MAX;
            $titikTerlambat = null;
            $suhuAwalTerlambat = null;
            $suhuAkhirTerlambat = null;

            foreach ($suhuAwal as $index => $awal) {
                if (!isset($suhuAkhir[$index])) continue;

                $akhir = $suhuAkhir[$index];
                $drop = $awal - $akhir; // Positive value means temperature decreased

                // Check for fastest drop (largest difference)
                if ($drop > $maxDrop) {
                    $maxDrop = $drop;
                    $titikTercepat = $titikNames[$index] ?? "Titik ".($index+1);
                    $suhuAwalTercepat = $awal;
                    $suhuAkhirTercepat = $akhir;
                }

                // Check for slowest drop (smallest difference)
                if ($drop < $minDrop) {
                    $minDrop = $drop;
                    $titikTerlambat = $titikNames[$index] ?? "Titik ".($index+1);
                    $suhuAwalTerlambat = $awal;
                    $suhuAkhirTerlambat = $akhir;
                }
            }

            // Convert to absolute values for display
            $penurunanTercepat = abs($maxDrop);
            $penurunanTerlambat = abs($minDrop);

            // Find lowest and highest temperatures
            $minTemp = min($suhuAkhir);
            $maxTemp = max($suhuAkhir);
            
            // Find their positions
            $minIndex = array_search($minTemp, $suhuAkhir);
            $maxIndex = array_search($maxTemp, $suhuAkhir);
            
            // Calculate difference
            $selisih = $minTemp - $maxTemp;
            // Format the result
            $hasilSelisih = "selisih suhu antar titik terendah-tertinggi sebesar " 
                  . number_format($selisih, 2, ',', '.') . " &deg;C "
                  . "((" . number_format($minTemp, 2, ',', '.') . " &deg;C pada " . $titikNames[$minIndex] . ") - "
                  . "(" . number_format($maxTemp, 2, ',', '.') . " &deg;C pada " . $titikNames[$maxIndex] . "))";
        @endphp

        <table class="table-bordered">
            <tr>
                <td rowspan="2" class="title-row">SUHU AWAL</td>
                <th>Titik 1</th>
                <th>Titik 2</th>
                <th>Titik 3</th>
                <th>Titik 4</th>
                <th>Titik 5</th>
                <th>Titik 7</th>
                <th>Titik 8</th>
                <th>Titik 9 (Center)</th>
            </tr>
            <tr>
                <td>{{ number_format($suhuAwal[1], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwal[2], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwal[3], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwal[4], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwal[5], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwal[6], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwal[7], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAwal[8], 2, ',', '.') }}</td>
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
                <th>Titik 5</th>
                <th>Titik 7</th>
                <th>Titik 8</th>
                <th>Titik 9 (Center)</th>
            </tr>
            <tr>
                <td>{{ number_format($suhuAkhir[1], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhir[2], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhir[3], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhir[4], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhir[5], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhir[6], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhir[7], 2, ',', '.') }}</td>
                <td>{{ number_format($suhuAkhir[8], 2, ',', '.') }}</td>
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
        <p style="text-align: center;"> <strong>Table 1.</strong> Hasil Pengukuran Persebaran Suhu Pada Ruang {{ $dataABF ->nama_mesin }}</p>

        <div>
            <p>Berdasarkan tabel di atas, dapat diperoleh informasi berupa:</p>
            <ul>
                <li>
                    1. Durasi penurunan suhu <strong>tercepat</strong> terjadi pada {{ $titikTercepat }}, yakni dapat menurunkan suhu sebesar {{ number_format($penurunanTercepat, 2, ',', '.') }}&deg;C (dari {{ number_format($suhuAwalTercepat, 2, ',', '.') }}&deg;C ke {{ number_format($suhuAkhirTercepat, 2, ',', '.') }}&deg;C)
                </li>
                <li>
                    2. Durasi penurunan suhu <strong>terlambat</strong> terjadi pada {{ $titikTerlambat }}, yakni dapat menurunkan suhu sebesar {{ number_format($penurunanTerlambat, 2, ',', '.') }}&deg;C (dari {{ number_format($suhuAwalTerlambat, 2, ',', '.') }}&deg;C menjadi {{ number_format($suhuAkhirTerlambat, 2, ',', '.') }}&deg;C)
                </li>
                <li>3. Pada suhu akhir, {!! $hasilSelisih !!}</li>
                <li>
                    4. kesimpulan
                </li>
            </ul>
        </div>
    </div>

    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut:</p>
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
</body>
</html>
