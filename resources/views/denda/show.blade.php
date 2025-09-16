@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Detail Denda</h1>

    <div class="card mb-3 shadow-sm">
        <div class="row g-0">
            <!-- Ikon di sebelah kiri -->
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
                <i class="ti ti-cash" style="font-size:100px; color:#6c757d;"></i>
            </div>

            <!-- Detail di sebelah kanan -->
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">Rp {{ number_format($denda->jumlah, 0, ',', '.') }}</h3>

                    <p class="mb-2"><strong>Peminjam:</strong> {{ $denda->pengembalian->peminjaman->user->name ?? '-' }}</p>
                    <p class="mb-2"><strong>Buku:</strong> {{ $denda->pengembalian->peminjaman->buku->judul ?? '-' }}</p>
                    <p class="mb-2"><strong>Kondisi Buku:</strong> {{ ucfirst($denda->pengembalian->kondisi) ?? '-' }}</p>

                    <p class="mb-2">
                        <strong>Status:</strong>
                        <span class="badge 
                            @if($denda->status == 'belum_bayar') bg-danger 
                            @elseif($denda->status == 'sudah_bayar') bg-success 
                            @else bg-secondary @endif">
                            {{ ucfirst(str_replace('_', ' ', $denda->status)) }}

                        </span>
                    </p>

                    <p class="card-text mt-3">
                        <small class="text-muted">Dibuat pada: {{ $denda->created_at->format('d M Y') }}</small><br>
                        <small class="text-muted">Terakhir diperbarui: {{ $denda->updated_at->format('d M Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @if(auth()->user()->role === 'user')
    <a href="{{ route('user.denda.index') }}" class="btn btn-secondary">Kembali</a>
    @else
    <a href="{{ route('denda.index') }}" class="btn btn-secondary">Kembali</a>
    @endif
</div>
@endsection