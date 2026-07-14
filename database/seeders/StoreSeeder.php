<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        // Create a UMKM user
        $umkmUser = User::create([
            'name' => 'Warung Bu Sari',
            'email' => 'umsari@umkm.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
        ]);

        $store = Store::create([
            'name' => 'Warung Bu Sari',
            'slug' => 'warung-bu-sari',
            'description' => 'Warung makan tradisional dengan cita rasa khas Melayu Batam. Sudah berdiri sejak 2015.',
            'address' => 'Jl. Engku Putri No. 15',
            'area' => 'Batam Centre',
            'phone' => '081234567890',
            'whatsapp' => '6281234567890',
            'operating_hours' => [
                'mon' => '08:00-22:00',
                'tue' => '08:00-22:00',
                'wed' => '08:00-22:00',
                'thu' => '08:00-22:00',
                'fri' => '08:00-22:00',
                'sat' => '09:00-21:00',
                'sun' => '10:00-20:00',
            ],
            'min_order' => 25000,
            'delivery_radius' => 5,
            'estimated_time' => 25,
            'is_active' => true,
            'is_featured' => true,
            'user_id' => $umkmUser->id,
        ]);

        // Second store
        $umkmUser2 = User::create([
            'name' => 'Kedai Pak Budi',
            'email' => 'budi@umkm.com',
            'password' => bcrypt('password'),
            'role' => 'umkm',
        ]);

        Store::create([
            'name' => 'Kedai Pak Budi',
            'slug' => 'kedai-pak-budi',
            'description' => 'Kedai kopi dan snack ringan. Tempat nongkrong asik dengan wifi gratis.',
            'address' => 'Jl. Nagoya Plaza No. 8',
            'area' => 'Nagoya',
            'phone' => '081298765432',
            'whatsapp' => '6281298765432',
            'operating_hours' => [
                'mon' => '07:00-23:00',
                'tue' => '07:00-23:00',
                'wed' => '07:00-23:00',
                'thu' => '07:00-23:00',
                'fri' => '07:00-23:00',
                'sat' => '08:00-23:00',
                'sun' => '08:00-22:00',
            ],
            'min_order' => 15000,
            'delivery_radius' => 3,
            'estimated_time' => 20,
            'is_active' => true,
            'is_featured' => true,
            'user_id' => $umkmUser2->id,
        ]);
    }
}
