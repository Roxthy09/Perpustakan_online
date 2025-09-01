@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($buku) ? 'Edit Buku' : 'Tambah Buku' }}</h2>

    <form 
        action="{{ isset($buku) ? route('buku.update', $buku->id) : route('buku.store') }}" 
        method="POST" 
        enctype="multipart/form-data">

        @csrf
        @if(isset($buku))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="kode_buku" class="form-label">Kode Buku</label>
            <input type="text" name="kode_buku" class="form-control" 
                value="{{ old('kode_buku', $buku->kode_buku ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" 
                value="{{ old('judul', $buku->judul ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" name="penulis" class="form-control" 
                value="{{ old('penulis', $buku->penulis ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" class="form-control" 
                value="{{ old('penerbit', $buku->penerbit ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" 
                value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" required>
        </div>

        <div class="mb-3">
    <label for="kategori_id" class="form-label">Kategori</label>
    <select name="kategori_id" class="form-control">
        <option value="">-- Pilih Kategori --</option>
        @foreach(\App\Models\KategoriBuku::all() as $kategori)
            <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
    </select>
</div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" 
                value="{{ old('stok', $buku->stok ?? 0) }}" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control">
            @if(isset($buku) && $buku->gambar)
                <img src="{{ asset('storage/'.$buku->gambar) }}" alt="cover" width="120" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($buku) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
