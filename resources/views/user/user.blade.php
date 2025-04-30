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
            Data User
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                +
            </button>
        </h5>
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Tambah User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Department Name Input -->
                            <div class="mb-3">
                                <label for="user_username" class="form-label">Username</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="user_username"
                                    name="user_username"
                                    placeholder="Masukkan Username"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="user_name" class="form-label">Nama</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="user_name"
                                    name="user_name"
                                    placeholder="Masukkan Nama"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="user_email" class="form-label">Email</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="user_email"
                                    name="user_email"
                                    placeholder="Masukkan Email"
                                    required>
                            </div>

                            <!-- Plant Dropdown -->
                            <div class="mb-3">
                                <label for="user_department" class="form-label">Pilih Departemen</label>
                                <select name="user_department" id="user_department" class="form-select" required>
                                    <option value="">-- Pilih Departemen --</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->uuid }}">{{ $department->department }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="user_plant" class="form-label">Pilih Plant</label>
                                <select name="user_plant" id="user_plant" class="form-select" required>
                                    <option value="">-- Pilih Plant --</option>
                                    @foreach($plants as $plant)
                                    <option value="{{ $plant->uuid }}">{{$plant->plant}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="user_role" class="form-label">Pilih Role</label>
                                <select name="user_role" id="user_role" class="form-select" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->uuid }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
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
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr class="text-nowrap text-center align-middle" style="background-color: rgb(66, 73, 92);">
                        <th rowspan="2" style="color: #fff">No.</th>
                        <th rowspan="2" style="color: #fff">Username</th>
                        <th rowspan="2" style="color: #fff">Nama</th>
                        <th rowspan="2" style="color: #fff">Email</th>
                        <th style="color: #fff">Departemen</th>
                        <th rowspan="2" style="color: #fff">Plant</th>
                        <th rowspan="2" style="color: #fff">Action</th>
                    </tr>
                    <tr class="text-center align-middle" style="background-color: rgb(66, 73, 92);">
                        <th class="align-middle">
                            <select id="filterDepartment" class="form-select form-select-sm">
                                <option value="">All</option>
                                @foreach($departments as $department)
                                <option value="{{ $department->department }}">{{ $department->department }}</option>
                                @endforeach
                            </select>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <th>{{$loop->iteration}}</th>
                        <td>{{$user->username}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->department->department}}</td>
                        <td>{{$user->plant->plant}}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <form action="{{route('user.delete', $user->uuid)}}" method="post" onsubmit="return confirm('Apakah anda yakin akan menghapus data pegawai ini ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
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
    document.addEventListener("DOMContentLoaded", function() {
        const filterDepartment = document.getElementById("filterDepartment");
        const filterPlant = document.getElementById("filterPlant");
        const tableRows = document.querySelectorAll("tbody tr");

        function filterTable() {
            const departmentValue = filterDepartment.value.toLowerCase();
            const plantValue = filterPlant.value.toLowerCase();

            tableRows.forEach(row => {
                const departmentText = row.children[4].textContent.toLowerCase();
                const plantText = row.children[5].textContent.toLowerCase();

                const departmentMatch = !departmentValue || departmentText === departmentValue;
                const plantMatch = !plantValue || plantText === plantValue;

                row.style.display = departmentMatch && plantMatch ? "" : "none";
            });
        }

        filterDepartment.addEventListener("change", filterTable);
        filterPlant.addEventListener("change", filterTable);
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".edit-user").forEach(button => {
            button.addEventListener("click", function() {
                document.getElementById("edit_id").value = this.dataset.id;
                document.getElementById("edit_name").value = this.dataset.name;
                document.getElementById("edit_NIK").value = this.dataset.nik;
                document.getElementById("edit_level").value = this.dataset.level;
                document.getElementById("edit_department").value = this.dataset.department;
                document.getElementById("editUserForm").action = "/pegawai/" + this.dataset.id;
            });
        });
    });
</script>
@endsection