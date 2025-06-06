@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            <span>Data Aset Mesin Pemasakan</span>
            <div class="d-flex gap-2">
                <a href="{{route('validationAsset.exportExcel')}}" class="btn btn-danger">Export Excel</a>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                    Import CSV
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addassetModal">
                    +
                </button>

                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#sendWarningModal">
                    Early Warning 1
                </button>

                <!-- Modal ew 1 -->
                <div class="modal fade" id="sendWarningModal" tabindex="-1" aria-labelledby="sendWarningModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('validation_asset.sendWarning') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sendWarningModalLabel">Send Early Warning</h5>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="machine_name" class="form-label">Select Machine</label>
                                        <select name="machine_name" class="form-select" required>
                                            <option value="" disabled selected>-- Choose Machine --</option>
                                            @foreach($machines as $machine)
                                            <option value="{{ $machine->machine_name }}">{{ $machine->machine_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Send Email</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Trigger Button -->
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#earlyWarning2Modal">
                    Early Warning 2
                </button>

                <!-- Modal ew 2 -->
                <div class="modal fade" id="earlyWarning2Modal" tabindex="-1" aria-labelledby="earlyWarning2ModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('validation_asset.sendEarlyWarning2') }}" method="POST">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="earlyWarning2ModalLabel">Send Early Warning 2</h5>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="test_alat" class="form-label">Test Alat</label>
                                        <input type="text" class="form-control" name="test_alat" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="test_mesin" class="form-label">Test Mesin</label>
                                        <input type="text" class="form-control" name="test_mesin" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Send Email</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </h5>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('validation_asset.importCsv') }}" method="post" enctype="multipart/form-data">
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
                <form action="{{ route('validation_asset.store') }}" method="POST">
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
                                    placeholder="Masukkan Lokasi"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="asset_machine_name" class="form-label">Nama Mesin</label>
                                <select name="asset_machine_name" id="asset_machine_name" class="form-control">
                                    <option value="
                                        " hidden>-- Pilih --</option>
                                    @foreach ($machines as $machine)
                                    <option value="{{ $machine->uuid }}">{{ $machine->machine_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="asset_detail" class="form-label">Detail</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="asset_detail"
                                    name="asset_detail"
                                    placeholder="Masukkan Detail"
                                    required>
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

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                        <th style="color: #fff">No.</th>
                        <th style="color: #fff">Departemen</th>
                        <th style="color: #fff">Plant</th>
                        <th style="color: #fff">Lokasi</th>
                        <th style="color: #fff">Nama Mesin</th>
                        <th style="color: #fff">Detail</th>
                        <th style="color: #fff">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assets as $asset)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$asset->department->department}}</td>
                        <td>{{$asset->plant->plant}}</td>
                        <td>{{$asset->location}}</td>
                        <td>{{$asset->machine->machine_name}}</td>
                        <td>{{$asset->detail}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editassetModal{{$asset->id}}">
                                Edit
                            </button>

                            <!-- Edit asset Modal -->
                            <div class="modal fade" id="editassetModal{{$asset->id}}" tabindex="-1" aria-labelledby="editassetModalLabel{{$asset->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('validation_asset.update', $asset->id) }}" method="POST">
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
                                                    <label for="edit_asset_machine_name" class="form-label">Nama Mesin</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_machine_name"
                                                        name="edit_asset_machine_name"
                                                        placeholder="Masukkan Nama Mesin"
                                                        value="{{$asset->machine_name}}"
                                                        required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_asset_detail" class="form-label">Detail</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_asset_detail"
                                                        name="edit_asset_detail"
                                                        placeholder="Masukkan Detail"
                                                        value="{{$asset->detail}}"
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
                                    <form action="{{ route('validation_asset.destroy', $asset->id) }}" method="POST">
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
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // Optional: You can implement JavaScript to handle dynamic form population, if necessary.
</script>
@endsection