@extends('templates.templates')

@section('content')
<h4 class="fw-bold py-1 mb-1"><span class="text-muted fw-light">Master Data /</span> User</h4>
<hr class="my-4" />
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            Edit User
        </div>
        <div class="card-body">
            <form action="{{ route('user.update', $user->uuid) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="user_username" class="form-label">Username</label>
                    <input type="text"
                        class="form-control @error('user_username') is-invalid @enderror"
                        id="user_username"
                        name="user_username"
                        value="{{ old('user_username', $user->username) }}"
                        required>
                    @error('user_username')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user_name" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ old('user_name', $user->name) }}" required>
                    @error('user_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="user_email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('user_email') is-invalid @enderror" id="user_email" name="user_email" value="{{ old('user_email', $user->email) }}" required>
                    @error('user_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="user_plant" class="form-label">Pilih area</label>
                    <select name="user_plant" id="user_plant" class="form-select @error('user_plant') is-invalid @enderror" required>
                        <option value="">-- Pilih plant --</option>
                        @foreach($plants as $plant)
                        <option value="{{ $plant->uuid }}" {{ old('user_plant', $user->plant_uuid) == $plant->uuid ? 'selected' : '' }}>{{ $plant->plant }}</option>
                        @endforeach
                    </select>
                    @error('user_plant')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="user_department" class="form-label">Pilih Departemen</label>
                    <select name="user_department" id="user_department" class="form-select" required>
                        <option value="">-- Pilih Departemen --</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->uuid }}" {{old('user_department', $user->dept_uuid )}}>{{ $department->department }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Role Field -->
                <div class="mb-3">
                    <label for="user_role" class="form-label">Pilih Role</label>
                    <select name="user_role" id="user_role" class="form-select @error('user_role') is-invalid @enderror" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ (old('user_role') ?? $user->roles->first()->name ?? '') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_role')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection