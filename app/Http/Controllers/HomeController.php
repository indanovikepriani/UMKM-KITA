<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->featured()
            ->available()
            ->take(8)
            ->get();

        $categories = Category::active()->get();
        
        $testimonials = Review::with(['user', 'product'])
            ->approved()
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'categories', 'testimonials'));
    }

    public function about()
    {
        return view('about');
    }
}