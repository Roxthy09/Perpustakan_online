@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>{{ isset($peminjaman) ? 'Edit Peminjaman' : 'Tambah Peminjaman' }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- Form hanya untuk user --}}
    <form action="{{ isset($peminjaman) 
            ? route('user.peminjaman.update', $peminjaman->id) 
            : route('user.peminjaman.store') }}" method="POST">
        @csrf
        @if(isset($peminjaman)) @method('PUT') @endif

        {{-- Nama Peminjam otomatis --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">Nama Peminjam</label>
            <input type="hidden" name="user_id" 
                   value="{{ isset($peminjaman) ? $peminjaman->user_id : auth()->user()->id }}">
            <input type="text" class="form-control" 
                   value="{{ isset($peminjaman) ? $peminjaman->user->name : auth()->user()->name }}" 
                   readonly>
        </div>

        {{-- Pilih Buku --}}
        <div class="mb-3">
            <label for="buku_id" class="form-label">Buku</label>
            <select name="buku_id" id="buku_id" class="form-control">
                <option value="">-- Pilih Buku --</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}" 
                        {{ (isset($peminjaman) && $peminjaman->buku_id == $buku->id) ? 'selected' : '' }}>
                        {{ $buku->judul }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Pinjam --}}
        <div class="mb-3">
            <label for="tgl_pinjam" class="form-label">Tanggal Pinjam</label>
            <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control" 
                value="{{ $peminjaman->tgl_pinjam ?? old('tgl_pinjam', date('Y-m-d')) }}">
        </div>

        {{-- Tanggal Jatuh Tempo otomatis +7 hari --}}
        <div class="mb-3">
            <label for="tgl_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo (otomatis 7 hari)</label>
            <input type="date" id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" class="form-control" 
                value="{{ $peminjaman->tgl_jatuh_tempo ?? old('tgl_jatuh_tempo') }}" readonly>
        </div>

        {{-- Status tampil hanya saat edit --}}
        @if(isset($peminjaman))
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <input type="text" id="status" name="status" class="form-control" 
                value="{{ $peminjaman->status ?? old('status') }}" readonly>
        </div>
        @endif

        {{-- Tombol Aksi --}}
        <button type="submit" class="btn btn-success">
            {{ isset($peminjaman) ? 'Update' : 'Simpan' }}
        </button>
        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
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
