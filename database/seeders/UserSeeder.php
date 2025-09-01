<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Perpus',
            'email' => 'admin@perpus.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Petugas Perpus',
            'email' => 'petugas@perpus.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        User::create([
            'name' => 'Siswa 1',
            'email' => 'siswa1@perpus.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
