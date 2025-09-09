<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Denda Mingguan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        h2, p { text-align: center; margin: 0; }
    </style>
</head>
<body>
    <h2>Laporan Denda Mingguan</h2>
    <p>Periode: {{ $startDate->format('d-m-Y') }} s/d {{ $endDate->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Kondisi Buku</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dendas as $index => $denda)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $denda->pengembalian->user->name ?? '-' }}</td>
                <td>{{$denda->pengembalian->kondisi}}</td>
                <td>{{ $denda->keterangan }}</td>
                <td>Rp {{ number_format($denda->jumlah, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_',' ',$denda->status)) }}</td>
                <td>{{ $denda->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
