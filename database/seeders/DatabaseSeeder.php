<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriBukuSeeder::class,
            BukuSeeder::class,
            PeminjamanSeeder::class,
            PengembalianSeeder::class,
            DendaSeeder::class,
            RakSeeder::class,
        ]);
    }
}
