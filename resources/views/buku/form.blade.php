@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2>{{ isset($buku) ? 'Edit Buku' : 'Tambah Buku' }}</h2>

    <form action="{{ isset($buku) ? route('buku.update', $buku->id) : route('buku.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($buku))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="kode_buku" class="form-label">Kode Buku</label>
            <input type="text" name="kode_buku" class="form-control" placeholder="Masukkan Kode Buku"
                value="{{ old('kode_buku', $buku->kode_buku ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul Buku"
                value="{{ old('judul', $buku->judul ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" name="penulis" class="form-control" placeholder="Masukkan Nama Penulis"
                value="{{ old('penulis', $buku->penulis ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" class="form-control" placeholder="Masukkan Penerbit Buku"
                value="{{ old('penerbit', $buku->penerbit ?? '') }}" required>
        </div>

        <div class="mb-3">
            <div class="form-group">
                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
           <input type="date" class="form-control" name="tahun_terbit" placeholder="Masukkan Tahun Terbit"
                value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" class="form-select" required>
                <option value="" disable> Pilih Kategori </option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" 
                        {{ old('kategori_id', $buku->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" placeholder="Masukkan Stok Buku"
                value="{{ old('stok', $buku->stok ?? 0) }}" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" class="form-control">
            @if(isset($buku) && $buku->gambar)
                <img src="{{ asset('storage/'.$buku->gambar) }}" width="120" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($buku) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
