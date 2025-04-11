@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Data Sertifikat Kalibrasi Eksternal
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addExternalModal">
                +
            </button>
        </h5>

        <!-- Add External Modal -->
        <div class="modal fade" id="addExternalModal" tabindex="-1" aria-labelledby="addExternalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('External_calibration.storeExternalCalibration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addExternalModalLabel">Tambah Sertifikat Kalibrasi Eksternal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- External Name Input -->
                            <div class="mb-3">
                                <label for="date" class="form-label">Tanggal</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="date"
                                    name="date"
                                    placeholder="Masukkan Tanggal"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="asset" class="form-label">Aset</label>
                                <select name="asset" id="asset" class="form-control">
                                    <option value="" hidden>--Pilih--</option>
                                    @foreach($assets as $asset)
                                    <option value="{{$asset->uuid}}">{{$asset->merk}} {{$asset->type}} {{$asset->series_number}} ({{$asset->department->department}})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="file"
                                    name="file"
                                    accept=".pdf,.doc,.docx"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="" hidden>--Pilih--</option>
                                    <option value="Ok">Ok</option>
                                    <option value="Tidak Ok">Tidak OK</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="next_date" class="form-label">Kalibrasi Selanjutnya</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="next_date"
                                    name="next_date"
                                    placeholder="Masukkan Tanggal"
                                    required>
                            </div>
                            <!-- External Dropdown -->
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
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Alat</th>
                        <th>Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$report->date}}</td>
                        <td>{{$report->asset->merk}} {{$report->asset->type}} {{$report->asset->series_number}}</td>
                        <td>{{$report->asset->department->department}}</td>
                        <td>
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