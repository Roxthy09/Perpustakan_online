@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($peminjaman) ? 'Edit Peminjaman' : 'Tambah Peminjaman' }}</h2>

    <form 
        action="{{ isset($peminjaman) ? route('peminjaman.update', $peminjaman->id) : route('peminjaman.store') }}" 
        method="POST">
        
        @csrf
        @if(isset($peminjaman))
            @method('PUT')
        @endif

        {{-- Pilih Nama Peminjam --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">Nama Peminjam</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Pilih Peminjam --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" 
                        {{ old('user_id', $peminjaman->user_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Pilih Buku --}}
        <div class="mb-3">
            <label for="id_buku" class="form-label">Buku</label>
            <select name="id_buku" id="id_buku" class="form-select" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}" 
                        {{ old('id_buku', $peminjaman->id_buku ?? '') == $buku->id ? 'selected' : '' }}>
                        {{ $buku->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" 
                value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" class="form-control" 
                value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($peminjaman) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
