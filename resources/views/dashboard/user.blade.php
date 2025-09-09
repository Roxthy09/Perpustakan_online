@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1 class="mb-4 animate__animated animate__fadeInDown">Dashboard User</h1>
    <p class="mb-5">Halo <b>{{ auth()->user()->name }}</b>, selamat datang di perpustakaan 🎉</p>

    <!-- Statistik Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 animate__animated animate__zoomIn">
                <div class="card-body text-center">
                    <i class="ti ti-book fs-12 text-primary mb-2"></i>
                    <h6 class="fw-bold">Buku Dipinjam</h6>
                    <h3 class="text-primary">{{ $jumlahDipinjam }}</h3>
                    <div class="progress mt-2" style="height: 10px;">
                        <div class="progress-bar bg-info" role="progressbar" 
                             style="width: {{ ($jumlahDipinjam/5)*100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 animate__animated animate__zoomIn" style="animation-delay:0.2s">
                <div class="card-body text-center">
                    <i class="ti ti-rotate-clockwise fs-12 text-success mb-2"></i>
                    <h6 class="fw-bold">Sudah Dikembalikan</h6>
                    <h3 class="text-success">{{ $jumlahDikembalikan }}</h3>
                    <div class="progress mt-2" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ ($jumlahDikembalikan/5)*100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 animate__animated animate__zoomIn" style="animation-delay:0.4s">
                <div class="card-body text-center">
                    <i class="ti ti-currency-dollar fs-12 text-danger mb-2"></i>
                    <h6 class="fw-bold">Total Denda</h6>
                    <h3 class="text-danger">Rp {{ number_format($totalDenda,0,',','.') }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 animate__animated animate__zoomIn" style="animation-delay:0.6s">
                <div class="card-body text-center">
                    <i class="ti ti-chart-bar fs-12 text-warning mb-2"></i>
                    <h6 class="fw-bold">Tips Perpustakaan</h6>
                    <p class="mb-0 text-muted small">Pinjam buku sesuai jadwal dan kembalikan tepat waktu!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-5 g-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-3 animate__animated animate__fadeInLeft">
                <h6>Peminjaman vs Pengembalian Bulanan</h6>
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3 animate__animated animate__fadeInRight">
                <h6>Distribusi Status Buku</h6>
                <canvas id="doughnutChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Histori Terbaru -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card shadow-sm p-3 animate__animated animate__fadeInUp">
                <h6>Histori Terbaru</h6>
                <ul class="list-group">
                    @forelse ($histori as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->buku->judul }}
                            @if($item->tanggal_jatuh_tempo && \Carbon\Carbon::now()->diffInDays($item->tanggal_jatuh_tempo, false) <= 7 && $item->status == 'dipinjam')
                                <span class="badge bg-warning">⚠️ Jatuh Tempo Minggu Ini</span>
                            @else
                                <span class="badge bg-{{ $item->status == 'dipinjam' ? 'info' : 'success' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            @endif
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada histori</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const barChartCtx = document.getElementById('barChart').getContext('2d');
new Chart(barChartCtx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [
            {
                label: 'dipinjam',
                data: {!! json_encode(array_values($chartPeminjaman)) !!},
                backgroundColor: '#36A2EB'
            },
            {
                label: 'dikembalikan',
                data: {!! json_encode(array_values($chartPengembalian)) !!},
                backgroundColor: '#4BC0C0'
            }
        ]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});

const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
new Chart(doughnutCtx, {
    type: 'doughnut',
    data: {
        labels: ['dipinjam','dikembalikan'],
        datasets: [{
            data: [{{ $jumlahDipinjam }}, {{ $jumlahDikembalikan }}],
            backgroundColor: ['#36A2EB','#4BC0C0']
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
});
</script>
@endsection
