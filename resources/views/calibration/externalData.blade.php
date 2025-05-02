@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Data Sertifikat Kalibrasi Eksternal

            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExternalModal">
                    +
                </button>
            </div>
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
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                        <th style="color: #fff">No.</th>
                        <th style="color: #fff">Nama Alat</th>
                        <th style="color: #fff">Merk</th>
                        <th style="color: #fff">Serial Number</th>
                        <th style="color: #fff">Departemen</th>
                        <th style="color: #fff">ED Sertifikat</th>
                        <th style="color: #fff">Progress</th>
                        <th style="color: #fff">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                    <tr>
                        <th>{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</th>
                        <td>{{ $report->asset->category->category }}</td>
                        <td>{{ $report->asset->merk }}</td>
                        <td>{{ $report->asset->series_number }}</td>
                        <td>{{ $report->asset->department->department }}</td>
                        <td>{{ \Carbon\Carbon::parse($report->asset->expired_date)->format('d-m-Y') }}</td>
                        <td>{{$report->progress_status ?? '-' }}
                        </td>
                        <td>
                            @if($report->progress_status == 'Persiapan Pengajuan')
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importpenawaranpengajuan-{{ $report->uuid }}">
                                Upload File
                            </button>
                            @endif
                            @if($report->latestCalibrationFile)
                            

                            {{-- PENAWARAN --}}
                            @if($report->latestCalibrationFile->progress == 'Penawaran')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importpenawaran-{{ $report->uuid }}">
                                Upload File
                            </button>
                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approvePenawaran-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModal">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>

                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif

                            {{-- PPBJ --}}
                            @elseif($report->latestCalibrationFile->progress == 'PPBJ')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importPpbj-{{ $report->uuid }}">
                                Upload File
                            </button>
                            {{-- modal upload ppbj --}}
                            <div class="modal fade" id="importPpbj-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabelPpbj" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('ppbjFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
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

                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approvePpbj-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModalPpbj">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>

                            {{-- ppbj --}}
                                {{-- approve --}}
                                <div class="modal fade" id="approvePpbj-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk approve step ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('external.addApprovePpbj', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>  
                                </div>

                                {{-- notes --}}
                                <div class="modal fade" id="addNotesModalPpbj" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('external.save-notes-ppbj', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="notes">Catatan:</label>
                                                            <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            

                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif

                            {{-- NEGOSIASI --}}
                            @elseif($report->latestCalibrationFile->progress == 'Negosiasi')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importNegosiasi-{{ $report->uuid }}">
                                Upload File
                            </button>
                            {{-- modal upload negosiasi --}}
                            <div class="modal fade" id="importNegosiasi-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabelNegosiasi" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('negosiasiFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
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
                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveNegosiasi-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModalNegosiasi">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>
                            {{-- negosiasi --}}
                            
                                {{-- approve --}}
                                <div class="modal fade" id="approveNegosiasi-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk approve step ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('external.addApproveNegosiasi', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                              
                                </div>

                                {{-- notes --}}
                                <div class="modal fade" id="addNotesModalNegosiasi" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('external.save-notes-negosiasi', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="notes">Catatan:</label>
                                                            <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif

                            {{-- SPK --}}
                            @elseif($report->latestCalibrationFile->progress == 'SPK')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importSpk-{{ $report->uuid }}">
                                Upload File
                            </button>
                            {{-- modal upload spk --}}
                            <div class="modal fade" id="importSpk-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabelSpk" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('spkFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
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
                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveSpk-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModalSpk">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>
                            {{-- spk --}}
                            
                                {{-- approve --}}
                                <div class="modal fade" id="approveSpk-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk approve step ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('external.addApproveSpk', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                              
                                </div>

                                {{-- notes --}}
                                <div class="modal fade" id="addNotesModalSpk" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('external.save-notes-spk', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="notes">Catatan:</label>
                                                            <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif

                            {{-- PELAKSANAAN --}}
                            @elseif($report->latestCalibrationFile->progress == 'Pelaksanaan')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importPelaksanaan-{{ $report->uuid }}">
                                Upload File
                            </button>
                            {{-- modal upload pelaksanaan --}}
                            <div class="modal fade" id="importPelaksanaan-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabelPelaksanaan" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('pelaksanaanFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
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
                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approvePelaksanaan-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModalPelaksanaan">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>

                            {{-- pelaksanaan --}}
                            
                                {{-- approve --}}
                                <div class="modal fade" id="approvePelaksanaan-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk approve step ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('external.addApprovePelaksanaan', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                              
                                </div>

                                {{-- notes --}}
                                <div class="modal fade" id="addNotesModalSpk" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('external.save-notes-pelaksanaan', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="notes">Catatan:</label>
                                                            <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif

                            {{-- BA --}}
                            @elseif($report->latestCalibrationFile->progress == 'BA')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importBa-{{ $report->uuid }}">
                                Upload File
                            </button>
                            {{-- modal upload BA --}}
                            <div class="modal fade" id="importBa-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabelBa" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('baFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
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
                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveBa-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModalBa">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>
                            {{-- BA --}}
                            
                                {{-- approve --}}
                                <div class="modal fade" id="approveBa-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk approve step ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('external.addApproveBa', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                              
                                </div>

                                {{-- notes --}}
                                <div class="modal fade" id="addNotesModalBa" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('external.save-notes-ba', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="notes">Catatan:</label>
                                                            <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif

                            {{-- PEMBAYARAN --}}
                            @elseif($report->latestCalibrationFile->progress == 'Pembayaran')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importPembayaran-{{ $report->uuid }}">
                                Upload File
                            </button>
                            {{-- modal upload pembayaran --}}
                            <div class="modal fade" id="importPembayaran-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabelPembayaran" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('pembayaranFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
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
                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approvePembayaran-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModalPembayaran">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>
                            {{-- PEMBAYARAN --}}
                            
                                {{-- approve --}}
                                <div class="modal fade" id="approvePembayaran-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk approve step ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('external.addApprovePembayaran', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                              
                                </div>

                                {{-- notes --}}
                                <div class="modal fade" id="addNotesModalPembayaran" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('external.save-notes-pembayaran', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="notes">Catatan:</label>
                                                            <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                            
                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif

                            {{-- SERTIFIKAT --}}
                            @elseif($report->latestCalibrationFile->progress == 'Sertifikat')
                            @if($report->latestCalibrationFile->filename == NULL)
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importSertifikat-{{ $report->uuid }}">
                                Upload File
                            </button>
                            {{-- modal upload pembayaran --}}
                            <div class="modal fade" id="importSertifikat-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabelSertifikat" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('sertifikatFileStore', $report->uuid) }}" method="post" enctype="multipart/form-data">
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
                            @elseif($report->latestCalibrationFile->filename != NULL && $report->latestCalibrationFile->approval == NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveSertifikat-{{ $report->latestCalibrationFile->uuid }}">
                                Approve
                            </button>

                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addNotesModalSertifikat">
                                <i class="fas fa-exclamation-circle"></i> Add Notes
                            </button>
                            {{-- SERTIFIKAT --}}     
                                {{-- approve --}}
                                <div class="modal fade" id="approveSertifikat-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk approve step ini ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('external.addApproveSertifikat', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Confirm Approve</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- notes --}}
                                <div class="modal fade" id="addNotesModalSertifikat" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('external.save-notes-sertifikat', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <label for="notes">Catatan:</label>
                                                            <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <button type="submit" class="btn btn-warning">Simpan</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            
                            @elseif($report->latestCalibrationFile->filename != NULL)
                            <a href="{{ asset('storage/' . $report->latestCalibrationFile->path) }}" target="_blank" class="btn btn-primary btn-sm">
                                {{ $report->latestCalibrationFile->filename }}
                            </a>
                            @endif
                            @endif
                            @endif
                        </td>

                        {{-- modal upload persiapan pengajuan --}}
                        <div class="modal fade" id="importpenawaranpengajuan-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
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

                        {{-- penawaran --}}
                            {{-- approve --}}
                            @if($report->latestCalibrationFile)
                            <div class="modal fade" id="approvePenawaran-{{ $report->latestCalibrationFile->uuid }}" tabindex="-1" role="dialog" aria-labelledby="closeProgressModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="closeProgressModalLabel">Confirm Close</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah anda yakin untuk approve step ini ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <form action="{{ route('external.addApprove', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Confirm Approve</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                          
                            </div>
                            <div class="modal fade" id="addNotesModal" tabindex="-1" role="dialog" aria-labelledby="addNotesModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addNotesModalLabel">Catatan</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('external.save-notes', $report->latestCalibrationFile->uuid) }}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="form-group">
                                                        <label for="notes">Catatan:</label>
                                                        <textarea name="notes" id="notes" class="form-control" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <button type="submit" class="btn btn-warning">Simpan</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                        
                        {{-- modal upload penawaran --}}
                        <div class="modal fade" id="importpenawaran-{{ $report->uuid }}" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
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
                        @endif
        </div>
        </tr>
        @endforeach
        </tbody>
        </table>
        <div class="d-flex justify-content-end mt-4">
            {{ $reports->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    // Optional: You can implement JavaScript to handle dynamic form population, if necessary.
</script>
@endsection