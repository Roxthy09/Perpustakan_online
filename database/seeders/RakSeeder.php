<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RakSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('raks')->insert([
            [
                'kode_rak' => 'A1',
                'nama_rak' => 'Fiksi & Agama',
                'lokasi'   => 'Lantai 1 - Kiri',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_rak' => 'B1',
                'nama_rak' => 'Sains & Teknologi',
                'lokasi'   => 'Lantai 1 - Kanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
