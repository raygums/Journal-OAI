<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan database seeds.
     */
    public function run(): void
    {
        // Membuat satu akun admin default.
        // findOrCreateBy() akan mencari user dengan email ini,
        // jika tidak ada, maka akan membuatnya. Ini mencegah duplikasi.
        User::firstOrCreate(
    ['email' => 'admin@unila.ac.id'],
    [
        'name' => 'Admin Utama',
        'role' => 'admin', // <-- Tambahkan ini
        'password' => Hash::make('admin12345'),
            ]
        );
    }
}