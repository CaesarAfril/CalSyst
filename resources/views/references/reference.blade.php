@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Data Referensi
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addReferenceModal">
                +
            </button>
        </h5>

        <!-- Add Plant Modal -->
        <div class="modal fade" id="addReferenceModal" tabindex="-1" aria-labelledby="addReferenceModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('references.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addReferenceModalLabel">Tambah Referensi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Plant Name Input -->
                            <div class="mb-3">
                                <label for="document_name" class="form-label">Nama Dokumen</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="document_name"
                                    name="document_name"
                                    placeholder="Masukkan Nama Dokumen"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="document_file" class="form-label">Upload File</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="document_file"
                                    name="document_file"
                                    accept=".pdf,.doc,.docx"
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
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No.</th>
                        <th>Nama Dokumen</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $document)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$document->document_name}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editReferenceModal{{$document->id}}">
                                Edit
                            </button>

                            <!-- Edit Plant Modal -->
                            <div class="modal fade" id="editReferenceModal{{$document->id}}" tabindex="-1" aria-labelledby="editReferenceModalLabel{{$document->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('references.update', $document->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editReferemceModalLabel{{$document->id}}">Edit Referensi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Plant Name Input -->
                                                <div class="mb-3">
                                                    <label for="edit_document_name" class="form-label">Nama Dokumen</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_document_name"
                                                        name="edit_document_name"
                                                        placeholder="Masukkan Nama Dokumen"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="edit_document_file" class="form-label">Upload File</label>
                                                    <input
                                                        type="file"
                                                        class="form-control"
                                                        id="edit_document_file"
                                                        name="edit_document_file"
                                                        accept=".pdf,.doc,.docx"
                                                        required>
                                                </div>

                                                <!-- Plant Dropdown -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteReferenceModal{{$document->id}}">
                                Delete
                            </button>

                            <!-- Delete plant Modal -->
                            <div class="modal fade" id="deleteReferenceModal{{$document->id}}" tabindex="-1" aria-labelledby="deleteReferenceModalLabel{{$document->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('references.destroy', $document->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteReferenceModalLabel{{$document->id}}">Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin menghapus referensi ini?</p>
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