@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Detail Pengembalian</h1>

    <div class="card mb-3 shadow-sm">
        <div class="row g-0">
            <!-- Ikon di sebelah kiri -->
            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
                <i class="ti ti-refresh" style="font-size:100px; color:#6c757d;"></i>
            </div>

            <!-- Detail di sebelah kanan -->
            <div class="col-md-8">
                <div class="card-body">
                    <h3 class="card-title">{{ $pengembalian->peminjaman->buku->judul ?? '-' }}</h3>

                    <p class="mb-2"><strong>Peminjam:</strong> {{ $pengembalian->peminjaman->user->name ?? '-' }}</p>
                    <p class="mb-2"><strong>Tanggal Kembali:</strong> 
                        {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d M Y') }}
                    </p>
                    <p class="mb-2">
                        <strong>Status:</strong>
                        <span class="badge 
                            @if($pengembalian->status == 'proses') bg-warning text-dark 
                            @elseif($pengembalian->status == 'selesai') bg-success 
                            @elseif($pengembalian->status == 'ditolak') bg-danger 
                            @else bg-secondary @endif">
                            {{ ucfirst($pengembalian->status) }}
                        </span>
                    </p>

                    {{-- Kondisi Buku hanya tampil jika masih proses --}}
                    @if($pengembalian->status != 'selesai')
                        <p class="mb-2"><strong>Kondisi Buku:</strong> {{ $pengembalian->kondisi ?? '-' }}</p>
                    @else
                        <div class="alert alert-info">Pengembalian sudah selesai dan denda sudah dikonfirmasi.</div>
                    @endif

                    <p class="card-text mt-3">
                        <small class="text-muted">Dibuat pada: {{ $pengembalian->created_at->format('d M Y') }}</small><br>
                        <small class="text-muted">Terakhir diperbarui: {{ $pengembalian->updated_at->format('d M Y') }}</small>
                    </p>

                    {{-- Tombol Navigasi --}}
                    <div class="mt-4">
                        @if(auth()->user()->role === 'user')
                            <a href="{{ route('user.pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
                        @else
                            <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
                        @endif

                        {{-- Tombol Konfirmasi hanya untuk Admin/Petugas --}}
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                            <form action="{{ route('pengembalian.konfirmasi', $pengembalian->id) }}" 
                                  method="POST" class="d-inline-block">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="ti ti-check"></i> Konfirmasi
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
