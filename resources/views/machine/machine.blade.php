@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            Data Mesing
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcategoryModal">
                +
            </button>
        </h5>

        <!-- Add category Modal -->
        <div class="modal fade" id="addcategoryModal" tabindex="-1" aria-labelledby="addcategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('machine.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addcategoryModalLabel">Tambah Mesin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- category Name Input -->
                            <div class="mb-3">
                                <label for="machine_name" class="form-label">Nama Mesin</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="machine_name"
                                    name="machine_name"
                                    placeholder="Masukkan Nama Mesin"
                                    required>
                            </div>

                            <!-- category Dropdown -->
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
                        <th>Nama Mesin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($machines as $machine)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$machine->machine_name}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editcategoryModal{{$machine->id}}">
                                Edit
                            </button>

                            <!-- Edit category Modal -->
                            <div class="modal fade" id="editcategoryModal{{$machine->id}}" tabindex="-1" aria-labelledby="editcategoryModalLabel{{$machine->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('machine.update', $machine->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editcategoryModalLabel{{$machine->id}}">Edit Mesin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- category Name Input -->
                                                <div class="mb-3">
                                                    <label for="edit_category_name{{$machine->id}}" class="form-label">Nama Mesin</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_machine_name{{$machine->id}}"
                                                        name="edit_machine_name"
                                                        value="{{ $machine->machine_name }}"
                                                        placeholder="Masukkan Nama Mesin"
                                                        required>
                                                </div>

                                                <!-- category Dropdown -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update category</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletecategoryModal{{$machine->id}}">
                                Delete
                            </button>

                            <!-- Delete category Modal -->
                            <div class="modal fade" id="deletecategoryModal{{$machine->id}}" tabindex="-1" aria-labelledby="deletecategoryModalLabel{{$machine->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('machine.destroy', $machine->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deletecategoryModalLabel{{$machine->id}}">Hapus Mesin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin menghapus data mesin ini?</p>
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