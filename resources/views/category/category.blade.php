@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y px-0">
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
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

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>No.</th>
                        <th>category</th>
                        <th>Kalibrasi</th>
                        <th>Action</th>
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