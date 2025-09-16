@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Kategori Buku</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm rounded-3">
        <div class="card-body">

            {{-- Tombol tambah kategori hanya untuk admin/petugas --}}
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                <a href="{{ route('kategori_buku.create') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-plus"></i> Tambah Kategori
                </a>
            @endif

            <div class="table-responsive">
                <table id="file_export" class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center" style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $index => $kategori)
                        <tr>
                            <td class="text-center">{{ $kategoris->firstItem() + $index }}</td>
                            <td class="text-center">{{ $kategori->kode }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td>{{ $kategori->deskripsi ?? '-' }}</td>
                            <td class="text-center">
                                {{-- Semua user bisa lihat detail --}}
                                @if(auth()->user()->role == 'user')
                                    <a href="{{ route('user.kategori_buku.show', $kategori->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @else
                                    <a href="{{ route('kategori_buku.show', $kategori->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @endif

                                {{-- Hanya admin / petugas bisa edit & hapus --}}
                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                                    <a href="{{ route('kategori_buku.edit',$kategori->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('kategori_buku.destroy',$kategori->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin hapus kategori_buku ini?')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada kategori</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info & Pagination --}}
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Showing {{ $kategoris->firstItem() }} to {{ $kategoris->lastItem() }} 
                    of {{ $kategoris->total() }} entries
                </div>
                <div class="dataTables_paginate">
                    {{ $kategoris->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
