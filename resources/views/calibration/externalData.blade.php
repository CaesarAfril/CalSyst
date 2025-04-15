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
                        <th>Status</th>
                        <th>Aksi</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$report->date}}</td>
                        <td>{{$report->progress_status  }}
                        </td>
                        {{-- <td><button type="button" class="btn btn-success btn-sm" onclick="{{ route('penawaranFileStore', $report->uuid) }}">
                            Masukkan
                        </button></td> --}}
                        <td>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importCsvModal">
                                Masukkan
                            </button>
                        </td>

                        <div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('penawaranFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importCsvModalLabel">Upload File</h5>
                                            <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="label" class="form-label">Tanggal</label>
                                            <input type="date" name="date_file" id="date_file" class="form-control mb-3" required>
                                            <label for="label" class="form-label">Upload FIle</label>
                                            <input type="file" name="file" id="file" class="form-control mb-3" required>
                                            
                                            <button class="btn btn-success" type="submit">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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