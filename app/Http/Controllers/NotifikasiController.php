<?php
namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin' || $user->role === 'petugas') {
            // Admin & petugas: notif kalau ada peminjaman baru
            $notifications = Peminjaman::with(['user', 'buku'])
                ->where('status', 'pending')
                ->latest()
                ->take(10)
                ->get();
        } elseif ($user->role === 'user') {
            // User: notif kalau peminjamannya disetujui
            $notifications = Peminjaman::with(['buku'])
                ->where('user_id', $user->id)
                ->where('status', 'disetujui')
                ->latest()
                ->take(10)
                ->get();
        } else {
            $notifications = collect();
        }

        $unreadCount = $notifications->count();

        // kalau kamu mau JSON (untuk fetch/AJAX)
        return response()->json([
            'unreadCount'   => $unreadCount,
            'role'          => $user->role,
            'notifications' => $notifications,
        ]);

        // atau kalau mau langsung Blade
        // return view('partials.notification', compact('notifications', 'unreadCount'));
    }
}
