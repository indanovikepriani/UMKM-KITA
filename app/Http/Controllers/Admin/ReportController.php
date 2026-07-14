<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Carbon;
use DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. PERBAIKAN: Menggunakan YEAR() untuk MySQL, bukan strftime()
        $years = Order::selectRaw('YEAR(created_at) as year')
                      ->distinct()
                      ->orderBy('year', 'desc')
                      ->pluck('year');

        // 2. Siapkan query dasar (Ambil pesanan yang sudah selesai saja untuk laporan pendapatan)
        $query = Order::with('user')->where('status', 'completed');

        // 3. Filter berdasarkan Bulan jika dipilih
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 4. Filter berdasarkan Tahun jika dipilih
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 5. Eksekusi query
        $orders = $query->orderBy('created_at', 'desc')->get();
        $totalRevenue = $orders->sum('total');

        // 6. Jika tombol "Cetak" ditekan (ada parameter print=true di URL)
        if ($request->has('print')) {
            return view('admin.reports.print', compact('orders', 'totalRevenue', 'request'));
        }

        // 7. Tampilkan halaman laporan biasa
        return view('admin.reports.index', compact('orders', 'years', 'totalRevenue', 'request'));
    }

    public function sales(Request $request)
    {
        // Sales report is essentially the same as the general report index
        // 1. PERBAIKAN: Menggunakan YEAR() untuk MySQL, bukan strftime()
        $years = Order::selectRaw('YEAR(created_at) as year')
                      ->distinct()
                      ->orderBy('year', 'desc')
                      ->pluck('year');

        // 2. Siapkan query dasar (Ambil pesanan yang sudah selesai saja untuk laporan pendapatan)
        $query = Order::with('user')->where('status', 'completed');

        // 3. Filter berdasarkan Bulan jika dipilih
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 4. Filter berdasarkan Tahun jika dipilih
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 5. Eksekusi query
        $orders = $query->orderBy('created_at', 'desc')->get();
        $totalRevenue = $orders->sum('total');

        // 6. Jika tombol "Cetak" ditekan (ada parameter print=true di URL)
        if ($request->has('print')) {
            return view('admin.reports.print', compact('orders', 'totalRevenue', 'request'));
        }

        // 7. Tampilkan halaman laporan penjualan
        return view('admin.reports.index', compact('orders', 'years', 'totalRevenue', 'request'));
    }

    public function stock(Request $request)
    {
        // Ambil semua produk dengan relasi kategori
        $products = Product::with('category')->get();
        
        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Terapkan filter kategori jika dipilih
        if ($request->filled('category_id')) {
            $products = $products->where('category_id', $request->category_id);
        }

        // Terapkan filter tingkat stok jika dipilih
        if ($request->filled('stock_level')) {
            switch ($request->stock_level) {
                case 'out_of_stock':
                    $products = $products->where('stock', 0);
                    break;
                case 'low_stock':
                    $products = $products->whereBetween('stock', [1, 9]);
                    break;
                case 'normal':
                    $products = $products->where('stock', '>=', 10);
                    break;
            }
        }

        // Hitung statistik stok setelah filter
        $totalProducts = $products->count();
        $lowStockProducts = $products->filter(function ($product) {
            return $product->stock > 0 && $product->stock < 10; // Stok rendah: kurang dari 10
        })->count();
        $outOfStockProducts = $products->filter(function ($product) {
            return $product->stock == 0;
        })->count();
        $totalInventoryValue = $products->sum(function ($product) {
            return $product->stock * $product->discount_price;
        });

        // Jika tombol "Cetak" ditekan (ada parameter print=true di URL)
        if ($request->has('print')) {
            return view('admin.reports.stock-print', compact(
                'products',
                'totalProducts',
                'lowStockProducts',
                'outOfStockProducts',
                'totalInventoryValue',
                'request'
            ));
        }

        // Tampilkan halaman laporan stok biasa
        return view('admin.reports.stock', compact(
            'products',
            'categories',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalInventoryValue',
            'request'
        ));
    }

    public function monthly(Request $request)
    {
        // 1. PERBAIKAN: Menggunakan YEAR() untuk MySQL, bukan strftime()
        $years = Order::selectRaw('YEAR(created_at) as year')
                      ->distinct()
                      ->orderBy('year', 'desc')
                      ->pluck('year');

        // 2. Siapkan query dasar (Ambil pesanan yang sudah selesai saja untuk laporan pendapatan)
        $query = Order::with('user')->where('status', 'completed');

        // 3. Filter berdasarkan Bulan jika dipilih
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        // 4. Filter berdasarkan Tahun jika dipilih
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // 5. Eksekusi query
        $orders = $query->orderBy('created_at', 'desc')->get();
        $totalRevenue = $orders->sum('total');

        // 6. Jika tombol "Cetak" ditekan (ada parameter print=true di URL)
        if ($request->has('print')) {
            return view('admin.reports.print', compact('orders', 'totalRevenue', 'request'));
        }

        // 7. Tampilkan halaman laporan bulanan
        return view('admin.reports.index', compact('orders', 'years', 'totalRevenue', 'request'));
    }
}