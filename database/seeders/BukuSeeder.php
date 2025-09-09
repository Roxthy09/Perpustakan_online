<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        Buku::create([
            'kode_buku' => 'BK001',
            'judul' => 'Pemrograman Laravel',
            'kategori_id' => 1,
            'penulis' => 'Robben Wijaya',
            'penerbit' => 'Tekno Press',
            'tahun_terbit' => '2022-05-15',
            'stok' => 5
        ]);

        Buku::create([
            'kode_buku' => 'BK002',
            'judul' => 'Flutter untuk Pemula',
            'kategori_id' => 2,
            'penulis' => 'Budi Santoso',
            'penerbit' => 'Mobile Press',
            'tahun_terbit' => '2023-03-10',
            'stok' => 3
        ]);

        Buku::factory()->count(30)->create();
    }
}
