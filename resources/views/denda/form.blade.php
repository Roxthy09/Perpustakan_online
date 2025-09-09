@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>{{ isset($denda) ? 'Edit Denda' : 'Tambah Denda' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($denda) ? route('denda.update', $denda->id) : route('denda.store') }}" method="POST">
        @csrf
        @if(isset($denda)) @method('PUT') @endif

        <div class="mb-3">
            <label for="id_pengembalian" class="form-label">Pengembalian</label>
            <select name="id_pengembalian" id="id_pengembalian" class="form-control">
                <option value="">-- Pilih Pengembalian --</option>
                @foreach($pengembalians as $pengembalian)
                    <option value="{{ $pengembalian->id }}" {{ (isset($denda) && $denda->id_pengembalian == $pengembalian->id) ? 'selected' : '' }}>
                        {{ $pengembalian->id }} - {{ $pengembalian->peminjaman->buku->judul ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah Denda</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $denda->jumlah ?? old('jumlah') }}" min="0">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="belum_dibayar" {{ (isset($denda) && $denda->status=='belum_dibayar') ? 'selected' : '' }}>Belum Dibayar</option>
                <option value="selesai" {{ (isset($denda) && $denda->status=='selesai') ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($denda) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('denda.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
