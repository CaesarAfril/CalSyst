@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center align-content-center p-0 mb-4">
            <span>Data Aset Alat Ukur</span> 
            <div class="d-flex justify-content-between align-items-center gap-5">
                <form id="searchForm" method="GET" class="d-flex align-items-center gap-2 mb-0">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="Ketik untuk mencari" name="search" value="{{ request('search') }}">
                        <button class="btn btn-info" type="submit">Search</button>
                        <a href="{{ route('asset.index') }}" class="btn-reset btn btn-primary">Reset</a>
                    </div>
                </form>
            
                <div class="d-flex gap-2">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                        Import CSV
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addassetModal">
                        +
                    </button>
                </div>
            </div>
            
        </h5>
        <div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{route('asset.importCsv')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importCsvModalLabel">Import CSV</h5>
                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="csv_file" id="csv_file" class="form-control mb-3" required>
                            <button class="btn btn-success" type="submit">Import</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add asset Modal -->
        <div class="modal fade" id="addassetModal" tabindex="-1" aria-labelledby="addassetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('asset.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addassetModalLabel">Tambah asset</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="asset_department" class="form-label">Departemen</label>
                                <select
                                    class="form-control"
                                    id="asset_department"
                                    name="asset_department"
                                    required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->uuid }}">
                                        {{ $department->department }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="asset_plant" class="form-label">Plant</label>
                                <select
                                    class="form-control"
                                    id="asset_plant"
                                    name="asset_plant"
                                    required>
                                    <option value="" disabled selected>Pilih Plant</option>
                                    @foreach($plants as $plant)
                                    <option value="{{ $plant->uuid }}">
                                        {{ $plant->plant }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="asset_location" class="form-label">Lokasi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_location"
                                    name="asset_location"
                                    placeholder="Masukkan Lokasi">
                            </div>
                            <div class="mb-3">
                                <label for="asset_category" class="form-label">Kategori</label>
                                <select
                                    class="form-control"
                                    id="asset_category"
                                    name="asset_category"
                                    required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->uuid }}">
                                        {{ $category->category }} ({{$category->calibration}})
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="asset_merk" class="form-label">Merk</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_merk"
                                    name="asset_merk"
                                    placeholder="Masukkan Merk"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="asset_type" class="form-label">Tipe</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_type"
                                    name="asset_type"
                                    placeholder="Masukkan Tipe"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="asset_series_number" class="form-label">Nomor Seri</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_series_number"
                                    name="asset_series_number"
                                    placeholder="Masukkan Nomor Seri"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="asset_capacity" class="form-label">Kapasitas Alat</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_capacity"
                                    name="asset_capacity"
                                    placeholder="Masukkan Kapasitas Alat">
                            </div>
                            <div class="mb-3">
                                <label for="asset_range" class="form-label">Range Pemakaian</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_range"
                                    name="asset_range"
                                    placeholder="Masukkan Range Pemakaian">
                            </div>
                            <div class="mb-3">
                                <label for="asset_resolution" class="form-label">Resolusi Alat</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_resolution"
                                    name="asset_resolution"
                                    placeholder="Masukkan Tipe">
                            </div>
                            <div class="mb-3">
                                <label for="asset_correction" class="form-label">Koreksi Alat</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_correction"
                                    name="asset_correction"
                                    placeholder="Masukkan Koreksi Alat">
                            </div>
                            <div class="mb-3">
                                <label for="asset_uncertainty" class="form-label">Ketidakpastian Alat</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_uncertainty"
                                    name="asset_uncertainty"
                                    placeholder="Masukkan Ketidakpastian Alat">
                            </div>
                            <div class="mb-3">
                                <label for="asset_standard" class="form-label">Standar Keberterimaan</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="asset_standard"
                                    name="asset_standard"
                                    placeholder="Masukkan Standar Keberterimaan"
                                    step="0.001"
                                    min="0"
                                    max="99999.999">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive text-nowrap" id="asset-table">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                        <th style="color: #fff">No.</th>
                        <th style="color: #fff">Departemen</th>
                        <th style="color: #fff">Plant</th>
                        <th style="color: #fff">Lokasi</th>
                        <th style="color: #fff">Kategori</th>
                        <th style="color: #fff">Merk</th>
                        <th style="color: #fff">Tipe</th>
                        <th style="color: #fff">Nomor Seri</th>
                        <th style="color: #fff">Kapasitas</th>
                        <th style="color: #fff">Range</th>
                        <th style="color: #fff">Resolusi</th>
                        <th style="color: #fff">Koreksi</th>
                        <th style="color: #fff">Ketidakpastian</th>
                        <th style="color: #fff">Standar</th>
                        <th style="color: #fff">Status Kelayakan</th>
                        <th style="color: #fff">ED Sertifikat</th>
                        <th style="color: #fff">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                    <tr>
                        <th>{{ ($assets->currentPage() - 1) * $assets->perPage() + $loop->iteration }}</th>
                        <td>{{$asset->department->department}}</td>
                        <td>{{$asset->plant->plant}}</td>
                        <td>{{$asset->location}}</td>
                        <td>{{$asset->category->category}}</td>
                        <td>{{$asset->merk}}</td>
                        <td>{{$asset->type}}</td>
                        <td>{{$asset->series_number}}</td>
                        <td>
                            @if($asset->capacity == NULL)
                            -
                            @else
                            {{$asset->capacity}}
                            @endif
                        </td>
                        <td>{{$asset->range}}</td>
                        <td>
                            @if($asset->category->category === 'Timbangan')
                            {{ round($asset->resolution, 2) }} g
                            @elseif($asset->resolution == NULL)
                            -
                            @else
                            {{ round($asset->resolution, 2) }} °C
                            @endif
                        </td>
                        <td>@if($asset->category->category === 'Timbangan')
                            {{ round($asset->correction, 2) }} g
                            @elseif($asset->correction == NULL)
                            -
                            @else
                            {{ round($asset->correction, 2) }} °C
                            @endif
                        </td>
                        <td>@if($asset->category->category === 'Timbangan')
                            ±{{ round($asset->uncertainty, 2) }} g
                            @elseif($asset->uncertainty == NULL)
                            -
                            @else
                            ±{{ round($asset->uncertainty, 2) }} °C
                            @endif
                        </td>
                        <td>@if($asset->category->category === 'Timbangan')
                            ±{{ round($asset->standard, 2) }} g
                            @elseif($asset->standard == NULL)
                            -
                            @else
                            ±{{ round($asset->standard, 2) }} °C
                            @endif
                        </td>
                        <td>
                            @if($asset->category->calibration === 'External' && $asset->latest_external_calibration)
                            ({{$asset->latest_external_calibration->status}})

                            @elseif($asset->category->calibration === 'Internal' && $asset->category->uuid === '3cfc952c-ca24-4f7e-8532-5073b3d66d34' && $asset->latest_temp_calibration)
                            @php
                            $u95 = $asset->latest_temp_calibration->u95;
                            $standard = $asset->standard;

                            $is_ok = abs($u95) <= abs($standard);
                                @endphp

                                {{ $is_ok ? 'OK' : 'Tidak OK' }}

                                @elseif($asset->category->uuid === '575261f1-039d-4fc3-bcfa-bff34999dcdc' && $asset->latest_display_calibration)
                                @php
                                $u95 = $asset->latest_display_calibration->u95;
                                $standard = $asset->standard;
                                $is_ok = abs($u95) <= abs($standard);
                                    @endphp
                                    {{ $is_ok ? 'OK' : 'Tidak OK' }}

                                    @else
                                    N/A
                                    @endif
                                    </td>
                        <td>
                            {{ \Carbon\Carbon::parse($asset->expired_date)->format('d-m-Y') }}
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editassetModal{{$asset->id}}">
                                Edit
                            </button>

                            <!-- Edit asset Modal -->
                            <div class="modal fade" id="editassetModal{{$asset->id}}" tabindex="-1" aria-labelledby="editassetModalLabel{{$asset->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('asset.update', $asset->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editassetModalLabel{{$asset->id}}">Edit asset</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- asset Name Input -->
                                                <div class="mb-3">
                                                    <label for="edit_asset_department" class="form-label">Departemen</label>
                                                    <select
                                                        class="form-control"
                                                        id="edit_asset_department"
                                                        name="edit_asset_department"
                                                        required>
                                                        <option value="" {{ !$asset->department_uuid ? 'selected' : '' }}>
                                                            Pilih Departemen
                                                        </option>
                                                        @foreach($departments as $department)
                                                        <option value="{{ $department->uuid }}"
                                                            {{ $asset->department_uuid == $department->uuid ? 'selected' : '' }}>
                                                            {{ $department->department }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_plant" class="form-label">Plant</label>
                                                    <select
                                                        class="form-control"
                                                        id="edit_asset_plant"
                                                        name="edit_asset_plant"
                                                        required>
                                                        <option value="" {{ !$asset->plant_uuid ? 'selected' : '' }}>
                                                            Pilih Plant
                                                        </option>
                                                        @foreach($plants as $plant)
                                                        <option value="{{ $plant->uuid }}"
                                                            {{ $asset->plant_uuid == $plant->uuid ? 'selected' : '' }}>
                                                            {{ $plant->plant }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_location" class="form-label">Lokasi</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_location"
                                                        name="edit_asset_location"
                                                        placeholder="Masukkan Lokasi"
                                                        value="{{$asset->location}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_category" class="form-label">Kategori</label>
                                                    <select
                                                        class="form-control"
                                                        id="edit_asset_category"
                                                        name="edit_asset_category"
                                                        required>
                                                        <option value="" {{ !$asset->category_uuid ? 'selected' : '' }}>
                                                            Pilih Kategori
                                                        </option>
                                                        @foreach($categories as $category)
                                                        <option value="{{ $category->uuid }}"
                                                            {{ $asset->category == $category->uuid ? 'selected' : '' }}>
                                                            {{ $category->category }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_merk" class="form-label">Merk</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_merk"
                                                        name="edit_asset_merk"
                                                        placeholder="Masukkan Merk"
                                                        value="{{$asset->merk}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_type" class="form-label">Tipe</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_type"
                                                        name="edit_asset_type"
                                                        placeholder="Masukkan Tipe"
                                                        value="{{$asset->type}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_series_number" class="form-label">Nomor Seri</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_series_number"
                                                        name="edit_asset_series_number"
                                                        placeholder="Masukkan Nomor Seri"
                                                        value="{{$asset->series_number}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_capacity" class="form-label">Kapasitas Alat</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_capacity"
                                                        name="edit_asset_capacity"
                                                        placeholder="Masukkan Kapasitas Alat"
                                                        value="{{$asset->capacity}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_range" class="form-label">Range Pemakaian</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_range"
                                                        name="edit_asset_range"
                                                        placeholder="Masukkan Range Pemakaian"
                                                        value="{{$asset->range}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_resolution" class="form-label">Resolusi Alat</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_resolution"
                                                        name="edit_asset_resolution"
                                                        placeholder="Masukkan Tipe"
                                                        value="{{$asset->resolution}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_correction" class="form-label">Koreksi Alat</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_correction"
                                                        name="edit_asset_correction"
                                                        placeholder="Masukkan Koreksi Alat"
                                                        value="{{$asset->correction}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_uncertainty" class="form-label">Ketidakpastian Alat</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_uncertainty"
                                                        name="edit_asset_uncertainty"
                                                        placeholder="Masukkan Ketidakpastian Alat"
                                                        value="{{$asset->uncertainty}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_standard" class="form-label">Standar Keberterimaan</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_standard"
                                                        name="edit_asset_standard"
                                                        placeholder="Masukkan Standar Keberterimaan"
                                                        value="{{$asset->standard}}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update asset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteassetModal{{$asset->id}}">
                                Delete
                            </button>

                            <!-- Delete asset Modal -->
                            <div class="modal fade" id="deleteassetModal{{$asset->id}}" tabindex="-1" aria-labelledby="deleteassetModalLabel{{$asset->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('asset.destroy', $asset->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteassetModalLabel{{$asset->id}}">Hapus asset</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin menghapus asset ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-4">
                {{ $assets->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
</script>
@endsection