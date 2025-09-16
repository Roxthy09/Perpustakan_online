@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Detail Rak</h1>

    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
                <i class="ti ti-books" style="font-size:100px; color:#6c757d;"></i>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">{{ $rak->nama_rak }}</h3>
                    <p class="card-text"><strong>Kode Rak:</strong> {{ $rak->kode_rak }}</p>
                    <p class="card-text"><strong>Lokasi:</strong> {{ $rak->lokasi }}</p>
                    <p class="card-text">
                        <small class="text-muted">Dibuat pada: {{ $rak->created_at->format('d M Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Navigasi --}}
    @if(auth()->user()->role === 'user')
        <a href="{{ route('user.rak.index') }}" class="btn btn-secondary">Kembali</a>
    @else
        <a href="{{ route('rak.index') }}" class="btn btn-secondary">Kembali</a>
    @endif
</div>
@endsection
