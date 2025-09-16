@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Peminjaman</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <style>
        .nowrap {
            white-space: nowrap;
        }
    </style>



    <div class="card shadow-sm rounded-3">
        <div class="card-body">
            {{-- Filter & Search --}}
            <div class="mb-3">
                <form method="GET" action="{{ route('peminjaman.index') }}" class="row g-2">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control" placeholder="Cari nama peminjam / judul buku">
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ request('status')=='disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="dipinjam" {{ request('status')=='dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="dikembalikan" {{ request('status')=='dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="ditolak" {{ request('status')=='ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal Pinjam --}}
                    <div class="col-md-3">
                        <input type="date" name="tgl_pinjam" value="{{ request('tgl_pinjam') }}"
                            class="form-control">
                    </div>

                    {{-- Tombol --}}
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search"></i>
                        </button>
                    </div>

                    {{-- Reset Filter --}}
                    <div class="col-md-1 d-grid">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th style="width:5%" class="text-center">No</th>
                            <th class="text-center">Peminjam</th>
                            <th class="text-center">Buku</th>
                            <th class="text-center" style="width:12%">Tanggal Pinjam</th>
                            <th class="text-center" style="width:15%">Tanggal Jatuh Tempo</th>
                            <th class="text-center">Status</th>
                            <th style="width:15%" class="text-center">Aksi</th>
                            <th style="width:20%" class="text-center">Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $index => $p)
                        <tr>
                            <td class="text-center">{{ $peminjamans->firstItem() + $index }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td class="text-center nowrap">{{ $p->tgl_pinjam }}</td>
                            <td class="text-center nowrap">{{ $p->tgl_jatuh_tempo }}</td>
                            <td class="text-center">
                                @php
                                $status = strtolower($p->status);
                                $badge = match($status) {
                                'pending' => 'warning',
                                'disetujui' => 'success',
                                'dipinjam' => 'primary',
                                'dikembalikan' => 'info',
                                'ditolak' => 'danger',
                                default => 'secondary',
                                };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst($p->status) }}</span>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if(auth()->user()->role == 'user')
                                    <a href="{{ route('user.peminjaman.show', $p->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('peminjaman.show', $p->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    @endif

                                    @if(Auth::user()->role === 'user' && $p->status == 'pending')
                                    <a href="{{ route('user.peminjaman.edit', $p->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus peminjaman ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>

                            {{-- Kolom Konfirmasi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if((Auth::user()->role === 'petugas' || Auth::user()->role === 'admin') && $p->status == 'pending')
                                    <form action="{{ route('peminjaman.konfirmasi', $p->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="disetujui">
                                        <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                            <i class="ti ti-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('peminjaman.konfirmasi', $p->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                            <i class="ti ti-x"></i>
                                        </button>
                                    </form>
                                    @endif

                                    @if(Auth::user()->role === 'user')
                                    @if($p->status == 'disetujui')
                                    <form action="{{ route('user.peminjaman.ambil', $p->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-primary btn-sm" title="Ambil Buku">
                                            <i class="ti ti-book"></i>
                                        </button>
                                    </form>
                                    @elseif($p->status == 'dipinjam')
                                    <form action="{{ route('user.peminjaman.kembalikan', $p->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-secondary btn-sm" title="Kembalikan Buku">
                                            <i class="ti ti-refresh"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada data peminjaman</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info & Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Showing {{ $peminjamans->firstItem() }} to {{ $peminjamans->lastItem() }} of {{ $peminjamans->total() }} entries
                </div>
                <div class="dataTables_paginate">
                    {{ $peminjamans->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection