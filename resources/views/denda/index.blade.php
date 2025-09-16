@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Denda</h2>

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
                <form method="GET" action="{{ route('denda.index') }}" class="row g-2">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control" placeholder="Cari nama peminjam / judul buku">
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="belum bayar" {{ request('status')=='belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="sudah bayar" {{ request('status')=='sudah_bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal --}}
                    <div class="col-md-3">
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
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
                        <a href="{{ route('denda.index') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th style="width:5%" class="text-center">No</th>
                            <th class="text-center">Peminjam</th>
                            <th class="text-center">Buku</th>
                            <th class="text-center">Jumlah Denda</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal</th>
                            <th style="width:20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dendas as $index => $d)
                        <tr>
                            <td class="text-center">{{ $dendas->firstItem() + $index }}</td>
                            <td>{{ $d->pengembalian->peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $d->pengembalian->peminjaman->buku->judul ?? '-' }}</td>
                            <td class="text-center nowrap">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                            <td class="text-center">
                                @php
                                    $status = strtolower($d->status);
                                    $badge = $status === 'sudah_bayar' ? 'success' : 'danger';
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ ucfirst(str_replace('_', ' ', $d->status)) }}</span>
                            </td>
                            <td class="text-center nowrap">{{ $d->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('denda.show', $d->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('denda.edit', $d->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('denda.destroy', $d->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data denda</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info & Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Showing {{ $dendas->firstItem() }} to {{ $dendas->lastItem() }} of {{ $dendas->total() }} entries
                </div>
                <div class="dataTables_paginate">
                    {{ $dendas->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
