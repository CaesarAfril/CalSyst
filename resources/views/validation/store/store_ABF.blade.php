@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card-body">
            <h3 class="mb-5 mt-4 text-center">Form ABF</h3>
            <form action="{{ route('validation.storeABF', $asset->uuid) }}" method="POST" enctype="multipart/form-data">
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
                            <input type="number" name="pengujian" id="pengujian" class="form-control" placeholder="Masukkan pengujian" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Masukkan nama produk" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="ingredient" class="form-label">Ingredient</label>
                        <input type="text" name="ingredient" id="ingredient" class="form-control" placeholder="Masukkan ingredient" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="kemasan" class="form-label">Kemasan</label>
                        <input type="text" name="kemasan" id="kemasan" class="form-control" placeholder="Masukkan kemasan" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="nama_mesin" class="form-label">Nama Mesin</label>
                        <input type="text" name="nama_mesin" id="nama_mesin" class="form-control" placeholder="Masukkan nama mesin" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="dimensi" class="form-label">Dimensi (p x l x t) </label>
                        <input type="text" name="dimensi" id="dimensi" class="form-control" placeholder="Masukkan dimensi (p x l x t)" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas ABF</label>
                        <input type="text" name="kapasitas" id="kapasitas" class="form-control" placeholder="Masukkan kapasitas" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="susuan" class="form-label">Jumlah susunan dalam rak</label>
                        <input type="text" name="susunan" id="susunan" class="form-control" placeholder="Masukkan jumlah susunan" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="isi_rak" class="form-label">Isi rak saat pengujian</label>
                        <input type="text" name="isi_rak" id="isi_rak" class="form-control" placeholder="Masukkan isi rak" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="penumpukan" class="form-label">Penumpukan produk</label>
                        <input type="text" name="penumpukan" id="penumpukan" class="form-control" placeholder="Masukkan penumpukan" required>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label for="target_suhu" class="form-label">Target suhu inti produk</label>
                        <input type="text" name="target_suhu" id="target_suhu" class="form-control" placeholder="Masukkan target suhu" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="set_thermostat" class="form-label">Set suhu thermostat</label>
                        <input type="text" name="set_thermostat" id="set_thermostat" class="form-control" placeholder="Masukkan set suhu" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="nama_mesin_2" class="form-label">Nama Mesin</label>
                        <input type="text" name="nama_mesin_2" id="nama_mesin_2" class="form-control" placeholder="Masukkan nama mesin" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="merek_mesin_2" class="form-label">Merek</label>
                        <input type="text" name="merek_mesin_2" id="merek_mesin_2" class="form-control" placeholder="Masukkan merek" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="tipe_mesin_2" class="form-label">Tipe</label>
                        <input type="text" name="tipe_mesin_2" id="tipe_mesin_2" class="form-control" placeholder="Masukkan tipe" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="freon_mesin_2" class="form-label">Freon</label>
                        <input type="text" name="freon_mesin_2" id="freon_mesin_2" class="form-control" placeholder="Masukkan freon" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="kapasitas_mesin_2" class="form-label">Kapasitas</label>
                        <input type="text" name="kapasitas_mesin_2" id="kapasitas_mesin_2" class="form-control" placeholder="Masukkan kapasitas" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Masukkan lokasi" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat" required>
                    </div>
                </div>

                {{-- import all suhu excel --}}
                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="all_suhu" class="form-label">Data sebaran suhu dan suhu pusat produk</label>
                        <input class="form-control" type="file" name="all_suhu" id="all_suhu" accept=".xls,.xlsx" required>
                    </div>
                </div>

                {{-- textarea --}}
                <div class="row mb-3">
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="notes_sebaran" class="form-label">Notes Sebaran Suhu</label>
                            <textarea class="form-control" name="notes_sebaran" id="notes_sebaran" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="notes_grafik" class="form-label">Notes Grafik</label>
                            <textarea class="form-control" name="notes_grafik" id="notes_grafik" placeholder="Masukkan notes"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="notes_durasi_spike" class="form-label">Notes Durasi Spike</label>
                            <textarea class="form-control" name="notes_durasi_spike" id="notes_durasi_spike" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="notes_spike" class="form-label">Notes Spike</label>
                            <textarea class="form-control" name="notes_spike" id="notes_spike" placeholder="Masukkan notes"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="notes_tabel_penetrasi" class="form-label">Notes Tabel Penetrasi</label>
                            <textarea class="form-control" name="notes_tabel_penetrasi" id="notes_tabel_penetrasi" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="notes_grafik_penetrasi" class="form-label">Notes Grafik Penetrasi</label>
                            <textarea class="form-control" name="notes_grafik_penetrasi" id="notes_grafik_penetrasi" placeholder="Masukkan notes"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="notes_stagnansi" class="form-label">Notes Durasi Stagnansi Suhu</label>
                            <textarea class="form-control" name="notes_stagnansi" id="notes_stagnansi" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="notes_ketercapaian" class="form-label">Notes Ketercapaian Suhu</label>
                            <textarea class="form-control" name="notes_ketercapaian" id="notes_ketercapaian" placeholder="Masukkan notes"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="kesimpulan" class="form-label">Kesimpulan</label>
                            <textarea class="form-control" name="kesimpulan" id="kesimpulan" placeholder="Masukkan kesimpulan" required></textarea>
                        </div>
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