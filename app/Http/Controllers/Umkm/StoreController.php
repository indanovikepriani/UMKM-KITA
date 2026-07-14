<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        return view('umkm.store.index', compact('store'));
    }

    public function create()
    {
        return view('umkm.store.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'min_order' => 'nullable|integer|min:0',
            'delivery_radius' => 'nullable|integer|min:1',
            'estimated_time' => 'nullable|integer|min:5',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['user_id'] = Auth::id();

        // Operating hours defaults
        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        $hours = [];
        foreach ($days as $day) {
            $hours[$day] = $request->input("hours_{$day}", '08:00-22:00');
        }
        $validated['operating_hours'] = $hours;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/stores'), $imageName);
            $validated['image'] = 'images/stores/' . $imageName;
        }

        $store = Store::create($validated);

        return redirect()->route('umkm.store.index')->with('success', 'Toko berhasil dibuat!');
    }

    public function edit()
    {
        $store = Auth::user()->store;
        if (!$store) return redirect()->route('umkm.store.create');
        return view('umkm.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;
        if (!$store) return redirect()->route('umkm.store.create');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'min_order' => 'nullable|integer|min:0',
            'delivery_radius' => 'nullable|integer|min:1',
            'estimated_time' => 'nullable|integer|min:5',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        $hours = [];
        foreach ($days as $day) {
            $hours[$day] = $request->input("hours_{$day}", $store->operating_hours[$day] ?? '08:00-22:00');
        }
        $validated['operating_hours'] = $hours;
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($store->image && file_exists(public_path($store->image))) {
                unlink(public_path($store->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/stores'), $imageName);
            $validated['image'] = 'images/stores/' . $imageName;
        }

        $store->update($validated);

        return redirect()->route('umkm.store.index')->with('success', 'Toko berhasil diperbarui!');
    }
}
