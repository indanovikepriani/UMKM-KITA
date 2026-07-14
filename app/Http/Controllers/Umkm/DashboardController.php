<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            return view('umkm.no-store');
        }

        $totalProducts = Product::where('store_id', $store->id)->count();
        $totalOrders = Order::where('store_id', $store->id)->count();
        $pendingOrders = Order::where('store_id', $store->id)->where('status', 'pending')->count();
        $totalRevenue = Order::where('store_id', $store->id)->where('payment_status', 'paid')->sum('total');
        $recentOrders = Order::where('store_id', $store->id)->with('user')->latest()->limit(5)->get();

        return view('umkm.dashboard', compact('store', 'totalProducts', 'totalOrders', 'pendingOrders', 'totalRevenue', 'recentOrders'));
    }
}
