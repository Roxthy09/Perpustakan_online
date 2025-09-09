@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Daftar Pengembalian Buku</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary mb-3">Tambah Pengembalian</a>

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
                            <th>#</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tanggal Kembali</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengembalians as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y') }}</td>
                            <td>{{ $item->kondisi }}</td>
                            <td>{{ $item->status ?? '-' }}</td>
                            <td>
                                @if($item->denda)
                                Rp {{ number_format($item->denda->jumlah) }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                                @if($item->status != 'selesai')
                                <button class="btn btn-warning btn-sm" onclick="openDendaModal({{ $item->id }})">Tindak Lanjut</button>
                                @endif
                                <form action="{{ route('pengembalian.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus pengembalian?')">Hapus</button>
                                </form>
                                @else
                                <a href="{{ route('pengembalian.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                @endif
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
                            <th>Tanggal Kembali</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                        <!-- end row -->
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Info seperti DataTables -->
                <div class="dataTables_info" role="status" aria-live="polite">
                    Showing {{ $pengembalians->firstItem() }} to {{ $pengembalians->lastItem() }} of {{ $pengembalians->total() }} entries
                </div>

                <!-- Pagination -->
                <div class="dataTables_paginate paging_simple_numbers">
                    {{ $pengembalians->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Denda -->
<div class="modal fade" id="dendaModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="dendaForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Denda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kondisi" class="form-label">Kondisi Buku</label>
                        <select name="kondisi" id="modal_kondisi" class="form-control" onchange="toggleTelatModal()">
                            <option value="">--Pilih Kondisi--</option>
                            <option value="baik">Baik</option>
                            <option value="telat">Telat</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>

                    <div class="mb-3" id="modalTelatDiv" style="display:none;">
                        <label for="hari_telat" class="form-label">Jumlah Hari Telat</label>
                        <input type="number" name="hari_telat" id="modal_hari_telat" class="form-control" min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Konfirmasi</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleTelatModal() {
        let kondisi = document.getElementById('modal_kondisi').value;
        let div = document.getElementById('modalTelatDiv');
        if (kondisi === 'telat') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    }

    function openDendaModal(id) {
        // Set action form sesuai id pengembalian
        const form = document.getElementById('dendaForm');
        form.action = `/pengembalian/konfirmasi-denda/${id}`;

        // Reset form
        document.getElementById('modal_kondisi').value = '';
        document.getElementById('modal_hari_telat').value = '';
        toggleTelatModal();

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('dendaModal'));
        modal.show();
    }
</script>
@endsection