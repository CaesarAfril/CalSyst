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
        <h3>A. IDENTIFIKASI</h3>
        <ul style="list-style-type: none;">
            <li>1. Melakukan validasi kesesuaian distribusi suhu dalam mesin Fryer Marel</li>
            {{-- <li>2. Melakukan validasi kesesuaian penetrasi suhu pada produk Griller Yamiku pada saat proses blast freezing</li> --}}
        </ul>
    </div>

    {{-- tujuan --}}
    <div class="row mb-3">
        <h3>B. TUJUAN</h3>
        <ul style="list-style-type: none;">
            <li>1. Mengetahui kinerja persebaran suhu Fryer Marel</li>
            {{-- <li>2. Mengetahui lama waktu yang dibutuhkan griller untuk mencapai suhu -18 &deg;C</li> --}}
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
                    <img src="{{ $base64 }}" alt="midilogger" style="width: 80%;">
                    <p>Midilogger Thermologger GL-260</p>
                </td>
                <td width="50%">
                    @php
                        $path = public_path('storage/image/ebro.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="thermologger" style="width: 80%;">
                    <p>EBRO EBI-11 thermologger</p>
                </td>
            </tr>
        </table>

        {{-- <table width="100%" style="text-align: center;">
            <tr>
                <td width="50%">
                    <p><strong>LAYOUT PENEMPATAN SENSOR SEBARAN SUHU 9 TITIK</strong></p>
                    @php
                        $path = public_path('storage/image/layout1.jpg');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="probe" style="width: 80%;">
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
                    <img src="{{ $base64 }}" alt="core" style="width: 80%;">
                    <p><em>Gambar 2. Peletakan griller yang terisi thermologger</em></p>
                </td>
            </tr>
        </table>         --}}
    </div>

    {{-- tabel 1 uji persebaran suhu --}}
    <div class="row mb-3">
        <h3 style="margin-bottom: 1rem !important;">E. HASIL UJI PERSEBARAN SUHU</h3>

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
    </div>

    {{-- Grafik 1. Persebaran suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut:</p>

        <img src="{{ $chartUrlFryerMarel }}" style="width: 100%; margin: auto;">
        <p style="text-align: center;"> <strong>Grafik 1.</strong>  Persebaran Suhu {{ $dataFryerMarel->nama_mesin }} </p>
    </div>

    {{-- table luar range --}}
    <div class="row mb-3">
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
    </div>
</body>
</html>