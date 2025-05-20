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
            <h3 class="mb-5 mt-4 text-center">Form Fryer 1</h3>
            <form action="{{ route('validation.storeFryer1') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                        <input type="text" name="kemasan" id="kemasan" class="form-control" placeholder="Masukkan nama kemasan" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="nama_mesin" class="form-label">Nama Mesin</label>
                        <input type="text" name="nama_mesin" id="nama_mesin" class="form-control" placeholder="Masukkan nama mesin" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="dimensi" class="form-label">Dimensi (p x l x t) </label>
                        <input type="text" name="dimensi" id="dimensi" class="form-control" placeholder="Masukkan dimesni (p x l x t)" required>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label for="target_suhu" class="form-label">Target suhu inti produk</label>
                        <input type="text" name="target_suhu" id="target_suhu" class="form-control" placeholder="Masukkan target suhu inti produk" required>
                    </div>
                </div>

                {{-- time --}}
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

                    <div class="col-sm-6 mb-3">
                        <label for="setting_suhu_mesin" class="form-label">Setting Suhu Mesin</label>
                        <input type="text" name="setting_suhu_mesin" id="setting_suhu_mesin" class="form-control" placeholder="Masukkan setting suhu mesin" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="waktu_produk_infeed" class="form-label">Waktu Produk Dari Infeed ke Outfeed</label>
                        <input type="time" step="0.001" name="waktu_produk_infeed" id="waktu_produk_infeed" class="form-control"  placeholder="HH:MM:SS.MS (contoh: 14:30:15.123)" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="suhu_awal_inti" class="form-label">Suhu Awal Inti Produk</label>
                        <input type="text" name="suhu_awal_inti" id="suhu_awal_inti" class="form-control" placeholder="Masukkan suhu awal" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="suhu_akhir_inti" class="form-label">Suhu Akhir Inti Produk</label>
                        <input type="text" name="suhu_akhir_inti" id="suhu_akhir_inti" class="form-control" placeholder="Masukkan suhu akhir" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="batch" class="form-label">batch ke-</label>
                        <input type="text" name="batch" id="batch" class="form-control" placeholder="Masukkan batch" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="waktu_pemasakan" class="form-label">Waktu Pemasakan</label>
                        <input type="time" step="0.001" name="waktu_pemasakan" id="waktu_pemasakan" class="form-control"  placeholder="HH:MM:SS.MS (contoh: 14:30:15.123)" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="nama_mesin_2" class="form-label">Nama Mesin</label>
                        <input type="text" name="nama_mesin_2" id="nama_mesin_2" class="form-control" placeholder="Masukkan nama mesin" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="merek_mesin_2" class="form-label">Merek</label>
                        <input type="text" name="merek_mesin_2" id="merek_mesin_2" class="form-control" placeholder="Masukkan merk" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="tipe_mesin_2" class="form-label">Tipe</label>
                        <input type="text" name="tipe_mesin_2" id="tipe_mesin_2" class="form-control" placeholder="Masukkan tipe" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="speed_conv_mesin_2" class="form-label">Speed Conv</label>
                        <input type="text" name="speed_conv_mesin_2" id="speed_conv_mesin_2" class="form-control" placeholder="Masukkan Speed" required>
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
                        <label for="suhu_fryer_1" class="form-label">Data sebaran suhu dan suhu pusat produk</label>
                        <input class="form-control" type="file" name="suhu_fryer_1" id="suhu_fryer_1" accept=".xls,.xlsx" required>
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
                            <label for="notes_luar_range" class="form-label">Notes Luar Range</label>
                            <textarea class="form-control" name="notes_luar_range" id="notes_luar_range" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="notes_keseragaman" class="form-label">Notes Keseragaman Suhu</label>
                            <textarea class="form-control" name="notes_keseragaman" id="notes_keseragaman" placeholder="Masukkan notes"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="notes_rekaman" class="form-label">Notes Rekaman Suhu</label>
                            <textarea class="form-control" name="notes_rekaman" id="notes_rekaman" placeholder="Masukkan notes"></textarea>
                        </div>
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