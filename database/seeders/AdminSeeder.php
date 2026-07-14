<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin UMKM KITA',
            'email' => 'admin@umkmkita.com',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'address' => 'Jl. Raya UMKM No. 123, Jakarta',
            'role' => 'admin',
        ]);

        // Customer demo
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'customer@test.com',
            'password' => Hash::make('customer123'),
            'phone' => '081987654321',
            'address' => 'Jl. Pelanggan No. 456, Bandung',
            'role' => 'customer',
        ]);
    }
}