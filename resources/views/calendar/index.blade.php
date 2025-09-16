@extends('layouts.admin.admin')

@section('content')
<div class="container-fluid">
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Kalender</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="{{ route('dashboard') }}">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Kalender</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('admin/assets/images/breadcrumb/ChatBc.png') }}" alt="modernize-img" class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            @php
                use Carbon\Carbon;

                $today = Carbon::today();
                $year = request('year', $today->year);
                $month = request('month', $today->month);

                $date = Carbon::createFromDate($year, $month, 1);
                $startOfMonth = $date->copy()->startOfMonth();
                $endOfMonth = $date->copy()->endOfMonth();
                $startDay = $startOfMonth->dayOfWeek; // 0 = Minggu
                $daysInMonth = $date->daysInMonth;

                $prevMonth = $date->copy()->subMonth();
                $nextMonth = $date->copy()->addMonth();
            @endphp

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('calendar.index', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}" class="btn btn-secondary">&laquo; {{ $prevMonth->locale('id')->translatedFormat('F Y') }}</a>
                <h3 class="mb-0">{{ $date->locale('id')->translatedFormat('F Y') }}</h3>
                <a href="{{ route('calendar.index', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}" class="btn btn-secondary">{{ $nextMonth->locale('id')->translatedFormat('F Y') }} &raquo;</a>
            </div>

            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>Minggu</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jumat</th>
                        <th>Sabtu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        {{-- Kosong sebelum tanggal 1 --}}
                        @for($i = 0; $i < $startDay; $i++)
                            <td></td>
                        @endfor

                        {{-- Isi tanggal --}}
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $currentDate = Carbon::createFromDate($year, $month, $day);
                                $isToday = $currentDate->isToday();
                            @endphp

                            <td class="{{ $isToday ? 'bg-primary text-white fw-bold' : '' }}">
                                {{ $day }}
                            </td>

                            @if(($day + $startDay) % 7 == 0)
                                </tr><tr>
                            @endif
                        @endfor

                        {{-- Kosong setelah akhir bulan --}}
                        @for($i = ($daysInMonth + $startDay); $i % 7 != 0; $i++)
                            <td></td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
