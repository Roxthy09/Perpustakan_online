@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Peminjaman</h1>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">Tambah Peminjaman</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Peminjam</th>
                <th>Buku</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $p)
            <tr>
                <td>{{ $p->nama_peminjam ?? ($p->user->name ?? '-') }}</td>
                <td>{{ $p->buku?->judul ?? '-' }}</td>
                <td>{{ $p->status ?? 'Dipinjam' }}</td>
                <td>{{ $p->tanggal_pinjam ?? $p->tgl_pinjam ?? '-' }}</td>
                <td>{{ $p->tanggal_kembali ?? $p->tgl_jatuh_tempo ?? '-' }}</td>
                <td>
                    <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin dihapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
