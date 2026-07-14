<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with('product')->get();
        
        return view('cart', compact('cart', 'cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255', // Validasi note
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = $this->getOrCreateCart();

        // Cek apakah produk dengan catatan yang SAMA sudah ada di keranjang
        $query = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id);
        if ($request->note) {
            $query->where('note', $request->note);
        } else {
            $query->whereNull('note');
        }
        $cartItem = $query->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi!');
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'note' => $request->note, // Simpan note
                'price' => $product->final_price,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $cartItem = CartItem::where('id', $id)->where('cart_id', $cart->id)->first();
        if (!$cartItem) {
            return back()->with('error', 'Item keranjang tidak ditemukan!');
        }

        if ($cartItem->product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Keranjang berhasil diupdate!');
    }

    public function remove($id)
    {
        $cart = $this->getOrCreateCart();
        $cartItem = CartItem::where('id', $id)->where('cart_id', $cart->id)->first();
        if (!$cartItem) {
            return back()->with('error', 'Item keranjang tidak ditemukan!');
        }
        $cartItem->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    private function getOrCreateCart()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        return $cart;
    }
}