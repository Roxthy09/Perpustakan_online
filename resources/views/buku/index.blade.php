@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Buku</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            {{-- Tombol tambah buku hanya untuk admin / petugas --}}
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-plus"></i> Tambah Buku
                </a>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 80px;">Kode</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th style="width: 70px;">Stok</th>
                            <th style="width: 100px;">Gambar</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bukus as $buku)
                        <tr>
                            <td class="text-center">{{ $buku->kode_buku }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->kategoris ? $buku->kategoris->nama : '-' }}</td>
                            <td class="text-center">{{ $buku->stok }}</td>
                            <td class="text-center">
                                @if($buku->gambar)
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#gambarModal{{ $buku->id }}">
                                    Lihat
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="gambarModal{{ $buku->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $buku->judul }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/'.$buku->gambar) }}" alt="{{ $buku->judul }}" class="img-fluid rounded">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- Semua user bisa lihat detail --}}
                                @if(auth()->user()->role == 'user')
                                    <a href="{{ route('user.buku.show', $buku->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @else
                                    <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @endif

                                {{-- Hanya admin / petugas bisa edit & hapus --}}
                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                                    <a href="{{ route('buku.edit',$buku->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('buku.destroy',$buku->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin hapus buku ini?')">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Info & Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="small text-muted">
                    Menampilkan {{ $bukus->firstItem() }} - {{ $bukus->lastItem() }} dari {{ $bukus->total() }} data
                </div>
                <div>
                    {{ $bukus->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
