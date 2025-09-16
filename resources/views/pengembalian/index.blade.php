@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Daftar Pengembalian Buku</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
             {{-- Filter & Search --}}
            <div class="mb-3">
                <form method="GET" action="{{ route('pengembalian.index') }}" class="row g-2">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control" placeholder="Cari nama peminjam / judul buku">
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="menunggu" {{ request('status')=='menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="selesai" {{ request('status')=='selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Filter Tanggal Pengembalian --}}
                    <div class="col-md-3">
                        <input type="date" name="tgl_pengembalian" value="{{ request('tgl_pengembalian') }}"
                            class="form-control">
                    </div>

                    {{-- Tombol --}}
                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search"></i>
                        </button>
                    </div>

                    {{-- Reset --}}
                    <div class="col-md-1 d-grid">
                        <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table id="file_export" class="table w-100 table-striped table-bordered display text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Peminjam</th>
                            <th class="text-center">Buku</th>
                            <th class="text-center">Tanggal Kembali</th>
                            <th class="text-center">Kondisi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                            <th class="text-center">Tindak Lanjut</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengembalians as $item)
                        @if(auth()->user()->role !== 'user' || $item->user_id == auth()->id())
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $item->peminjaman->buku->judul ?? '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                @php
                                $kondisi = strtolower($item->kondisi);
                                $badgeKondisi = match($kondisi) {
                                'baik' => 'success',
                                'telat' => 'warning',
                                'rusak' => 'danger',
                                'hilang' => 'dark',
                                default => 'secondary',
                                };
                                @endphp
                                <span class="badge bg-{{ $badgeKondisi }}">{{ ucfirst($item->kondisi) }}</span>
                            </td>
                            <td class="text-center">
                                @php
                                $status = strtolower($item->status);
                                $badgeStatus = match($status) {
                                'pending' => 'warning',
                                'proses' => 'primary',
                                'selesai' => 'success',
                                'ditolak' => 'danger',
                                default => 'secondary',
                                };
                                @endphp
                                <span class="badge bg-{{ $badgeStatus }}">{{ ucfirst($item->status) }}</span>
                            </td>
                            {{-- Tombol Aksi --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    @if(auth()->user()->role == 'user')
                                    <a href="{{ route('user.pengembalian.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('pengembalian.show', $item->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    @endif

                                    {{-- Hanya Admin/Petugas bisa Edit & Hapus --}}
                                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                                    <a href="{{ route('pengembalian.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('pengembalian.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Hapus pengembalian?')"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>

                            {{-- Kolom Tindak Lanjut (khusus Admin/Petugas) --}}
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'petugas')
                            <td class="text-center">
                                @if($item->status != 'selesai')
                                <button class="btn btn-primary btn-sm" onclick="openDendaModal({{ $item->id }})" title="Tindak Lanjut">
                                    <i class="ti ti-clipboard-check"></i> Tindak Lanjut
                                </button>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="dataTables_info">
                    Showing {{ $pengembalians->firstItem() }} to {{ $pengembalians->lastItem() }} of {{ $pengembalians->total() }} entries
                </div>
                <div class="dataTables_paginate">
                    {{ $pengembalians->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Denda --}}
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
        document.getElementById('modalTelatDiv').style.display = (kondisi === 'telat') ? 'block' : 'none';
    }

    function openDendaModal(id) {
        const form = document.getElementById('dendaForm');
        form.action = `/pengembalian/konfirmasi-denda/${id}`;

        document.getElementById('modal_kondisi').value = '';
        document.getElementById('modal_hari_telat').value = '';
        toggleTelatModal();

        const modal = new bootstrap.Modal(document.getElementById('dendaModal'));
        modal.show();
    }
</script>
@endsection