@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Buku</h1>
    <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>
    <table class="table table-bordered">
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
                <td>{{$buku->tahun_terbit}}</td>
                <td>{{ $buku->stok }}</td>
                <td>
                    @if($buku->gambar)
                        <img src="{{ asset('storage/'.$buku->gambar) }}" width="80">
                    @endif
                </td>
                <td>
                    <a href="{{ route('buku.edit',$buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('buku.destroy',$buku->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
