<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\Auth\GoogleController;



/*
|--------------------------------------------------------------------------
| Default
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);

Auth::routes();

/*
|--------------------------------------------------------------------------
| Dashboard untuk semua role
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin & Petugas (akses penuh)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::resource('buku', BukuController::class);
    Route::resource('rak', RakController::class);
    Route::resource('kategori_buku', KategoriBukuController::class);
    Route::resource('peminjaman', PeminjamanController::class)->except(['ambil', 'kembalikan','create','store','edit','update']);
    Route::put('peminjaman/{peminjaman}/konfirmasi', [PeminjamanController::class, 'konfirmasi'])->name('peminjaman.konfirmasi');
    Route::resource('pengembalian', PengembalianController::class);
     Route::resource('denda', DendaController::class); // Jika ada fitur denda
});

/*
|--------------------------------------------------------------------------
| User (hanya bisa lihat / index & show)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    // Buku
    Route::get('buku', [BukuController::class, 'index'])->name('user.buku.index');
    Route::get('buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    // Rak
    Route::get('rak', [RakController::class, 'index'])->name('user.rak.index');
    Route::get('rak/{rak}', [RakController::class, 'show'])->name('user.rak.show');

    // Kategori
    Route::get('kategori_buku', [KategoriBukuController::class, 'index'])->name('user.kategori_buku.index');
    Route::get('kategori_buku/{kategori_buku}', [KategoriBukuController::class, 'show'])->name('user.kategori_buku.show');

    // Peminjaman (lihat status pinjaman)
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('user.peminjaman.index');
    Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::put('peminjaman/{peminjaman}/ambil', [PeminjamanController::class, 'ambil'])->name('user.peminjaman.ambil');
    Route::put('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('user.peminjaman.kembalikan');
    Route::get('peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('user.peminjaman.show');

    // Pengembalian (lihat status pengembalian)
    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('user.pengembalian.index');
    Route::get('pengembalian/{pengembalian}', [PengembalianController::class, 'show'])->name('pengembalian.show');

    // Denda (lihat denda)
    Route::get('denda', [DendaController::class, 'index'])->name('user.denda.index');
    Route::get('denda/{denda}', [DendaController::class, 'show'])->name('denda.show');
    Route::post('denda/{denda}/konfirmasi', [DendaController::class, 'konfirmasi'])->name('denda.konfirmasi');
    Route::get('denda/export/pdf', [DendaController::class, 'exportPdf'])->name('denda.export.pdf');});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
