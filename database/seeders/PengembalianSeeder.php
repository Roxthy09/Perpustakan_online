<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengembalian;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        Pengembalian::create([
            'user_id' => 3,
            'peminjaman_id' => 1, // Peminjaman Laravel
            'tgl_kembali' => now(),
        ]);
    }
}
