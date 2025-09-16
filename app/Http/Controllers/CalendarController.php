<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        // contoh data event (nanti bisa diambil dari tabel peminjaman/pengembalian)
        $events = [
            [
                'title' => 'Pengembalian Buku - Budi',
                'start' => '2025-09-20',
                'end'   => '2025-09-20',
                'color' => '#dc3545',
            ],
            [
                'title' => 'Peminjaman Buku - Ani',
                'start' => '2025-09-22',
                'color' => '#28a745',
            ],
        ];

        return view('calendar.index', compact('events'));
    }
}
