<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeminjamanFactory extends Factory
{
    public function definition(): array
    {
        $tgl_pinjam = $this->faker->dateTimeBetween('-2 months', 'now');
        $tgl_jatuh_tempo = (clone $tgl_pinjam)->modify('+7 days');

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'buku_id' => Buku::inRandomOrder()->first()->id ?? Buku::factory(),
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_jatuh_tempo' => $tgl_jatuh_tempo,
            'status' => $this->faker->randomElement(['Pending','Disetujui','dipinjam','dikembalikan','Ditolak']),
            'persetujuan' => $this->faker->boolean(70), // 70% true
            'catatan' => $this->faker->optional()->sentence(),
        ];
    }
}
