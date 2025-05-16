<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Validasi Fryer 1</title>
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
                        HASIL VALIDASI MESIN<br>
                    </h2>
                </td>
            </tr>
        </table>
    </div>

    {{-- penetrasi suhu dingin --}}
    <h3 style="text-transform: uppercase;">penetrasi suhu dingin</h3>
    <table class="table-bordered mb-3" style="width: 40%;">
        <tr>
            <td style="padding: 1px;">Waktu Mulai Pengujian</td>
            <td style="padding: 1px;">-</td>
            <td style="padding: 1px;">-</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Waktu Akhir Pengujian</td>
            <td style="padding: 1px;">-</td>
            <td style="padding: 1px;">-</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Pengujian ke</td>
            <td colspan="2" style="padding: 1px;">-</td>
        </tr>
    </table>

    <table class="table-bordered mb-3" style="width: 50%;">
        <tr>
            <td style="padding: 1px;">Nama Produk</td>
            <td style="padding: 1px;">-</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-top: .75rem;">
        <tr>
            <td style="width: 30%; border: 1px solid black; vertical-align: top; padding: 2px;">
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
            <td style="width: 70%; border: 1px solid black; vertical-align: top; padding: 2px;">
                - <br>
                - <br>
                - <br>
                - <br>
                - <br>
                - <br>
                - <br>
                - <br>
                - <br>
                -
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 1rem;">Nama Mesin</h3>
    <ul>
        <li>-</li>
    </ul>
    <table class="table-bordered mb-3" style="width: 40%;">
        <tr>
            <td style="padding: 1px;">Merek</td>
            <td colspan="2" style="padding: 1px;">-</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Tipe</td>
            <td colspan="2" style="padding: 1px;">-</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Freon</td>
            <td colspan="2" style="padding: 1px;">-</td>
        </tr>
        <tr>
            <td style="padding: 1px;">Kapasitas</td>
            <td colspan="2" style="padding: 1px;">-</td>
        </tr>
    </table>

    <h3 style="margin-top: 1rem; margin-bottom: unset;">Lokasi</h3>
    <ul>
        <li>-</li>
        <li>-</li>
    </ul>

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
            <li>2. Mengetahui lama waktu yang dibutuhkan griller untuk mencapai suhu -18 &deg;C</li>
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
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                </tr>
                <tr>
                <td class="tg-0lax">Durasi sejak start ABF (menit)</td>
                <td class="tg-0lax" colspan="8">0</td>
                </tr>
                <tr>
                <td class="tg-0lax">yakni pada jam </td>
                <td class="tg-0lax" colspan="8">-</td>
                </tr>
                <tr>
                    <td class="tg-0lax">SUHU AKHIR</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                    <td class="tg-0lax">-</td>
                </tr>
                <tr>
                <td class="tg-0lax">Durasi sejak start ABF</td>
                <td class="tg-0lax" colspan="8">
                    -
                </td>
                </tr>
                <tr>
                <td class="tg-0lax">yakni pada jam </td>
                <td class="tg-0lax" colspan="8">-</td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Tabel 1.</strong> Hasil Pengukuran Persebaran Suhu Pada Ruang</p>

        <div>
            <p>Berdasarkan tabel di atas, dapat diperoleh informasi berupa:</p>
            <ul>
                <li>1</li>
                <li>1</li>
                <li>1</li>
            </ul>
        </div>
    </div>
        
    {{-- Grafik 1. Persebaran suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut:</p>
        {{-- <img src="{{ $chartUrl }}" style="width: 100%; margin: auto;"> --}}
        <p style="text-align: center;"> <strong>Grafik 1.</strong>  Persebaran Suhu Ruang </p>

    </div>

    {{-- spike func --}}

    {{-- tabel 2 durasi keseluruhan spike --}}
    <div class="row mb-3">
        <p>Data terkait durasi spike dituangkan dalam tabel berikut ini:</p>
        <p style="text-align: center;"> <strong>Tabel 2.</strong> Durasi Keseluruhan Terjadinya Spike</p>
        <p>-</p>
        <p>Data terkait peristiwa spike dituangkan dalam tabel berikut ini:</p>
    </div>

    {{-- tabel 3 durasi ketiga spike  --}}
    <div class="row mb-3">

    </div>

    {{-- uji penetrasi suhu --}}
    <div class="row mb-3">
        <h3 style="margin-bottom: 1rem;">UJI PENETRASI SUHU</h3>

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
                    <td class="tg-0pky">-</td>
                    <td class="tg-0pky">-</td>
                    <td class="tg-0pky">-</td>
                    <td class="tg-0pky">-</td>
                </tr>
                <tr>
                    <td class="tg-0pky">Durasi sejak start ABF (menit)</td>
                    <td class="tg-0pky" colspan="4">0</td>
                </tr>
                <tr>
                    <td class="tg-0pky">yakni pada jam </td>
                    <td class="tg-0pky" colspan="4">-</td>
                </tr>
                <tr>
                    <td class="tg-0pky">SUHU AKHIR</td>
                    <td class="tg-0pky">-</td>
                    <td class="tg-0pky">-</td>
                    <td class="tg-0pky">-</td>
                    <td class="tg-0pky">-</td>
                </tr>
                <tr>
                    <td class="tg-0pky">Durasi sejak start ABF</td>
                    <td class="tg-0pky" colspan="4">-</td>
                </tr>
                <tr>
                    <td class="tg-0pky">yakni pada jam </td>
                    <td class="tg-0pky" colspan="4">-</td>
                </tr>
            </tbody>
        </table>

        <p style="text-align: center;"> <strong>Tabel.</strong> Hasil Ketercapaian Suhu Produk</p>

        <div>
            <p>Berdasarkan tabel di atas, dapat diperoleh informasi berupa:</p>
            
        </div>
    </div>

    {{-- grafik penetrasi suhu --}}
    <div class="row mb-3">
        <p>Data pengukuran persebaran suhu ini dapat digambarkan dalam grafik sebagai berikut: </p>
        {{-- <img src="{{ $chartUrlPenetrasi }}" style="width: 100%; margin: auto;"> --}}
        <p style="text-align: center;"> <strong>Grafik 2.</strong> Penetrasi Produk (Griller) Pada ABF</p>

        <p>Data terkait stagnansi suhu ini dituangkan ke dalam tabel sebagai berikut:</p>
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
              <td class="tg-0pky" style="font-weight: bold">terjadi mulai dari jam</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">pada suhu (C)</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">hingga jam </td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">pada suhu (C)</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">total durasi stagnan</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="font-weight: bold">total penurunan suhu saat stagnan (C)</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
              <td class="tg-0pky">-</td>
            </tr>
          </tbody>
        </table>

        <p style="text-align: center;"> <strong>Tabel.</strong> Durasi Stagnansi Suhu Inti Produk
        </p>
        <p>
           -
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
                <td class="tg-0pky" style="background-color: rgb(181, 218, 255);"></td>
                <td class="tg-rleq" colspan="4" style="background-color: rgb(181, 218, 255); font-weight: bold;">Mencapai 0,0 &deg;C dari start</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">durasi</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">pada jam</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="background-color: rgb(181, 218, 255);"></td>
                <td class="tg-0pky" colspan="4" style="background-color: rgb(181, 218, 255);font-weight: bold;">Mencapai -18,0 &deg;C dari Start </td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">durasi</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                </tr>
                <tr>
                <td class="tg-0pky" style="font-weight: bold;">pada jam</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                <td class="tg-0pky">-</td>
                </tr>
            </tbody>
        </table>
        <p style="text-align: center;"> <strong>Tabel.</strong> Ketercapaian Suhu Produk
        </p>
        <p>-</p>
           
    </div>

    {{-- kesimpulan --}}
    <div class="row mb-3">
        <h3 class="mb-3" style="margin-bottom: 1rem;">G. KESIMPULAN</h3>
        <ul style="list-style-type: none;">
            <li>-</li>
            <li>-</li>
        </ul>
    </div>
</body>
</html>