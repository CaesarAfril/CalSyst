@extends('templates.templates')
@section('style')
<style>
    .fade {
        width: 100% !important;
        height: 100% !important;
    }
</style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Data department
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adddepartmentModal">
                +
            </button>
        </h5>

        <!-- Add department Modal -->
        <div class="modal fade" id="adddepartmentModal" tabindex="-1" aria-labelledby="adddepartmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('department.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="adddepartmentModalLabel">Tambah department</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- department Name Input -->
                            <div class="mb-3">
                                <label for="department_name" class="form-label">Nama department</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="department_name"
                                    name="department_name"
                                    placeholder="Masukkan Nama Departemen"
                                    required>
                            </div>

                            <!-- department Dropdown -->
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
                        <th style="color: #fff">department</th>
                        <th style="color: #fff">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$department->department}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editdepartmentModal{{$department->id}}">
                                Edit
                            </button>

                            <!-- Edit department Modal -->
                            <div class="modal fade" id="editdepartmentModal{{$department->id}}" tabindex="-1" aria-labelledby="editdepartmentModalLabel{{$department->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('department.update', $department->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editdepartmentModalLabel{{$department->id}}">Edit department</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- department Name Input -->
                                                <div class="mb-3">
                                                    <label for="edit_department_name{{$department->id}}" class="form-label">Nama department</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_department_name{{$department->id}}"
                                                        name="department_name"
                                                        value="{{ $department->department }}"
                                                        placeholder="Enter department name"
                                                        required>
                                                </div>

                                                <!-- department Dropdown -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update department</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletedepartmentModal{{$department->id}}">
                                Delete
                            </button>

                            <!-- Delete department Modal -->
                            <div class="modal fade" id="deletedepartmentModal{{$department->id}}" tabindex="-1" aria-labelledby="deletedepartmentModalLabel{{$department->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('department.destroy', $department->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deletedepartmentModalLabel{{$department->id}}">Hapus department</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin menghapus department ini?</p>
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