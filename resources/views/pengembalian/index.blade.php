@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Pengembalian</h1>
    <a href="{{ route('pengembalian.create') }}" class="btn btn-primary mb-3">Tambah Pengembalian</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Nama Peminjam</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalians as $p)
            <tr>
                <td>{{ $p->peminjaman->id }}</td>
                <td>{{ $p->user->name}}</td>
                <td>{{ $p->peminjaman?->buku?->judul ?? '-' }}</td>
                <td>{{ $p->peminjaman?->tgl_pinjam ?? '-' }}</td>
                <td>{{ $p->tgl_kembali }}</td>
                <td>
                    <a href="{{ route('pengembalian.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('pengembalian.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin dihapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
