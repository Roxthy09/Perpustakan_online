<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Perpustakaan</a>
            <div>
                <a class="btn btn-outline-light btn-sm" href="{{ route('buku.index') }}">Buku</a>
                <a class="btn btn-outline-light btn-sm" href="{{ route('rak.index') }}">Rak</a>
                <a class="btn btn-outline-light btn-sm" href="{{ route('peminjaman.index') }}">Peminjaman</a>
                <a class="btn btn-outline-light btn-sm" href="{{ route('pengembalian.index') }}">Pengembalian</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
