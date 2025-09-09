@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>
    <p>Halo <b>{{ $user->name }}</b>, Anda login sebagai <b>Admin</b>.</p>

    <!-- Cards -->
    <div class="row g-3">
        @foreach ($cards as $card)
        <div class="col-md-2">
            <div class="card border-0 zoom-in bg-{{ $card['color'] }}-subtle shadow-sm h-100">
                <div class="card-body text-center">
                    <img src="{{ asset('admin/assets/images/svgs/' . $card['icon']) }}"
                        width="50" height="50" class="mb-3" alt="{{ $card['title'] }}" />
                    <p class="fw-semibold fs-5 text-{{ $card['color'] }} mb-1">
                        {{ $card['title'] }}
                    </p>
                    <h5 class="fw-semibold text-{{ $card['color'] }} mb-0">
                        @if($card['title'] === 'Denda')
                            Rp {{ number_format($card['total'], 0, ',', '.') }}
                        @else
                            {{ $card['total'] }}
                        @endif
                    </h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Chart Section -->
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Diagram Peminjaman Bulanan</h5>
                <canvas id="chartPeminjaman"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Diagram Pengembalian Bulanan</h5>
                <canvas id="chartPengembalian"></canvas>
            </div>
        </div>
    </div>

    <!-- Line Chart -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card p-3 shadow-sm">
                <h5 class="mb-3">Tren Peminjaman & Pengembalian</h5>
                <canvas id="chartTren"></canvas>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Chart Bar Peminjaman
    new Chart(document.getElementById('chartPeminjaman'), {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Peminjaman',
                data: @json(array_values($chartPeminjaman)),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderRadius: 6
            }]
        }
    });

    // Chart Bar Pengembalian
    new Chart(document.getElementById('chartPengembalian'), {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Pengembalian',
                data: @json(array_values($chartPengembalian)),
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderRadius: 6
            }]
        }
    });

    // Line Chart Tren
    new Chart(document.getElementById('chartTren'), {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [
                {
                    label: 'Peminjaman',
                    data: @json(array_values($chartPeminjaman)),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Pengembalian',
                    data: @json(array_values($chartPengembalian)),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endsection
