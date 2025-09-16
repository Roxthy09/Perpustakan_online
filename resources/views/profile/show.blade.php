@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Profil Saya</h1>

    <div class="card shadow-sm p-4">
        <div class="text-center mb-4">
            <img src="{{ asset('admin/assets/images/profile/user-1.jpg') }}" 
                 class="rounded-circle" width="120" height="120" alt="profile">
            <h4 class="mt-3">{{ $user->name }}</h4>
            <span class="badge bg-primary">{{ ucfirst($user->role) }}</span>
        </div>

        <hr>

        <div class="mb-3">
            <strong>Nama Lengkap:</strong>
            <p class="mb-0">{{ $user->name }}</p>
        </div>

        <div class="mb-3">
            <strong>Email:</strong>
            <p class="mb-0">{{ $user->email }}</p>
        </div>

        <div class="mb-3">
            <strong>Role:</strong>
            <p class="mb-0">{{ ucfirst($user->role) }}</p>
        </div>

        <div class="mb-3">
            <strong>Bergabung Sejak:</strong>
            <p class="mb-0">{{ $user->created_at->format('d M Y') }}</p>
        </div>

        {{-- Tombol kembali --}}
        <div class="mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
