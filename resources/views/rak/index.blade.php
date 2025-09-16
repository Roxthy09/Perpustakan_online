@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Rak</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">

            {{-- Tombol tambah rak hanya untuk admin/petugas --}}
            @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                <a href="{{ route('rak.create') }}" class="btn btn-primary mb-3">
                    <i class="ti ti-plus"></i> Tambah Rak
                </a>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 80px;">Kode</th>
                            <th>Nama Rak</th>
                            <th>Lokasi</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($raks as $rak)
                        <tr>
                            <td class="text-center">{{ $rak->kode_rak }}</td>
                            <td>{{ $rak->nama_rak }}</td>
                            <td>{{ $rak->lokasi }}</td>
                            <td class="text-center">
                                {{-- Semua user bisa lihat detail --}}
                                @if(auth()->user()->role == 'user')
                                    <a href="{{ route('user.rak.show', $rak->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @else
                                    <a href="{{ route('rak.show', $rak->id) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                @endif

                                {{-- Hanya admin / petugas bisa edit & hapus --}}
                                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                                    <a href="{{ route('rak.edit',$rak->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('rak.destroy',$rak->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin hapus rak ini?')">
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
                    Menampilkan {{ $raks->firstItem() }} - {{ $raks->lastItem() }} dari {{ $raks->total() }} data
                </div>
                <div>
                    {{ $raks->onEachSide(1)->links('vendor.pagination.datatable') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
