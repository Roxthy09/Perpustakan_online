<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Peminjaman;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         Paginator::useBootstrapFive();

          View::composer('*', function ($view) {
        if (auth()->check()) {
            // Ambil peminjaman yang masih pending (belum dikonfirmasi)
            $notifications = Peminjaman::with('user', 'buku')
                ->where('status', 'pending')
                ->latest()
                ->take(5) // tampilkan 5 terakhir
                ->get();

            $unreadCount = $notifications->count();

            $view->with([
                'notifications' => $notifications,
                'unreadCount'   => $unreadCount,
            ]);
        }
    });
    }
}
