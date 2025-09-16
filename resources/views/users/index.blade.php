@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Daftar User</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="ti ti-plus"></i> Tambah User
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @php
                                    $role = strtolower($user->role);
                                    $badgeRole = match($role) {
                                        'admin' => 'danger',
                                        'petugas' => 'primary',
                                        'user' => 'success',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeRole }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                </div>
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $users->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
