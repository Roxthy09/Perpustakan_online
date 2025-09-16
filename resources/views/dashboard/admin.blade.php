@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Dashboard Admin</h1>
    <p>Halo {{ auth()->user()->name }}, Anda login sebagai <b>Admin</b>.</p>

    <!-- Card Summary -->
    <div class="row">
        @foreach ($cards as $card)
        <div class="col-md-2" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="card border-0 bg-{{ $card['color'] }}-subtle shadow-sm custom-card">
                <div class="card-body text-center">
                    <img src="{{ asset('admin/assets/images/svgs/' . $card['icon']) }}"
                        width="50" height="50" class="mb-3" />
                    <p class="fw-semibold fs-5 text-{{ $card['color'] }} mb-1">
                        {{ $card['title'] }}
                    </p>
                    <h5 class="fw-semibold text-{{ $card['color'] }} mb-0">
                        {{ $card['title'] === 'Denda' ? 'Rp ' . number_format($card['total'], 0, ',', '.') : $card['total'] }}
                    </h5>
                    <!-- Persentase growth -->
                    @if(isset($card['growth']))
                        <small class="{{ $card['growth'] >= 0 ? 'text-success' : 'text-danger' }}">
                            {{ $card['growth'] >= 0 ? '+' : '' }}{{ $card['growth'] }}% dari bulan lalu
                        </small>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Chart Section -->
    <div class="row mt-5">
        <div class="col-md-6" data-aos="fade-up">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Diagram Peminjaman Bulanan (Bar)</h5>
                <canvas id="chartPeminjaman"></canvas>
            </div>
        </div>
        <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Diagram Pengembalian Bulanan (Bar)</h5>
                <canvas id="chartPengembalian"></canvas>
            </div>
        </div>
    </div>

    <!-- Line Chart -->
    <div class="row mt-5">
        <div class="col-md-12" data-aos="fade-up" data-aos-delay="400">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Tren Peminjaman & Pengembalian (Line)</h5>
                <canvas id="chartTren"></canvas>
                <button id="downloadChart" class="btn btn-sm btn-outline-success mt-3">
                    Download Chart (PNG)
                </button>
            </div>
        </div>
    </div>

    <!-- Notifikasi Ringkas -->
    <!-- Notifikasi Ringkas -->
<div class="row mt-5">
    <h5 class="mb-3">Notifikasi Ringkas</h5>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-warning-subtle animate__animated animate__fadeInUp">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <span class="fs-1 text-warning">🔔</span>
                </div>
                <div>
                    <p class="mb-0 fw-semibold">Peminjaman Terlambat</p>
                    <h5 class="mb-0 text-warning">
                        {{ \App\Models\Peminjaman::where('status', 'terlambat')->count() }} Buku
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-info-subtle animate__animated animate__fadeInUp animate__delay-1s">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <span class="fs-1 text-info">⭐</span>
                </div>
                <div>
                    <p class="mb-0 fw-semibold">Buku Terpopuler</p>
                    <h5 class="mb-0 text-info">
                        {{ \App\Models\Buku::withCount('peminjaman')->orderByDesc('peminjaman_count')->first()->judul ?? '-' }}
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-success-subtle animate__animated animate__fadeInUp animate__delay-2s">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <span class="fs-1 text-success">💰</span>
                </div>
                <div>
                    <p class="mb-0 fw-semibold">Denda Terbesar</p>
                    <h5 class="mb-0 text-success">
                        Rp {{ number_format(\App\Models\Denda::max('jumlah') ?? 0, 0, ',', '.') }}
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@section('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- AOS Animation -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<!-- Date Range Picker -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    AOS.init();

    // Date Range Picker
    $('#daterange').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        console.log("Filter dari: " + start.format('YYYY-MM-DD') + " ke " + end.format('YYYY-MM-DD'));
    });

    const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Chart Bar Peminjaman
    const chartPeminjaman = new Chart(document.getElementById('chartPeminjaman'), {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Peminjaman',
                data: @json(array_values($chartPeminjaman)),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderRadius: 6
            }]
        },
        options: {
            animation: {
                duration: 1500,
                easing: 'easeOutBounce'
            }
        }
    });

    // Chart Bar Pengembalian
    const chartPengembalian = new Chart(document.getElementById('chartPengembalian'), {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Pengembalian',
                data: @json(array_values($chartPengembalian)),
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderRadius: 6
            }]
        },
        options: {
            animation: {
                duration: 1500,
                easing: 'easeOutElastic'
            }
        }
    });

    // Line Chart Tren
    const chartTren = new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [{
                    label: 'Peminjaman',
                    data: @json(array_values($chartPeminjaman)),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                },
                {
                    label: 'Pengembalian',
                    data: @json(array_values($chartPengembalian)),
                    borderColor: 'rgba(255, 159, 64, 1)',
                    backgroundColor: 'rgba(255, 159, 64, 0.2)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }
            ]
        },
        options: {
            responsive: true,
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: {
                    position: 'top'
                },
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Download Chart
    document.getElementById('downloadChart').addEventListener('click', function() {
        const link = document.createElement('a');
        link.href = chartTren.toBase64Image();
        link.download = 'chart-tren.png';
        link.click();
    });
</script>

<style>
    /* Card Hover Effect */
    .custom-card {
        transition: all 0.3s ease-in-out;
    }
    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection
