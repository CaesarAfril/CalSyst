@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Data Anak Timbang
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addweightModal">
                +
            </button>
        </h5>

        <!-- Add weight Modal -->
        <div class="modal fade" id="addweightModal" tabindex="-1" aria-labelledby="addweightModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('weight.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addweightModalLabel">Tambah Anak Timbang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- weight Name Input -->
                            <div class="mb-3">
                                <label for="mass" class="form-label">Massa</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="mass"
                                    name="mass"
                                    placeholder="Masukkan Massa"
                                    step="0.001"
                                    min="0"
                                    max="99999.999">
                            </div>
                            <div class="mb-3">
                                <label for="error" class="form-label">Error</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="error"
                                    name="error"
                                    placeholder="Masukkan error"
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

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="table-responsive text-nowrap">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="text-nowrap" style="background-color: rgb(66, 73, 92);">
                        <th style="color: #fff">No.</th>
                        <th style="color: #fff">Massa</th>
                        <th style="color: #fff">Error</th>
                        <th style="color: #fff">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weights as $weight)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$weight->mass}}</td>
                        <td>{{$weight->error}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editweightModal{{$weight->id}}">
                                Edit
                            </button>

                            <!-- Edit weight Modal -->
                            <div class="modal fade" id="editweightModal{{$weight->id}}" tabindex="-1" aria-labelledby="editweightModalLabel{{$weight->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('weight.update', $weight->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editweightModalLabel{{$weight->id}}">Edit weight</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- weight Name Input -->
                                                <div class="mb-3">
                                                    <label for="edit_mass" class="form-label">Massa</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="edit_mass"
                                                        name="edit_mass"
                                                        value="{{ $weight->mass }}"
                                                        placeholder="Masukkan Massa"
                                                        step="0.001"
                                                        min="0"
                                                        max="99999.999">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_error" class="form-label">Error</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        id="edit_error"
                                                        name="edit_error"
                                                        value="{{ $weight->error }}"
                                                        placeholder="Masukkan error"
                                                        step="0.001"
                                                        min="0"
                                                        max="99999.999">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update weight</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteweightModal{{$weight->id}}">
                                Delete
                            </button>

                            <!-- Delete weight Modal -->
                            <div class="modal fade" id="deleteweightModal{{$weight->id}}" tabindex="-1" aria-labelledby="deleteweightModalLabel{{$weight->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('weight.destroy', $weight->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteweightModalLabel{{$weight->id}}">Hapus weight</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin menghapus anak timbang ini?</p>
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