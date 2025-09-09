@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>{{ isset($pengembalian) ? 'Edit Pengembalian' : 'Tambah Pengembalian' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($pengembalian) ? route('pengembalian.update', $pengembalian->id) : route('pengembalian.store') }}" method="POST">
        @csrf
        @if(isset($pengembalian)) @method('PUT') @endif

        <div class="mb-3">
            <label for="id_peminjaman" class="form-label">Peminjaman</label>
            <select name="id_peminjaman" id="id_peminjaman" class="form-control">
                <option value="">-- Pilih Peminjaman --</option>
                @foreach($peminjamans as $peminjaman)
                    <option value="{{ $peminjaman->id }}" 
                        {{ (isset($pengembalian) && $pengembalian->id_peminjaman == $peminjaman->id) ? 'selected' : '' }}>
                        {{ $peminjaman->user->name }} - {{ $peminjaman->buku->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
            <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" class="form-control" 
                value="{{ $pengembalian->tanggal_pengembalian ?? old('tanggal_pengembalian') }}">
        </div>

        @if(isset($pengembalian))
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="Tepat Waktu" {{ $pengembalian->status == 'Tepat Waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                <option value="Terlambat" {{ $pengembalian->status == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                <option value="Hilang" {{ $pengembalian->status == 'Hilang' ? 'selected' : '' }}>Hilang</option>
            </select>
        </div>
        @endif

        <button type="submit" class="btn btn-success">{{ isset($pengembalian) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
