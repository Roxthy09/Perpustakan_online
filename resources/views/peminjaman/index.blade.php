@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Daftar Peminjaman</h1>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamans as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->buku->judul }}</td>
                            <td>{{ $p->tgl_pinjam }}</td>
                            <td>{{ $p->tgl_jatuh_tempo }}</td>
                            <td>
                                @if($p->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($p->status == 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="badge bg-primary">Dipinjam</span>
                                @elseif($p->status == 'dikembalikan')
                                    <span class="badge bg-info">Dikembalikan</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                {{-- PETUGAS --}}
                                @if(Auth::user()->role === 'petugas')
                                    @if($p->status == 'pending')
                                        <form action="{{ route('peminjaman.konfirmasi', $p->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="disetujui">
                                            <button type="submit" class="btn btn-sm btn-success mb-1">Setujui</button>
                                        </form>
                                        <form action="{{ route('peminjaman.konfirmasi', $p->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="btn btn-sm btn-danger mb-1">Tolak</button>
                                        </form>
                                    @else
                                        <span>-</span>
                                    @endif
                                @endif

                                {{-- USER --}}
                                @if(Auth::user()->role === 'user')
                                    @if($p->status == 'disetujui')
                                        <form action="{{ route('user.peminjaman.ambil', $p->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-primary mb-1">Ambil Buku</button>
                                        </form>
                                    @elseif($p->status == 'dipinjam')
                                        <form action="{{ route('user.peminjaman.kembalikan', $p->id) }}" method="POST" style="display:inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning mb-1">Kembalikan</button>
                                        </form>
                                    @else
                                        <span>-</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Showing {{ $peminjamans->firstItem() }} to {{ $peminjamans->lastItem() }} of {{ $peminjamans->total() }} entries
                </div>
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $peminjamans->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
