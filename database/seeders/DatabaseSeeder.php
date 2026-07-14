<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}