<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = $this->getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name'    => 'required|string|max:255',
            'store_email'   => 'required|email|max:255',
            'store_phone'   => 'nullable|string|max:20',
            'store_address' => 'nullable|string',
            'store_description' => 'nullable|string|max:500',
            'currency'      => 'required|string|max:10',
            'tax_rate'      => 'required|numeric|min:0|max:100',
            'shipping_fee'  => 'required|numeric|min:0',
        ]);

        $path = storage_path('app/settings.json');
        $data = file_exists($path) ? json_decode(file_get_contents($path), true) : [];
        $data = array_merge($data, $validated);
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }

    private function getSettings()
    {
        $path = storage_path('app/settings.json');
        $defaults = [
            'store_name' => 'UMKM KITA',
            'store_email' => 'info@umkmkita.com',
            'store_phone' => '0812-3456-7890',
            'store_address' => 'Jl. Contoh No. 123, Kota',
            'store_description' => 'Platform UMKM terpercaya',
            'currency' => 'IDR',
            'tax_rate' => 10,
            'shipping_fee' => 10000,
        ];

        if (file_exists($path)) {
            $stored = json_decode(file_get_contents($path), true);
            return array_merge($defaults, $stored);
        }

        return $defaults;
    }
}
