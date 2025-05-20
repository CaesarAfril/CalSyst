<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Validasi Fryer Marel</title>
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
            padding: 1px;
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
            padding: 1px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        h2, h3, h4, h5 {
            margin-bottom: unset !important;
            padding-bottom: unset !important;
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

        /* CSS untuk cetak PDF */
        .header {
            position: fixed;
            top: -60px;
            left: 0;
            width: 100%;
        }
        
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        @page {
            margin-top: 100px;
            size: 210mm 330mm;
            margin-header: 10mm;
        }

        body {
            margin-top: 30px;
        }

        p {
            line-height: 1.2 !important;
        }
    </style>
</head>
<body>
    {{-- header --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 30%; vertical-align: middle;">
                    <table style="border: none; border-collapse: collapse;">
                        <tr>
                            <td style="vertical-align: middle; width: 50px;">
                                @php
                                    $path = public_path('storage/image/logo.png');
                                    if(file_exists($path)) {
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($path);
                                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                    }
                                @endphp
                                <img src="{{ $base64 ?? '' }}" alt="Logo" style="width: 50px;">
                            </td>
                            <td style="vertical-align: middle; padding-left: 10px;">
                                <div style="font-size: 9px; font-weight: bold; line-height: 1.2;">
                                    CHAROEN<br>POKPHAND<br>INDONESIA PT.<br>Food Division
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <h2 style="margin-left: -12rem; text-transform: uppercase;">
                        LAPORAN HASIL VALIDASI <br> FRYER MAREL TOWNSEND <br>
                        {{ $dataFryerMarel->lokasi }}
                    </h2>
                </td>
            </tr>
        </table>
    </div>

    {{-- content --}}
    <table class="table-bordered mb-3" style="width: 40%;">
        <tr>
            <td style="padding: 1px;">Waktu Mulai Pengujian</td>
            <td style="padding: 1px;">{{ \Carbon\Carbon::parse($dataFryerMarel->start_pengujian)->translatedFormat('d F Y') }}</td>
            <td style="padding: 1px;">{{ \Carbon\Carbon::parse($dataFryerMarel->start_pengujian)->format('H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Waktu Akhir Pengujian</td>
            <td style="padding: 1px;">{{ \Carbon\Carbon::parse($dataFryerMarel->end_pengujian)->translatedFormat('d F Y') }}</td>
            <td style="padding: 1px;">{{ \Carbon\Carbon::parse($dataFryerMarel->end_pengujian)->format('H:i') }}</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Setting Suhu Mesin (Spek)</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->setting_suhu_mesin }} &deg;C</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Waktu Produk Infeed ke Outfeed</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->waktu_produk_infeed }}</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Suhu Awal Inti Produk</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->suhu_awal_inti }} &deg;C (Thermo QC)</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Suhu Akhir Inti Produk</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->suhu_akhir_inti }} &deg;C (Thermo QC)</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Batck ke-</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->batch }}</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Waktu Pemasakan</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->waktu_pemasakan }}</td>
        </tr>
    </table>

    <table class="table-bordered mb-3" style="width: 50%;">
        <tr>
            <td style="padding: 1px;">Nama Produk</td>
            <td style="padding: 1px;">{{ $dataFryerMarel ->nama_produk }}</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: .75rem;">
        <tr>
            <td style="width: 30%; border: 1px solid black; vertical-align: top; padding: 2px;">
                Ingredient <br>
                Kemasan <br>
                Nama Mesin <br>
                Dimensi (p x l x t) <br>
                Target Suhu Inti Produk <br>
            </td>
            <td style="width: 70%; border: 1px solid black; vertical-align: top; padding: 2px;">
                {{ $dataFryerMarel ->ingredient }} <br>
                {{ $dataFryerMarel ->kemasan }} <br>
                {{ $dataFryerMarel ->nama_mesin }} <br>
                {{ $dataFryerMarel ->dimensi }} <br>
                {{ $dataFryerMarel ->target_suhu }}
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 1rem;">Nama Mesin</h3>
    <ul>
        <li>{{ $dataFryerMarel ->nama_mesin_2 }}</li>
    </ul>
    <table class="table-bordered mb-3" style="width: 40%;">
        <tr>
            <td style="padding: 1px;">Merek</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->merek_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Tipe</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->tipe_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Speed Conv</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->speed_conv_mesin_2 }}</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Kapasitas</td>
            <td colspan="2" style="padding: 1px;">{{ $dataFryerMarel ->kapasitas_mesin_2 }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 1rem; margin-bottom: unset;">Lokasi</h3>
    <ul>
        <li>{{ $dataFryerMarel ->lokasi }}</li>
        <li>{{ $dataFryerMarel ->alamat }}</li>
    </ul>

    {{-- identifikasi --}}
    <div class="row mb-3">
        <h3>IDENTIFIKASI</h3>
        <ul style="list-style-type: none;">
            <li>1. Kalibrasi enclosure untuk mengetahui bahwa kinerja sensor dan mesin dalam keadaan baik atau membutuhkan perbaikan.</li>
            <li>2. Melakukan validasi kesesuaian distribusi & penetrasi suhu pada Fiesta Crispy Crunch yang dimasak menggunakan Fryer Marel.</li>
        </ul>
    </div>

    {{-- tujuan --}}
    <div class="row mb-3">
        <h3>TUJUAN</h3>
        <ul style="list-style-type: none;">
            <li>1. Dapat mengetahui kinerja sistem dan sensor dari Fryer dan dapat melakukan perbaikan apabila terjadi ketidaksesuaian</li>
            <li>2. Memastikan bahwa proses pemasakan sesuai dengan spesifikasi yang ada.</li>
        </ul>
    </div>

    {{-- peralatan --}}
    <div class="row mb-3">
        <h3>PERALATAN & LAYOUT</h3>
        <table width="100%" style="text-align: center;">
            <tr>
                <td width="50%">
                    @php
                        $path = public_path('storage/image/midilogger.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="midilogger" style="width: 30%; margin: auto;">
                    <p>Graphtec Midi Logger GL-260 10 Channel </p>
                </td>
            </tr>
        </table>
    </div>

    {{-- metode uji --}}
    <div class="row mb-3">
        <h3>METODE UJI</h3>
        <div>
            <h4>Uji Tanpa Produk</h4>
            <ul style="margin-bottom: 1rem;">
                <li>1. Pastikan conveyor dalam keadaan berhenti, dan cover terangkat dengan aman</li>
                <li>2. Probe dimasukkan ke posisi pengukuran sesuai dengan nomor pada gambar di bawah</li>
                <li>3. Penutup diturunkan, pastikan probe tercelup dalam minyak dan pada titik yang tepat</li>
                <li>4. Fryer dinyalakan, dan staf kalibrasi memantau kenaikan suhu minyak hingga dalam kondisi mantap (stabil)</li>
                <li>5. Perekaman data dimulai, dengan interval pembacaan setiap 1 menit, selama 30 menit </li>
                <li>6. Apabila sudah selesai, hentikan mesin dan angkat cover penutup</li>
                <li>7. Probe dirapikan, lalu dilakukan penarikan dan penginterpretasian data</li>
            </ul>

            <div style="width: 100%; text-align: center; margin-bottom: 2rem;">
                @php
                    $path = public_path('storage/image/uji_tanpa_produk.jpg');
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp
                <img src="{{ $base64 }}" alt="midilogger" style="width: 50%; margin: auto;">
            </div>
        </div>

        <div>
            <h4>Uji Dengan Produk</h4>
            <ul style="margin-bottom: 1rem;">
                <li>1. Thermologger disiapkan, dinyalakan dengan interval pembacaan setiap 1 detik</li>
                <li>2. Sensor dimasukkan ke dalam produk, seperti pada gambar di bawah ini</li>
                <li>3. Produk ditempatkan pada 5 posisi, seperti pada gambar di bawah ini</li>
                <li>4. Produk yang tertusuk sensor diletakkan pada infeed Fryer, dan biarkan masuk ke dalam minyak</li>
                <li>5. Tunggu produk keluar di outfeed fryer</li>
                <li>6. Apabila produk sudah keluar, dilakukan penarikan dan penginterpretasian data</li>
            </ul>

            <div style="width: 100%; text-align: center; margin-bottom: 1rem;">
                @php
                    $path = public_path('storage/image/uji_dengan_produk.jpg');
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                @endphp
                <img src="{{ $base64 }}" alt="midilogger" style="width: 55%; margin: auto;">
            </div>
        </div>
        
    </div>

    {{-- tabel 1 uji persebaran suhu --}}
    <div class="row mb-3">
        <h3 style="margin-bottom: 1rem !important;">HASIL UJI PERSEBARAN SUHU</h3>

        <table class="table-bordered" style="width: 80%; margin: auto;">
            <thead>
                <tr>
                    <th class="tg-0lax"></th>
                    <th class="tg-0lax">CH 1</th>
                    <th class="tg-0lax">CH 2</th>
                    <th class="tg-0lax">CH 3</th>
                    <th class="tg-0lax">CH 4</th>
                    <th class="tg-0lax">CH 5</th>
                    <th class="tg-0lax">CH 6</th>
                    <th class="tg-0lax">CH 7</th>
                    <th class="tg-0lax">CH 8</th>
                    <th class="tg-0lax">CH 9</th>
                    <th class="tg-0lax">CH 10</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tg-0lax">Suhu Awal </td>
                    <td class="tg-0lax">{{ $suhuAwal->ch1 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch2 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch3 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch4 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch5 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch6 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch7 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch8 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch9 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAwal->ch10 ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="tg-0lax">Speed&nbsp;&nbsp;</td>
                    <td class="tg-0lax" colspan="10">{{ $suhuAwal->speed ?? '-' }} Hz</td>
                </tr>
                <tr>
                    <td class="tg-0lax">Suhu Akhir </td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch1 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch2 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch3 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch4 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch5 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch6 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch7 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch8 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch9 ?? '-' }}</td>
                    <td class="tg-0lax">{{ $suhuAkhir->ch10 ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="tg-0lax">Speed&nbsp;&nbsp;</td>
                    <td class="tg-0lax" colspan="10">{{ $suhuAkhir->speed ?? '-' }} Hz</td>
                </tr>
                <tr>
                    <td class="tg-0lax">Durasi</td>
                    <td class="tg-0lax" colspan="10">
                        @if($duration)
                            {{ $duration->format('%H jam %I menit %S detik') }}
                            ({{ $suhuAwal->time }} - {{ $suhuAkhir->time }})
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <p style="text-align: center;"> <strong>Tabel. 1</strong> Perubahan Suhu per Channel pada Kecepatan 5 Hz dari Suhu Awal ke Suhu Akhir</p>

        @php
            $chRangeAwal = collect(range(1, 10))->map(function ($ch) use ($suhuAwal) {
                return $suhuAwal?->{'ch' . $ch};
            })->filter();

            $chRangeAkhir = collect(range(1, 10))->map(function ($ch) use ($suhuAkhir) {
                return $suhuAkhir?->{'ch' . $ch};
            })->filter();

            if ($chRangeAwal->count() && $chRangeAkhir->count()) {
                $minAwal = $chRangeAwal->min();
                $maxAwal = $chRangeAwal->max();
                $minAkhir = $chRangeAkhir->min();
                $maxAkhir = $chRangeAkhir->max();
            }
        @endphp

        <p>
            Pengambilan data suhu berlangsung selama {{ $duration }}, dimulai pada pukul {{ $suhuAwal->time }} dan berakhir pada pukul {{ $suhuAkhir->time }}. 
            Selama awal pengambilan data, suhu terukur pada berbagai channel menunjukkan kisaran antara {{ $minAwal }} &deg;C hingga {{ $maxAwal }} &deg;C. 
            Sementara itu, pada akhir periode pengambilan, suhu berada dalam rentang antara {{ $minAkhir }} &deg;C hingga {{ $maxAkhir }} &deg;C.
        </p>

        <p>{{ $dataFryerMarel ->notes_sebaran }}</p>
    </div>

    {{-- Grafik 1. Persebaran suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut:</p>

        <img src="{{ $chartUrlFryerMarel }}" style="width: 100%; margin: auto;">
        <p style="text-align: center;"> <strong>Grafik 1.</strong>  Persebaran Suhu {{ $dataFryerMarel->nama_mesin }} </p>

        @php
            $kesimpulanGrafik = '';

            if (isset($avgAllSpot, $maxSpot, $minSpot, $duration)) {
                $kesimpulanGrafik .= 'Berdasarkan hasil pengamatan terhadap grafik suhu yang ditampilkan, dapat disimpulkan bahwa suhu rata-rata yang tercatat selama periode pemantauan adalah sebesar ' . number_format($avgAllSpot, 2) . '  °C,';

                $kesimpulanGrafik .= 'Suhu tertinggi yang berhasil dicatat mencapai angka ' . $maxSpot['value'] . ' °C, dan hal ini terjadi pada Channel ' . $maxSpot['channel'] . ', ';

                $kesimpulanGrafik .= 'Sebaliknya, suhu terendah yang terdeteksi berada pada angka ' . $minSpot['value'] . ' °C, yang tercatat pada Channel ' . $minSpot['channel'] . ', ';

                $kesimpulanGrafik .= 'Seluruh data suhu ini diperoleh melalui proses pemantauan yang berlangsung selama ' . $duration->format('%H jam %I menit %S detik') . ', ';
            }
        @endphp

        <p>{!! $kesimpulanGrafik !!}</p>
        <p>{{ $dataFryerMarel ->notes_grafik }}</p>
    </div>

    {{-- table luar range --}}
    <div class="row mb-3" style="page-break-before: always;">
        <p>Berdasarkan grafik, berikut detail lengkap suhu awal, suhu akhir, dan durasi pemantauan di setiap titik sensor yang berada di luar range setting suhu mesin</p>
        @if(count($anomalies) > 0)
            <table class="table-bordered mb-3" style="width: 80%; margin: auto;">
                <thead>
                    <tr>
                        <th>Titik Sensor</th>
                        <th style="background-color: #E3F2FD">Waktu Mulai</th>
                        <th style="background-color: #E3F2FD">Suhu Awal</th>
                        <th style="background-color: #E8F5E9">Waktu Selesai</th>
                        <th style="background-color: #E8F5E9">Suhu Akhir</th>
                        <th>Durasi (menit)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anomalies as $anomaly)
                    <tr class="{{ strtolower($anomaly['status']) }}">
                        <td>Titik {{ $anomaly['titik'] }}</td>
                        <td style="background-color: #E3F2FD">{{ $anomaly['start_time']->format('H:i:s') }}</td>
                        <td style="background-color: #E3F2FD">
                            {{ number_format($anomaly['suhu_awal_anomali'], 1) }} °C
                        </td>
                        <td style="background-color: #E8F5E9">{{ $anomaly['end_time']->format('H:i:s') }}</td>
                        <td style="background-color: #E8F5E9">{{ number_format($anomaly['suhu_terakhir'], 1) }} °C</td>
                        <td>{{ $anomaly['duration'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-anomaly">
                <p>Tidak ditemukan anomali suhu diluar range normal</p>
            </div>
        @endif

        <p style="text-align: center;"> <strong>Tabel. 2</strong> Durasi suhu di luar range setting suhu mesin (spek)</p>

        <div>
            {!! $conclusion !!}
        </div>

        <p>{{ $dataFryerMarel ->notes_luar_range }}</p>
    </div>

    {{-- hasil sebaran suhu --}}
    <div class="row mb-3">
        <h4>Hasil:</h4>
        <h4>1. Sebaran Suhu</h4>

        <table class="table-bordered" style="width: 80%; margin: auto; margin-top: 1rem;">
        <thead>
            <tr>
                <th colspan="6">Keseragaman Suhu</th>
                <th colspan="2">Kinerja Alat</th>
            </tr>
            <tr>
                <th>Set Suhu (°C)</th>
                <th>Posisi (°C)</th>
                <th>Pembacaan<br>Alat (°C)</th>
                <th>Pembacaan<br>Midilogger<br>(°C)</th>
                <th>Koreksi (°C)</th>
                <th>Uncertainty<br>(°C)</th>
                <th>Keseragaman<br>Suhu (°C)</th>
                <th>Stabilitas<br>Suhu (°C)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $channelAverages = [];
                for ($i = 1; $i <= 10; $i++) {
                    $channelKey = 'ch' . $i;
                    $channelAverages[$i] = round($suhuData->avg($channelKey), 2);
                }

                $setSuhu = $dataFryerMarel->setting_suhu_mesin ?? '155';
                $pembacaanAlat = 155; // nilai tetap
                $uncertainty = '';
                $keseragamanSuhu = 85.2;
                $stabilitasSuhu = 16.15;
            @endphp

            @for ($i = 1; $i <= 10; $i++)
                @php
                    $pembacaanMidilogger = $channelAverages[$i];
                    $koreksi = round($pembacaanMidilogger - $pembacaanAlat, 2);
                @endphp
                <tr>
                    @if ($i === 1)
                        <td rowspan="10">{{ $setSuhu }}</td>
                    @endif

                    <td>{{ $i }}</td>

                    @if ($i === 1)
                        <td rowspan="10">{{ $pembacaanAlat }}</td>
                    @endif

                    <td>{{ $pembacaanMidilogger }}</td>
                    <td>{{ $koreksi >= 0 ? '+' . $koreksi : $koreksi }}</td>

                    @if ($i === 1)
                        <td rowspan="10">{{ $uncertainty }}</td>
                        <td rowspan="10">{{ $keseragamanSuhu }}</td>
                        <td rowspan="10">{{ $stabilitasSuhu }}</td>
                    @endif
                </tr>
            @endfor
        </tbody>
        </table>

        <p style="text-align: center;"> <strong>Tabel. 3</strong> Analisis Keseragaman dan Kinerja Alat</p>

        @php
            $kesimpulanTabel = '';

            // Rata-rata pembacaan midilogger seluruh channel
            $avgMidilogger = collect($channelAverages)->avg();

            // Koreksi rata-rata
            $avgKoreksi = round($avgMidilogger - $pembacaanAlat, 2);

            $kesimpulanTabel .= "Berdasarkan hasil pengukuran terhadap keseragaman suhu pada alat, ditetapkan bahwa suhu yang diatur (set suhu) adalah sebesar {$setSuhu} °C. ";
            $kesimpulanTabel .= "Pembacaan suhu yang ditampilkan oleh alat menunjukkan angka sebesar {$pembacaanAlat} °C, sementara nilai rata-rata pembacaan dari seluruh channel midilogger adalah sebesar " . number_format($avgMidilogger, 2) . " °C. ";
            $kesimpulanTabel .= "Dengan demikian, terdapat koreksi rata-rata sebesar " . ($avgKoreksi >= 0 ? "+{$avgKoreksi}" : $avgKoreksi) . " °C.";
        @endphp

        <p>{!! $kesimpulanTabel !!}</p>

        <p>{{ $dataFryerMarel ->notes_keseragaman }}</p>

        <div style="width: 100%; text-align: center; margin-bottom: 1rem; margin-top: 1rem;">
            @php
                $path = public_path('storage/image/uji_tanpa_produk.jpg');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            @endphp
            <img src="{{ $base64 }}" alt="midilogger" style="width: 50%; margin: auto;">
        </div>

        <h4>Catatan:</h4>
        <ul>
            <li>1. Metode Kalibrasi / Method of Calibration : KAN PD-02.04</li>
            <li>2.Perhitungan ketidakpastian mengacu ke / Calculation of uncercertainty refer to : JCGM 100-2008 : Evaluation of Measurement Data - Guide to Expression of Uncertainty in Measurement</li>
            <li>3. Ketidakpastian pengukuran diestimasi pada tingkat kepercayaan 95% dengan faktor cakupan k = 2</li>
        </ul>

        <table width="100%" style="text-align: left; margin-top: 1rem;">
            <tr>
                <td width="50%">
                    <p>Salatiga, {{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}</p>
                    <p style="margin-bottom: 4rem;">Disusun Oleh,</p>
                    <p>Fahbi A Basharo</p>
                    <p style="font-style: italic">Technician</p>
                </td>
                <td width="50%">
                    <br>
                    <p style="margin-bottom: 4rem;">Disahkan Oleh,</p>
                    <p>Anggun N Arifiana</p>
                    <p style="font-style: italic">Supervisor</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- data pengukuran --}}
    <div class="row mb-3" style="page-break-before: always;">
        <h4>2. Data Pengukuran</h4>
        <table class="table-bordered" style="width: 100%; margin: auto; margin-top: 1rem;">
            <thead>
                <tr>
                    <th class="tg-0lax">Menit ke-</th>
                    <th class="tg-0lax">Waktu</th>
                    @for ($i = 1; $i <= 10; $i++)
                        <th class="tg-0lax">CH{{ $i }}<br>(&deg;C)</th>
                    @endfor
                    <th class="tg-0lax">Display Mesin(&deg;C)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suhuData as $index => $suhu)
                    <tr>
                        <td class="tg-0lax">{{ $index + 1 }}</td>
                        <td class="tg-0lax">&nbsp;&nbsp;{{ \Carbon\Carbon::parse($suhu->time)->format('H:i:s') }}</td>
                        @for ($i = 1; $i <= 10; $i++)
                            <td class="tg-0lax">{{ number_format($suhu->{'ch'.$i}, 2, '.', '.') }}</td>
                        @endfor
                        <td class="tg-0lax">{{ $suhu->display_mesin ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="tg-0lax" colspan="2">AVG</td>
                    @for ($i = 1; $i <= 10; $i++)
                        <td class="tg-0lax">{{ number_format($avg['ch'.$i], 2, '.', '.') }}</td>
                    @endfor
                    <td class="tg-0lax">{{ number_format($avg['display_mesin'], 0, '.', '.') }}</td>
                </tr>
                <tr>
                    <td class="tg-0lax" colspan="2">MAX</td>
                    @for ($i = 1; $i <= 10; $i++)
                        <td class="tg-0lax">{{ number_format($max['ch'.$i], 2, '.', '.') }}</td>
                    @endfor
                    <td class="tg-0lax">{{ number_format($max['display_mesin'], 0, '.', '.') }}</td>
                </tr>
                <tr>
                    <td class="tg-0lax" colspan="2">MIN</td>
                    @for ($i = 1; $i <= 10; $i++)
                        <td class="tg-0lax">{{ number_format($min['ch'.$i], 2, '.', '.') }}</td>
                    @endfor
                    <td class="tg-0lax">{{ number_format($min['display_mesin'], 0, '.', '.') }}</td>
                </tr>
                <tr>
                    <td class="tg-0lax" colspan="2" style="background:#bcd4e6">
                        MAX (Spot)
                        <td class="tg-0lax" colspan="11" style="background:#bcd4e6">
                             {{ number_format($maxSpot['value'], 2, '.', '.') }} Titik {{ $maxSpot['channel'] }}
                        </td>
                    </td>
                </tr>
                <tr>
                    <td class="tg-0lax" colspan="2" style="background:#bcd4e6">
                        MIN (Spot) 
                        <td class="tg-0lax" colspan="11" style="background:#bcd4e6">
                            {{ number_format($minSpot['value'], 2, '.', '.') }} Titik {{ $minSpot['channel'] }}
                        </td>
                    </td>
                </tr>
                <tr>
                    <td class="tg-0lax" colspan="2" style="background:#bcd4e6">
                        AVG (All Spot) 
                        <td class="tg-0lax" colspan="11" style="background:#bcd4e6">
                            {{ number_format($avgAllSpot, 2, '.', '.') }}
                        </td>
                    </td>
                </tr>
            </tfoot>
        </table>
        <p style="text-align: center;"> <strong>Tabel. 4</strong> Rekaman suhu 10 titik sensor</p>

        @php
            $kesimpulanPerMenit = '';

            // Suhu rata-rata keseluruhan
            $kesimpulanPerMenit .= 'Selama periode pemantauan, suhu yang tercatat dari 10 channel menunjukkan, ';
            $kesimpulanPerMenit .= 'Nilai suhu rata-rata keseluruhan dari semua titik pengukuran adalah sebesar ' . number_format($avgAllSpot, 2) . ' °C, ';
            $kesimpulanPerMenit .= 'dengan titik suhu tertinggi mencapai ' . number_format($maxSpot['value'], 2) . ' °C yang tercatat pada Channel ' . $maxSpot['channel'] . ', ';
            $kesimpulanPerMenit .= 'dan suhu terendah sebesar ' . number_format($minSpot['value'], 2) . ' °C pada Channel ' . $minSpot['channel'] . '. ';

            // Kinerja display mesin
            $kesimpulanPerMenit .= 'Display mesin menunjukkan suhu rata-rata sebesar ' . number_format($avg['display_mesin'], 0) . ' °C, ';
            $kesimpulanPerMenit .= 'dengan nilai maksimum mencapai ' . number_format($max['display_mesin'], 0) . ' °C dan minimum sebesar ' . number_format($min['display_mesin'], 0) . ' °C. ';

            // Perbedaan antar channel
            $selisihMaxMin = number_format($maxSpot['value'] - $minSpot['value'], 2);
            $kesimpulanPerMenit .= 'Rentang suhu antara titik tertinggi dan terendah menunjukkan selisih sebesar ' . $selisihMaxMin . ' °C. ';

            // Stabilitas waktu
            $jumlahMenit = count($suhuData);
            $kesimpulanPerMenit .= 'Data dicatat secara berkala selama ' . $jumlahMenit . ' menit. ';
        @endphp

        <p>{!! $kesimpulanPerMenit !!}</p>
        <p>{{ $dataFryerMarel ->notes_rekaman }}</p>
    </div>

    <div class="row mb-3">
        <h3>KESIMPULAN</h3>
        <p>{{ $dataFryerMarel ->kesimpulan }}</p>
    </div>
</body>
</html>