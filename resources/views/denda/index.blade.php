@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Daftar Denda</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <a href="{{ route('denda.create') }}" class="btn btn-primary mb-3">Tambah Denda</a>

    <div class="card">
        <div class="card-body">
            <div class="mb-2">
                <h4 class="card-title mb-0">File export</h4>
            </div>
            <p class="card-subtitle mb-3">
                Exporting data from a table can often be a key part of a
                complex application. The Buttons extension for DataTables
                provides three plug-ins that provide overlapping
                functionality for data export. You can refer full
                documentation from here
                <a href="https://datatables.net/">Datatables</a>
            </p>
            <a href="{{ route('denda.export.pdf') }}" class="btn btn-danger mb-3" target="_blank">
                Export PDF Mingguan
            </a>

            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Kondisi Buku</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dendas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pengembalian->peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $item->pengembalian->peminjaman->buku->judul ?? '-' }}</td>
                            <td>{{$item->pengembalian->kondisi}}</td>
                            <td>{{$item->keterangan}}</td>
                            <td>Rp {{ number_format($item->jumlah) }}</td>
                            <td>{{ucfirst(str_replace ('_' , ' ', $item->status)) }}</td>
                            <td>
                                @if($item->status !== 'sudah_bayar')
                                <form action="{{ route('denda.konfirmasi', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi denda sudah dibayar?')">Konfirmasi</button>
                                </form>
                                @endif
                                <a href="{{ route('denda.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('denda.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus denda ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>#</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                    </tfoot>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <!-- Info seperti DataTables -->
                    <div class="dataTables_info" role="status" aria-live="polite">
                        Showing {{ $dendas->firstItem() }} to {{ $dendas->lastItem() }} of {{ $dendas->total() }} entries
                    </div>

                    <!-- Pagination -->
                    <div class="dataTables_paginate paging_simple_numbers">
                        {{ $dendas->onEachSide(1)->links('vendor.pagination.datatable') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection