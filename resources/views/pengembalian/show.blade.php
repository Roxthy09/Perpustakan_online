@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Konfirmasi Pengembalian Buku</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card mb-3">
        <div class="card-header">
            Detail Pengembalian
        </div>
        <div class="card-body">
            <p><strong>Peminjam:</strong> {{ $pengembalian->peminjaman->user->name ?? '-' }}</p>
            <p><strong>Buku:</strong> {{ $pengembalian->peminjaman->buku->judul ?? '-' }}</p>
            <p><strong>Tanggal Kembali:</strong> {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d-m-Y') }}</p>
            <p><strong>Status:</strong> {{ $pengembalian->status ?? '-' }}</p>
            @if($pengembalian->status != 'selesai')
            <div class="mb-3">
                <p><strong>Kondisi Buku:</strong> {{ $pengembalian->kondisi }}</p>
            </div>
            @else
            <div class="alert alert-info">Pengembalian sudah selesai dan denda sudah dikonfirmasi.</div>
            @endif
        </div>
    </div>
</div>

<script>
    function toggleTelat() {
        let kondisi = document.getElementById('kondisi').value;
        let div = document.getElementById('telatDiv');
        if (kondisi === 'telat') {
            div.style.display = 'block';
        } else {
            div.style.display = 'none';
        }
    }
</script>
@endsection