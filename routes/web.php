<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\KategoriBukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NotifikasiController;

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
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::resource('users', UserController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('rak', RakController::class);
    Route::resource('kategori_buku', KategoriBukuController::class);

    // Peminjaman hanya untuk monitoring, user yg buat
    Route::resource('peminjaman', PeminjamanController::class)->except(['create', 'store', 'edit', 'update']);
    Route::put('peminjaman/{peminjaman}/konfirmasi', [PeminjamanController::class, 'konfirmasi'])->name('peminjaman.konfirmasi');

    Route::resource('pengembalian', PengembalianController::class);
    Route::post('/pengembalian/konfirmasi-denda/{pengembalian}', [PengembalianController::class, 'konfirmasiDenda'])->name('pengembalian.konfirmasi-denda');

    Route::resource('denda', DendaController::class);
    Route::post('denda/{denda}/konfirmasi', [DendaController::class, 'konfirmasi'])->name('denda.konfirmasi');
    Route::get('denda/export/pdf', [DendaController::class, 'exportPdf'])->name('denda.export.pdf');
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact', [ContactController::class, 'send']);
});

/*
|--------------------------------------------------------------------------
| User (hanya bisa lihat / ajukan peminjaman)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    // Buku
    Route::get('buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    // Rak
    Route::get('rak', [RakController::class, 'index'])->name('rak.index');
    Route::get('rak/{rak}', [RakController::class, 'show'])->name('rak.show');

    // Kategori
    Route::get('kategori_buku', [KategoriBukuController::class, 'index'])->name('kategori_buku.index');
    Route::get('kategori_buku/{kategori_buku}', [KategoriBukuController::class, 'show'])->name('kategori_buku.show');

    // Peminjaman (user bisa ajukan & lihat status)
    Route::get('peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::get('peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');

    Route::put('peminjaman/{peminjaman}/ambil', [PeminjamanController::class, 'ambil'])->name('peminjaman.ambil');
    Route::put('peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');

    // Pengembalian
    Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('pengembalian/{pengembalian}', [PengembalianController::class, 'show'])->name('pengembalian.show');

    // Denda
    Route::get('denda', [DendaController::class, 'index'])->name('denda.index');
    Route::get('denda/{denda}', [DendaController::class, 'show'])->name('denda.show');
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
});

/*
|--------------------------------------------------------------------------
| Logout (global)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Google Login
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotifikasiController::class, 'index'])
    ->name('notifications.index');
