<?php

namespace Database\Factories;

use App\Models\Pengembalian;
use Illuminate\Database\Eloquent\Factories\Factory;

class DendaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pengembalian_id' => Pengembalian::inRandomOrder()->value('id') ?? Pengembalian::factory(),
            'jumlah' => $this->faker->randomFloat(2, 1000, 50000), // antara 1 ribu s/d 50 ribu
            'keterangan' => $this->faker->randomElement([
                'Telat mengembalikan',
                'Buku rusak',
                'Buku hilang',
                'Denda tambahan'
            ]),
            'status' => $this->faker->randomElement(['belum_bayar', 'sudah_bayar']),
        ];
    }
}
