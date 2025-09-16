@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Detail Peminjaman</h1>

    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
                <i class="ti ti-file-export" style="font-size:100px; color:#6c757d;"></i>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">{{ $peminjaman->buku->judul }}</h3>
                    <p class="card-text"><strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}</p>
                    <p class="card-text"><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}</p>
                    <p class="card-text"><strong>Tanggal Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($peminjaman->tgl_jatuh_tempo)->format('d M Y') }}</p>
                    <p class="card-text">
                        <strong>Status:</strong> 
                        <span class="badge 
                            @if($peminjaman->status == 'dipinjam') bg-warning text-dark 
                            @elseif($peminjaman->status == 'dikembalikan') bg-success 
                            @elseif($peminjaman->status == 'ditolak') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </p>
                    <p class="card-text">
                        <small class="text-muted">Dibuat pada: {{ $peminjaman->created_at->format('d M Y') }}</small><br>
                        <small class="text-muted">Terakhir diperbarui: {{ $peminjaman->updated_at->format('d M Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Navigasi --}}
    @if(auth()->user()->role === 'user')
        <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    @else
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    @endif

</div>
@endsection
