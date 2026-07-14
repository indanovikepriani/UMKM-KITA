<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Nasi & Lauk',
                'description' => 'Menu nasi dengan berbagai lauk pauk',
                'image' => 'https://images.unsplash.com/photo-1505253716362-afaea1d3d1af?w=400',
            ],
            [
                'name' => 'Ayam & Bebek',
                'description' => 'Olahan ayam dan bebek spesial',
                'image' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=400',
            ],
            [
                'name' => 'Seafood',
                'description' => 'Menu seafood segar pilihan',
                'image' => 'https://images.unsplash.com/photo-1559737558-2f5a640cf537?w=400',
            ],
            [
                'name' => 'Minuman',
                'description' => 'Minuman segar dan tradisional',
                'image' => 'https://images.unsplash.com/photo-1546173159-315724a31696?w=400',
            ],
            [
                'name' => 'Cemilan',
                'description' => 'Aneka cemilan dan snack',
                'image' => 'https://images.unsplash.com/photo-1599490659213-e2b9527bd087?w=400',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}