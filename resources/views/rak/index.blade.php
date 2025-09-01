@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Rak</h2>

    <a href="{{ route('rak.create') }}" class="btn btn-success mb-3">Tambah Rak</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
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
    </table>
</div>
@endsection
