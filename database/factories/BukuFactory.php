<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kode_buku'   => strtoupper($this->faker->bothify('BK-####')),
            'judul'       => $this->faker->sentence(3),
            'penulis'     => $this->faker->name,
            'penerbit'    => $this->faker->company,
            'tahun_terbit'=> $this->faker->date,
            'stok'        => $this->faker->numberBetween(1, 50),
            'gambar'      => null, // bisa diisi fake path kalau mau
            'kategori_id' => \App\Models\KategoriBuku::inRandomOrder()->value('id') ?? 1, // asumsi ada tabel kategori
        ];
    }
}
