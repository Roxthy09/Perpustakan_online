@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2>Daftar Kategori Buku</h2>
    <a href="{{ route('kategori_buku.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategoris as $kategori)
                        <tr>
                            <td>{{ $kategori->kode }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td>{{ $kategori->deskripsi }}</td>
                            <td>
                                <a href="{{ route('kategori_buku.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('kategori_buku.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus kategori?')" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Info seperti DataTables -->
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{ $kategoris->firstItem() }} to {{ $kategoris->lastItem() }} of {{ $kategoris->total() }} entries
                </div>

                <!-- Pagination -->
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $kategoris->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection