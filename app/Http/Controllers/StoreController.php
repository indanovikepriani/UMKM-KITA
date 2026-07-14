<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::where('is_active', true);

        if ($request->has('area') && $request->area !== '') {
            $query->where('area', $request->area);
        }

        if ($request->has('search') && $request->search !== '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $stores = $query->latest()->paginate(12);
        $areas = Store::where('is_active', true)->distinct()->pluck('area')->sort()->values();

        return view('stores.index', compact('stores', 'areas'));
    }

    public function show($slug)
    {
        $store = Store::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $products = $store->products()->where('is_available', true)->latest()->paginate(12);

        return view('stores.show', compact('store', 'products'));
    }
}
