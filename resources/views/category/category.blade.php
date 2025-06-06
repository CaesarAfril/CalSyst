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
            Data Alat
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addcategoryModal">
                +
            </button>
        </h5>

        <!-- Add category Modal -->
        <div class="modal fade" id="addcategoryModal" tabindex="-1" aria-labelledby="addcategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addcategoryModalLabel">Tambah Alat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- category Name Input -->
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Nama alat</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="category_name"
                                    name="category_name"
                                    placeholder="Masukkan Nama Departemen"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="calibration" class="form-label">Kalibrasi</label>
                                <select name="calibration" id="calibration" class="form-control">
                                    <option value="" hidden>--pilih--</option>
                                    <option value="Internal">Internal</option>
                                    <option value="External">Eksternal</option>
                                </select>
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
                        <th style="color: #fff">category</th>
                        <th style="color: #fff">Kalibrasi</th>
                        <th style="color: #fff">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categorys as $category)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$category->category}}</td>
                        <td>{{$category->calibration}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editcategoryModal{{$category->id}}">
                                Edit
                            </button>

                            <!-- Edit category Modal -->
                            <div class="modal fade" id="editcategoryModal{{$category->id}}" tabindex="-1" aria-labelledby="editcategoryModalLabel{{$category->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('category.update', $category->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editcategoryModalLabel{{$category->id}}">Edit category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- category Name Input -->
                                                <div class="mb-3">
                                                    <label for="edit_category_name{{$category->id}}" class="form-label">Nama category</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_category_name{{$category->id}}"
                                                        name="category_name"
                                                        value="{{ $category->category }}"
                                                        placeholder="Enter category name"
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
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletecategoryModal{{$category->id}}">
                                Delete
                            </button>

                            <!-- Delete category Modal -->
                            <div class="modal fade" id="deletecategoryModal{{$category->id}}" tabindex="-1" aria-labelledby="deletecategoryModalLabel{{$category->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deletecategoryModalLabel{{$category->id}}">Hapus category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin menghapus category ini?</p>
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