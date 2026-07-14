<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking');
    }

    public function search(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
        ]);

        $order = Order::with(['items', 'store', 'payment'])
            ->where('order_number', $request->order_number)
            ->first();

        if (!$order) {
            return back()->withErrors(['order_number' => 'Nomor pesanan tidak ditemukan.']);
        }

        return view('tracking', compact('order'));
    }
}
