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
            <h3 class="mb-5 mt-4 text-center">Form Fryer {{$asset->detail}}</h3>
            <form action="{{ route('validation.storeDataFryer', $asset->uuid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <select name="fryer_product_id" id="fryer_product_id" class="form-control" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($product as $produk)
                            <option value="{{ $produk->id }}"
                                data-min="{{ $produk->setting_min }}"
                                data-max="{{ $produk->setting_max }}">
                                {{ $produk->product_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="ingredient" class="form-label">Ingredient</label>
                        <input type="text" name="ingredient" id="ingredient" class="form-control" placeholder="Masukkan ingredient" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="packaging" class="form-label">Kemasan</label>
                        <input type="text" name="packaging" id="packaging" class="form-control" placeholder="Masukkan nama kemasan" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="machine_name" class="form-label">Nama Mesin</label>
                        <input type="text" name="machine_name" id="machine_name" class="form-control" placeholder="Masukkan nama mesin" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="dimension" class="form-label">Dimensi (p x l x t) </label>
                        <input type="text" name="dimension" id="dimension" class="form-control" placeholder="Masukkan dimesni (p x l x t)" required>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label for="target_temperature" class="form-label">Target suhu inti produk</label>
                        <input type="text" name="target_temperature" id="target_temperature" class="form-control" placeholder="Masukkan target suhu inti produk" required>
                    </div>
                </div>

                {{-- time --}}
                <div class="row mb-3">
                    <div class="d-flex justify-center align-content-center align-items-center mb-3">
                        <div class="col-sm-2">
                            <label for="start_testing" class="form-label">Waktu Mulai Pengujian</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="start_testing" id="start_testing" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-center align-content-center align-items-center mb-3">
                        <div class="col-sm-2">
                            <label for="end_testing" class="form-label">Waktu Akhir Pengujian</label>
                        </div>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="end_testing" id="end_testing" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label for="setting_machine_temperature" class="form-label">Setting Suhu Mesin</label>
                        <input type="text" name="setting_machine_temperature" id="setting_machine_temperature" class="form-control" required readonly>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="product_infeed_time" class="form-label">Waktu Produk Dari Infeed ke Outfeed</label>
                        <input type="time" step="0.001" name="product_infeed_time" id="product_infeed_time" class="form-control" placeholder="HH:MM:SS.MS (contoh: 14:30:15.123)" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="initial_core_temperature" class="form-label">Suhu Awal Inti Produk</label>
                        <input type="text" name="initial_core_temperature" id="initial_core_temperature" class="form-control" placeholder="Masukkan suhu awal" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="final_core_temperature" class="form-label">Suhu Akhir Inti Produk</label>
                        <input type="text" name="final_core_temperature" id="final_core_temperature" class="form-control" placeholder="Masukkan suhu akhir" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="batch" class="form-label">batch ke-</label>
                        <input type="text" name="batch" id="batch" class="form-control" placeholder="Masukkan batch" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="cooking_time" class="form-label">Waktu Pemasakan</label>
                        <input type="time" step="0.001" name="cooking_time" id="cooking_time" class="form-control" placeholder="HH:MM:SS.MS (contoh: 14:30:15.123)" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="machine_name_2" class="form-label">Nama Mesin</label>
                        <input type="text" name="machine_name_2" id="machine_name_2" class="form-control" placeholder="Masukkan nama mesin" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="machine_brand_2" class="form-label">Merek</label>
                        <input type="text" name="machine_brand_2" id="machine_brand_2" class="form-control" placeholder="Masukkan merk" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="machine_type_2" class="form-label">Tipe</label>
                        <input type="text" name="machine_type_2" id="machine_type_2" class="form-control" placeholder="Masukkan tipe" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="machine_speed_conv_2" class="form-label">Speed Conv</label>
                        <input type="text" name="machine_speed_conv_2" id="machine_speed_conv_2" class="form-control" placeholder="Masukkan Speed" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="machine_capacity_2" class="form-label">Kapasitas</label>
                        <input type="text" name="machine_capacity_2" id="machine_capacity_2" class="form-control" placeholder="Masukkan kapasitas" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6 mb-3">
                        <label for="location" class="form-label">Lokasi</label>
                        <input type="text" name="location" id="location" class="form-control" placeholder="Masukkan lokasi" required>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Masukkan alamat" required>
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
                            <label for="distribution_notes" class="form-label">Notes Sebaran Suhu</label>
                            <textarea class="form-control" name="distribution_notes" id="distribution_notes" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="chart_notes" class="form-label">Notes Grafik</label>
                            <textarea class="form-control" name="chart_notes" id="chart_notes" placeholder="Masukkan notes"></textarea>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="out_of_range_notes" class="form-label">Notes Luar Range</label>
                            <textarea class="form-control" name="out_of_range_notes" id="out_of_range_notes" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="uniformity_notes" class="form-label">Notes Keseragaman Suhu</label>
                            <textarea class="form-control" name="uniformity_notes" id="uniformity_notes" placeholder="Masukkan notes"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 mb-3">
                            <label for="transcription_notes" class="form-label">Notes Rekaman Suhu</label>
                            <textarea class="form-control" name="transcription_notes" id="transcription_notes" placeholder="Masukkan notes"></textarea>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="conclusion" class="form-label">Kesimpulan</label>
                            <textarea class="form-control" name="conclusion" id="conclusion" placeholder="Masukkan kesimpulan" required></textarea>
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
<script>
    document.getElementById('fryer_product_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const min = selectedOption.getAttribute('data-min');
        const max = selectedOption.getAttribute('data-max');
        const suhuInput = document.getElementById('setting_suhu_mesin');

        if (min && max) {
            suhuInput.value = `${min}-${max}`;
        } else {
            suhuInput.value = '';
        }
    });
</script>
@endsection