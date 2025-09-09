<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denda;

class DendaSeeder extends Seeder
{
    public function run(): void
    {
        Denda::create([
            'pengembalian_id' => 1, // Pengembalian dari Loan 1
            'jumlah' => 15000,
            'status' => 'belum_bayar'
        ]);

        Denda::factory()->count(20)->create();
    }
}
