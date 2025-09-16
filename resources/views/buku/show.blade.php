@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Detail Buku</h1>

    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                @if($buku->gambar)
                <img src="{{ asset('storage/'.$buku->gambar) }}" class="img-fluid rounded-start" alt="{{ $buku->judul }}">
                @else
                <img src="https://via.placeholder.com/300x400?text=No+Image" class="img-fluid rounded-start" alt="No Image">
                @endif
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">{{ $buku->judul }}</h3>
                    <p class="card-text"><strong>Kode Buku:</strong> {{ $buku->kode_buku }}</p>
                    <p class="card-text"><strong>Penulis:</strong> {{ $buku->penulis }}</p>
                    <p class="card-text"><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
                    <p class="card-text"><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                    <p class="card-text"><strong>Kategori:</strong> {{ $buku->kategoris->nama ?? '-' }}</p>
                    <p class="card-text"><strong>Stok:</strong> {{ $buku->stok }}</p>
                    <p class="card-text">
                        <small class="text-muted">Dibuat pada: {{ $buku->created_at->format('d M Y') }}</small>
                    </p>

                    {{-- Tombol Peminjaman hanya untuk User --}}
                    @if(auth()->user()->role === 'user')
                    <a href="{{ route('user.peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Navigasi --}}
    @if(auth()->user()->role === 'user')
    <a href="{{ route('user.buku.index') }}" class="btn btn-secondary">Kembali</a>
    @else
    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
    @endif

</div>
@endsection