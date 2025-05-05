@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="d-flex justify-center align-content-center align-items-center mb-3">
                        <div class="col-sm-2">
                            <label for="start_pengujian" class="form-label">Waktu Mulai Pengujian</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="start_pengujian" id="start_pengujian" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-center align-content-center align-items-center mb-3">
                        <div class="col-sm-2">
                            <label for="end_pengujian" class="form-label">Waktu Akhir Pengujian</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="end_pengujian" id="end_pengujian" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-center align-content-center align-items-center mb-3">
                        <div class="col-sm-2">
                            <label for="pengujian" class="form-label">Pengujian Ke</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="number" name="pengujian" id="pengujian" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="ingredient" class="form-label">Ingredient</label>
                        <input type="text" name="ingredient" id="ingredient" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="kemasan" class="form-label">Kemasan</label>
                        <input type="text" name="kemasan" id="kemasan" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="nama_mesin" class="form-label">Nama Mesin</label>
                        <input type="text" name="nama_mesin" id="nama_mesin" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="dimensi" class="form-label">Dimensi (p x l x t) </label>
                        <input type="text" name="dimensi" id="dimensi" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas ABF</label>
                        <input type="text" name="kapasitas" id="kapasitas" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="susuan" class="form-label">Jumlah susunan dalam rak</label>
                        <input type="text" name="susunan" id="susunan" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="isi_rak" class="form-label">Isi rak saat pengujian</label>
                        <input type="text" name="isi_rak" id="isi_rak" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="penumpukan" class="form-label">Penumpukan produk</label>
                        <input type="text" name="penumpukan" id="penumpukan" class="form-control">
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label for="target_suhu" class="form-label">Target suhu inti produk</label>
                        <input type="text" name="target_suhu" id="target_suhu" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="target_suhu" class="form-label">Set suhu thermostat</label>
                        <input type="text" name="target_suhu" id="target_suhu" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="nama_mesin_2" class="form-label">Nama Mesin</label>
                        <input type="text" name="nama_mesin_2" id="nama_mesin_2" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="merek_mesin_2" class="form-label">Merek</label>
                        <input type="text" name="merek_mesin_2" id="merek_mesin_2" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="tipe_mesin_2" class="form-label">Tipe</label>
                        <input type="text" name="tipe_mesin_2" id="tipe_mesin_2" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="freon_mesin_2" class="form-label">Freon</label>
                        <input type="text" name="freon_mesin_2" id="freon_mesin_2" class="form-control">
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="kapasitas_mesin_2" class="form-label">Kapasitas</label>
                        <input type="text" name="kapasitas_mesin_2" id="kapasitas_mesin_2" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control">
                    </div>
                </div>

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
                    <div class="col-sm-6 text-center">
                        <div>
                            <img src="{{ url('/image/midilogger.jpg') }}" alt="midilogger" class="img-fluid mx-auto d-block mb-3">
                            <p>Midilogger Thermologger GL-260</p>
                        </div>
                        <div>
                            <img src="{{ url('/image/ebro.jpg') }}" alt="thermologger" class="img-fluid mx-auto d-block mb-3">
                            <p>EBRO EBI-11 thermologger</p>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div>
                            <p>LAYOUT PENEMPATAN SENSOR SEBARAN SUHU 9 TITIK</p>
                            <img src="{{ url('/image/layout1.jpg') }}" alt="probe" class="img-fluid mx-auto d-block mb-3">
                            <p>Gambar 1. Peletakan probe sensor suhu Thermocouple Tipe K untuk persebaran suhu</p>
                        </div>
                        <div>
                            <p>LAYOUT PENEMPATAN SENSOR CORE TEMPERATURE PRODUK</p>
                            <img src="{{ url('/image/layout2.jpg') }}" alt="core" class="img-fluid mx-auto d-block mb-3">
                            <p>Gambar 2. Peletakan griller yang terisi thermologger</p>
                        </div>
                    </div> 
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

                {{-- excel --}}
                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="persebaran_suhu" class="form-label">Uji Persebaran Suhu</label>
                        <input class="form-control" type="file" name="persebaran_suhu" id="persebaran_suhu" accept=".xls,.xlsx" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="penetrasi_suhu" class="form-label">Uji Penetrasi Suhu</label>
                        <input class="form-control" type="file" name="penetrasi_suhu" id="penetrasi_suhu" accept=".xls,.xlsx" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection