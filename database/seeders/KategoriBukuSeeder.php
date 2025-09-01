<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriBuku;

class KategoriBukuSeeder extends Seeder
{
    public function run(): void
    {
        KategoriBuku::create([
            'kode' => 'KT001',
            'nama' => 'Pemrograman',
            'deskripsi' => 'Buku tentang pemrograman, coding, dan software development'
        ]);

        KategoriBuku::create([
            'kode' => 'KT002',
            'nama' => 'Mobile Development',
            'deskripsi' => 'Buku tentang Flutter, Android, dan iOS'
        ]);
    }
}
