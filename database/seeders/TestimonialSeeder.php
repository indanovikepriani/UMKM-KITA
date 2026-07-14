<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $customer = User::where('role', 'customer')->first();

        $testimonials = [
            [
                'user_id' => $customer->id,
                'rating' => 5,
                'comment' => 'Makanannya enak banget! Delivery juga cepat. Pasti order lagi!',
                'is_approved' => true,
            ],
            [
                'user_id' => $customer->id,
                'rating' => 5,
                'comment' => 'Nasi gorengnya juara, porsi besar dan harga terjangkau. Recommended!',
                'is_approved' => true,
            ],
            [
                'user_id' => $customer->id,
                'rating' => 4,
                'comment' => 'Ayam gepreknya mantap, sambalnya pedas pas. Cuma agak lama deliverynya.',
                'is_approved' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}