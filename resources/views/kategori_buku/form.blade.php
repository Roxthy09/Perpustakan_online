@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2>{{ $kategori_buku->id ? 'Edit Kategori Buku' : 'Tambah Kategori Buku' }}</h2>

    <form action="{{ $kategori_buku->id ? route('kategori_buku.update', $kategori_buku->id) : route('kategori_buku.store') }}" method="POST">
        @csrf
        @if($kategori_buku->id)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" value="{{ old('kode', $kategori_buku->kode) }}" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $kategori_buku->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $kategori_buku->deskripsi) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('kategori_buku.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
