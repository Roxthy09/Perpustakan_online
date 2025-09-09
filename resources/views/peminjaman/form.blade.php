@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>{{ isset($peminjaman) ? 'Edit Peminjaman' : 'Tambah Peminjaman' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ isset($peminjaman) ? route('peminjaman.update', $peminjaman->id) : route('peminjaman.store') }}" method="POST">
        @csrf
        @if(isset($peminjaman)) @method('PUT') @endif

        <div class="mb-3">
            <label for="user_id" class="form-label">Nama Peminjam</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="">-- Pilih Peminjam --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (isset($peminjaman) && $peminjaman->user_id == $user->id) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="buku_id" class="form-label">Buku</label>
            <select name="buku_id" id="buku_id" class="form-control">
                <option value="">-- Pilih Buku --</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}" {{ (isset($peminjaman) && $peminjaman->buku_id == $buku->id) ? 'selected' : '' }}>
                        {{ $buku->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" 
                value="{{ $peminjaman->tgl_pinjam ?? old('tgl_pinjam', date('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label for="tgl_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo (otomatis 7 hari)</label>
            <input type="date" id="tgl_jatuh_tempo" class="form-control" 
                value="{{ $peminjaman->tgl_jatuh_tempo ?? old('tgl_jatuh_tempo') }}" readonly>
        </div>

        @if(isset($peminjaman))
        <div class="mb-3">
            <label for="status" class="form-label">Status (hanya admin/petugas)</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $peminjaman->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disetujui" {{ $peminjaman->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="ditolak" {{ $peminjaman->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
        </div>
        @endif

        <button type="submit" class="btn btn-success">{{ isset($peminjaman) ? 'Update' : 'Simpan' }}</button>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    document.getElementById('tgl_pinjam').addEventListener('change', function() {
        let pinjamDate = new Date(this.value);
        if (!isNaN(pinjamDate.getTime())) {
            pinjamDate.setDate(pinjamDate.getDate() + 7);
            let jatuhTempo = pinjamDate.toISOString().split('T')[0];
            document.getElementById('tgl_jatuh_tempo').value = jatuhTempo;
        }
    });

    // jalankan sekali di awal load
    document.getElementById('tgl_pinjam').dispatchEvent(new Event('change'));
</script>
@endsection
