<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Buku;
use App\Models\Rak;
use App\Models\KategoriBuku;
use App\Models\Denda;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Card info untuk admin/petugas
        $cards = [
            ['title' => 'Buku', 'total' => Buku::count(), 'color' => 'primary', 'icon' => 'icon-buku.svg'],
            ['title' => 'Rak', 'total' => Rak::count(), 'color' => 'success', 'icon' => 'icon-rak-buku.svg'],
            ['title' => 'Kategori', 'total' => KategoriBuku::count(), 'color' => 'info', 'icon' => 'icon-kategori-buku.svg'],
            ['title' => 'Peminjaman', 'total' => Peminjaman::count(), 'color' => 'warning', 'icon' => 'icon-peminjaman.svg'],
            ['title' => 'Kembali', 'total' => Pengembalian::count(), 'color' => 'danger', 'icon' => 'icon-pengembalian-buku.svg'],
            ['title' => 'Denda', 'total' => Denda::sum('jumlah'), 'color' => 'secondary', 'icon' => 'icon-dd-invoice.svg'],
        ];

        // Chart untuk admin/petugas
        $bulanDefault = array_fill(1, 12, 0);
        $chartPeminjaman = array_replace(
            $bulanDefault,
            Peminjaman::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as total'))
                ->groupBy('bulan')
                ->pluck('total', 'bulan')
                ->toArray()
        );

        $chartPengembalian = array_replace(
            $bulanDefault,
            Pengembalian::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as total'))
                ->groupBy('bulan')
                ->pluck('total', 'bulan')
                ->toArray()
        );

        // 🔹 Dashboard User
        if ($user->role === 'user') {
    $jumlahDipinjam = Peminjaman::where('user_id', $user->id)->where('status', 'dipinjam')->count();
    $jumlahDikembalikan = Peminjaman::where('user_id', $user->id)->where('status', 'dikembalikan')->count();
    $totalDenda = Denda::whereHas('pengembalian.peminjaman', function ($q) use ($user) {
        $q->where('user_id', $user->id);
    })->sum('jumlah');

    $histori = Peminjaman::with('buku')->where('user_id', $user->id)->latest()->take(5)->get();

    // Chart data untuk user
    $bulanDefault = array_fill(1, 12, 0);
    $chartPeminjaman = array_replace(
        $bulanDefault,
        Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray()
    );

    $chartPengembalian = array_replace(
        $bulanDefault,
        Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->where('status', 'dikembalikan')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray()
    );

    // Pinjaman aktif
    $pinjaman = Peminjaman::with('buku')->where('user_id', $user->id)->where('status', 'dipinjam')->get();

    // Hitung tanggal jatuh tempo tiap buku
    $pinjaman->each(function($item) {
        $pinjam = \Carbon\Carbon::parse($item->created_at);
        $item->tanggal_jatuh_tempo = $pinjam->copy()->addDays(7)->endOfDay();
    });

    // Filter buku jatuh tempo
    $now = \Carbon\Carbon::now();
    $bukuAkanJatuhTempo = $pinjaman->filter(fn($item) => $item->tanggal_jatuh_tempo->greaterThanOrEqualTo($now));
    $bukuMingguIni = $bukuAkanJatuhTempo->filter(fn($item) => $item->tanggal_jatuh_tempo->between($now, $now->copy()->addWeek()));

    return view('dashboard.user', compact(
        'user',
        'jumlahDipinjam',
        'jumlahDikembalikan',
        'totalDenda',
        'histori',
        'pinjaman',
        'bukuAkanJatuhTempo',
        'bukuMingguIni',
        'chartPeminjaman',
        'chartPengembalian'
    ));
}


        // 🔹 Dashboard Admin / Petugas
        if ($user->role === 'admin') {
            return view('dashboard.admin', compact('user', 'cards', 'chartPeminjaman', 'chartPengembalian'));
        } elseif ($user->role === 'petugas') {
            return view('dashboard.petugas', compact('user', 'cards', 'chartPeminjaman', 'chartPengembalian'));
        }
    }
}
