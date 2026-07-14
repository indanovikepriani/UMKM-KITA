<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wishlists = $user->wishlists()->with('product.store')->latest()->get();

        return view('wishlists.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = auth()->user();
        $productId = $request->product_id;

        $existing = $user->wishlists()->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Produk dihapus dari favorit.');
        }

        $user->wishlists()->create(['product_id' => $productId]);
        return back()->with('success', 'Produk ditambahkan ke favorit!');
    }
}
