@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h1>

    <div class="card">
        <div class="card-body">
            <form 
                action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" 
                method="POST">
                @csrf
                @if(isset($user)) @method('PUT') @endif

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" 
                        value="{{ old('name', $user->name ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                        value="{{ old('email', $user->email ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password {{ isset($user) ? '(opsional)' : '' }}</label>
                    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password {{ isset($user) ? '(opsional)' : '' }}</label>
                    <input type="password" name="password_confirmation" class="form-control" {{ isset($user) ? '' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role', $user->role ?? '') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">
                    {{ isset($user) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
