<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat satu pengguna untuk keperluan pengujian
        User::create([
            'name' => 'Pengelola',
            'email' => 'pengelola@unila.ac.id',
            'password' => Hash::make('password'), // Password dienkripsi
        ]);
    }
}