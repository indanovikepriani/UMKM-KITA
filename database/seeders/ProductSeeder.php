<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $stores = Store::all();
        $storeIds = $stores->pluck('id')->toArray();

        $products = [
            // Nasi & Lauk
            [
                'category_id' => 1,
                'name' => 'Nasi Goreng Spesial',
                'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar',
                'price' => 25000,
                'discount_price' => 20000,
                'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600',
                'stock' => 50,
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Nasi Uduk Komplit',
                'description' => 'Nasi uduk dengan lauk lengkap dan sambal khas',
                'price' => 20000,
                'image' => 'https://images.unsplash.com/photo-1596040033229-a0b68319f3be?w=600',
                'stock' => 40,
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Nasi Kuning Tumpeng Mini',
                'description' => 'Nasi kuning dengan lauk tradisional',
                'price' => 30000,
                'discount_price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=600',
                'stock' => 30,
            ],
            
            // Ayam & Bebek
            [
                'category_id' => 2,
                'name' => 'Ayam Geprek Sambal Matah',
                'description' => 'Ayam crispy dengan sambal matah pedas',
                'price' => 28000,
                'image' => 'https://images.unsplash.com/photo-1633964913295-ceb43826aed2?w=600',
                'stock' => 35,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Bebek Goreng Kremes',
                'description' => 'Bebek goreng dengan kremesan renyah',
                'price' => 35000,
                'discount_price' => 32000,
                'image' => 'https://images.unsplash.com/photo-1591952829582-4d4c6e1e7b5f?w=600',
                'stock' => 25,
            ],
            [
                'category_id' => 2,
                'name' => 'Ayam Bakar Madu',
                'description' => 'Ayam bakar dengan saus madu spesial',
                'price' => 30000,
                'image' => 'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=600',
                'stock' => 30,
            ],
            
            // Seafood
            [
                'category_id' => 3,
                'name' => 'Udang Saus Padang',
                'description' => 'Udang jumbo dengan saus padang pedas',
                'price' => 45000,
                'discount_price' => 40000,
                'image' => 'https://images.unsplash.com/photo-1559737558-2f5a640cf537?w=600',
                'stock' => 20,
                'is_featured' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Cumi Goreng Tepung',
                'description' => 'Cumi crispy dengan tepung bumbu',
                'price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=600',
                'stock' => 25,
            ],
            
            // Minuman
            [
                'category_id' => 4,
                'name' => 'Es Teh Manis',
                'description' => 'Teh manis segar dingin',
                'price' => 5000,
                'image' => 'https://images.unsplash.com/photo-1556881286-fc6915169721?w=600',
                'stock' => 100,
            ],
            [
                'category_id' => 4,
                'name' => 'Es Kelapa Muda',
                'description' => 'Kelapa muda segar langsung dari pohon',
                'price' => 15000,
                'discount_price' => 12000,
                'image' => 'https://images.unsplash.com/photo-1546173159-315724a31696?w=600',
                'stock' => 30,
            ],
            
            // Cemilan
            [
                'category_id' => 5,
                'name' => 'Pisang Goreng Crispy',
                'description' => 'Pisang goreng dengan coating crispy',
                'price' => 10000,
                'image' => 'https://images.unsplash.com/photo-1587133602925-c0a4b5c7e948?w=600',
                'stock' => 50,
            ],
            [
                'category_id' => 5,
                'name' => 'Tahu Isi Sayur',
                'description' => 'Tahu goreng isi sayuran dengan saus kacang',
                'price' => 12000,
                'image' => 'https://images.unsplash.com/photo-1599490659213-e2b9527bd087?w=600',
                'stock' => 40,
            ],
            // Additional Products
            [
                'category_id' => 1,
                'name' => 'Mie Goreng Spesial',
                'description' => 'Mie goreng dengan telur, sayuran, dan pilihan daging atau seafood',
                'price' => 22000,
                'discount_price' => 18000,
                'image' => 'https://images.unsplash.com/photo-1585961531776-b2651d7b57b4?w=600',
                'stock' => 45,
                'is_featured' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Sate Ayam Madura',
                'description' => 'Sate ayam dengan bumbu kacang khas Madura',
                'price' => 25000,
                'image' => 'https://images.unsplash.com/photo-1588184011318-0fc15c3e332a?w=600',
                'stock' => 30,
            ],
            [
                'category_id' => 3,
                'name' => 'Ikan Bakar Jimbaran',
                'description' => 'Ikan segar dibakar dengan bumbu khas Jimbaran',
                'price' => 40000,
                'discount_price' => 35000,
                'image' => 'https://images.unsplash.com/photo-1561580704-7c89427a67b8?w=600',
                'stock' => 20,
                'is_featured' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Jamu Kunir Asem',
                'description' => 'Minuman tradisional dari kunir dan asam jawa',
                'price' => 8000,
                'image' => 'https://images.unsplash.com/photo-1594736797933-d03d9ba55f22?w=600',
                'stock' => 60,
            ],
            [
                'category_id' => 5,
                'name' => 'Keripik Singkong',
                'description' => 'Singkong tipis digoreng hingga renyah',
                'price' => 8000,
                'image' => 'https://images.unsplash.com/photo-1579949801887-44bbf8b2244e?w=600',
                'stock' => 50,
            ],
        ];

        foreach ($products as $index => $product) {
            $storeId = $storeIds[$index % count($storeIds)];
            $store = $stores->firstWhere('id', $storeId);
            $product['store_id'] = $storeId;
            $product['umkm_name'] = $store->name;
            $product['umkm_address'] = $store->address;
            Product::create($product);
        }
    }
}