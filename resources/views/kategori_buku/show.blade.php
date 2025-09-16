@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Detail Kategori Buku</h1>

    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
                <i class="ti ti-category" style="font-size:100px; color:#6c757d;"></i>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">{{ $kategoris->nama }}</h3>
                    <p class="card-text"><strong>Kode Kategori:</strong> {{ $kategoris->kode }}</p>
                    <p class="card-text"><strong>Deskripsi:</strong> {{ $kategoris->deskripsi ?? '-' }}</p>
                    <p class="card-text">
                        <small class="text-muted">Dibuat pada: {{ $kategoris->created_at->format('d M Y') }}</small><br>
                        <small class="text-muted">Terakhir diperbarui: {{ $kategoris->updated_at->format('d M Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Navigasi --}}
    @if(auth()->user()->role === 'user')
        <a href="{{ route('user.kategori_buku.index') }}" class="btn btn-secondary">Kembali</a>
    @else
        <a href="{{ route('kategori_buku.index') }}" class="btn btn-secondary">Kembali</a>
    @endif
</div>
@endsection
