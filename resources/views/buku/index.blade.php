@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Daftar Buku</h1>
    <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>

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
                            <th>Judul</th>
                            <th>Kategori Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bukus as $buku)
                        <tr>
                            <td>{{ $buku->kode_buku }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->kategoris ? $buku->kategoris->nama : 'Tidak ada kategori' }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ $buku->penerbit }}</td>
                            <td>{{ $buku->tahun_terbit}}</td>
                            <td>{{ $buku->stok }}</td>
                            <td>
                                @if($buku->gambar)
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#gambarModal{{ $buku->id }}">
                                    Lihat Gambar
                                </button>

                                <!-- Modal Gambar -->
                                <div class="modal fade" id="gambarModal{{ $buku->id }}" tabindex="-1" aria-labelledby="gambarModalLabel{{ $buku->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="gambarModalLabel{{ $buku->id }}">{{ $buku->judul }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/'.$buku->gambar) }}" alt="{{ $buku->judul }}" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                Tidak ada gambar
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('buku.edit',$buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <form action="{{ route('buku.destroy',$buku->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus buku ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <!-- start row -->
                        <tr>
                            <th>Kode</th>
                            <th>Judul</th>
                            <th>Kategori Buku</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun Terbit</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Info seperti DataTables -->
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{ $bukus->firstItem() }} to {{ $bukus->lastItem() }} of {{ $bukus->total() }} entries
                </div>

                <!-- Pagination -->
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $bukus->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection