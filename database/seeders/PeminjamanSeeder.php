<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        Peminjaman::create([
            'user_id' => 3, // Siswa 1
            'buku_id' => 1, // Buku Laravel
            'tgl_pinjam' => now()->subDays(7),
            'tgl_jatuh_tempo' => now()->subDays(2),
            'status' => 'dipinjam'
        ]);

        Peminjaman::create([
            'user_id' => 3, // Siswa 1
            'buku_id' => 2, // Buku Flutter
            'tgl_pinjam' => now()->subDays(3),
            'tgl_jatuh_tempo' => now()->addDays(4),
            'status' => 'dipinjam'
        ]);
    }
}
