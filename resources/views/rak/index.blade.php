@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h2>Data Rak</h2>

    <a href="{{ route('rak.create') }}" class="btn btn-success mb-3">Tambah Rak</a>

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
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($raks as $rak)
                        <tr>
                            <td>{{ $rak->kode_rak }}</td>
                            <td>{{ $rak->nama_rak }}</td>
                            <td>{{ $rak->lokasi }}</td>
                            <td>
                                <a href="{{ route('rak.edit', $rak->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('rak.destroy', $rak->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-danger btn-sm">Hapus</button>
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
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Info seperti DataTables -->
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{ $raks->firstItem() }} to {{ $raks->lastItem() }} of {{ $raks->total() }} entries
                </div>

                <!-- Pagination -->
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $raks->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection