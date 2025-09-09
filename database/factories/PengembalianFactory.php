<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengembalianFactory extends Factory
{
    public function definition(): array
    {
        $peminjaman = Peminjaman::inRandomOrder()->first();

        // Bikin kondisi random
        $kondisi = $this->faker->randomElement(['baik', 'telat', 'rusak', 'hilang']);
        
        // Tentukan hari telat (hanya kalau telat)
        $hari_telat = $kondisi === 'telat' ? $this->faker->numberBetween(1, 14) : null;

        return [
            'peminjaman_id' => $peminjaman?->id ?? Peminjaman::factory(),
            'user_id' => $peminjaman?->user_id ?? User::factory(),
            'tgl_kembali' => $this->faker->dateTimeBetween('-1 months', 'now'),
            'kondisi' => $kondisi,
            'hari_telat' => $hari_telat,
            'status' => $this->faker->randomElement(['menunggu', 'selesai']),
        ];
    }
}
