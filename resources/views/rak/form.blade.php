@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2>{{ isset($rak) ? 'Edit Rak' : 'Tambah Rak' }}</h2>

    <form 
        action="{{ isset($rak) ? route('raks.update', $rak->id) : route('raks.store') }}" 
        method="POST">
        @csrf
        @if(isset($rak))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="kode" class="form-label">Kode Rak</label>
            <input type="text" name="kode" class="form-control" 
                value="{{ old('kode', $rak->kode ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Rak</label>
            <input type="text" name="nama" class="form-control" 
                value="{{ old('nama', $rak->nama ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi Rak</label>
            <input type="text" name="lokasi" class="form-control" 
                value="{{ old('lokasi', $rak->lokasi ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($rak) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('raks.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
