<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        if (!$store) return redirect()->route('umkm.store.create');

        $products = Product::where('store_id', $store->id)->latest()->paginate(12);
        return view('umkm.products.index', compact('products', 'store'));
    }

    public function create()
    {
        $store = Auth::user()->store;
        if (!$store) return redirect()->route('umkm.store.create')->with('error', 'Buat toko terlebih dahulu!');
        $categories = Category::all();
        return view('umkm.products.create', compact('store', 'categories'));
    }

    public function store(Request $request)
    {
        $store = Auth::user()->store;
        if (!$store) return redirect()->route('umkm.store.create');

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_price' => 'required|numeric|min:0',
            'price' => 'nullable|numeric|min:0|gt:discount_price',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['store_id'] = $store->id;
        $validated['umkm_name'] = $store->name;
        $validated['umkm_address'] = $store->address;
        $validated['is_available'] = true;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validated['image'] = 'images/products/' . $imageName;
        }

        Product::create($validated);

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $store = Auth::user()->store;
        if (!$store || $product->store_id !== $store->id) {
            return redirect()->route('umkm.products.index')->with('error', 'Anda tidak memiliki akses ke produk ini.');
        }
        $categories = Category::all();
        return view('umkm.products.edit', compact('product', 'store', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $store = Auth::user()->store;
        if (!$store || $product->store_id !== $store->id) {
            return redirect()->route('umkm.products.index')->with('error', 'Anda tidak memiliki akses ke produk ini.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'discount_price' => 'required|numeric|min:0',
            'price' => 'nullable|numeric|min:0|gt:discount_price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $validated['image'] = 'images/products/' . $imageName;
        }

        $product->update($validated);

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $store = Auth::user()->store;
        if (!$store || $product->store_id !== $store->id) {
            return redirect()->route('umkm.products.index')->with('error', 'Anda tidak memiliki akses ke produk ini.');
        }

        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
