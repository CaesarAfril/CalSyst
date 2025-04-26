@extends('templates.templates')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y p-0" style="border-radius: 16px;">
    <div class="card px-5 py-5" style="border-radius: 1rem;">
        <h5 class="card-header d-flex justify-content-between align-items-center p-0 mb-4">
            Data Plant
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlantModal">
                +
            </button>
        </h5>

        <!-- Add Plant Modal -->
        <div class="modal fade" id="addPlantModal" tabindex="-1" aria-labelledby="addPlantModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('plant.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPlantModalLabel">Tambah Plant</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Plant Name Input -->
                            <div class="mb-3">
                                <label for="Plant_name" class="form-label">Nama Plant</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="plant_name"
                                    name="plant_name"
                                    placeholder="Masukkan Nama Plant"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="plant_abbreviaton" class="form-label">Singkatan</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="plant_abbreviaton"
                                    name="plant_abbreviaton"
                                    placeholder="Masukkan Singkatan"
                                    required>
                            </div>

                            <!-- Plant Dropdown -->
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
                        <th style="color: #fff">Plant</th>
                        <th style="color: #fff">Singkatan</th>
                        <th style="color: #fff">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plants as $plant)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$plant->plant}}</td>
                        <td>{{$plant->abbreviaton}}</td>
                        <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editPlantModal{{$plant->id}}">
                                Edit
                            </button>

                            <!-- Edit Plant Modal -->
                            <div class="modal fade" id="editPlantModal{{$plant->id}}" tabindex="-1" aria-labelledby="editPlantModalLabel{{$plant->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('plant.update', $plant->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPlantModalLabel{{$plant->id}}">Edit Plant</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Plant Name Input -->
                                                <div class="mb-3">
                                                    <label for="edit_plant_name{{$plant->id}}" class="form-label">Nama Plant</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_plant_name{{$plant->id}}"
                                                        name="plant_name"
                                                        value="{{ $plant->plant }}"
                                                        placeholder="Enter plant name"
                                                        required>
                                                </div>

                                                <!-- Plant Abbreviation Input -->
                                                <div class="mb-3">
                                                    <label for="edit_plant_abbreviation{{$plant->id}}" class="form-label">Singkatan</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="edit_plant_abbreviation{{$plant->id}}"
                                                        name="plant_abbreviaton"
                                                        value="{{ $plant->abbreviaton }}"
                                                        required>
                                                </div>

                                                <!-- Plant Dropdown -->
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Plant</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Delete Button -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deletePlantModal{{$plant->id}}">
                                Delete
                            </button>

                            <!-- Delete plant Modal -->
                            <div class="modal fade" id="deletePlantModal{{$plant->id}}" tabindex="-1" aria-labelledby="deletePlantModalLabel{{$plant->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('plant.destroy', $plant->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deletePlantModalLabel{{$plant->id}}">Hapus Plant</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Anda yakin menghapus plant ini?</p>
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