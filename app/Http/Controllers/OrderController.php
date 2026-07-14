<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product', 'payment'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    /**
     * User/customer membatalkan pesanan miliknya sendiri.
     * Stok produk yang sudah dipesan akan dikembalikan,
     * dan pesanan tetap tersimpan (beserta item-itemnya) agar
     * admin bisa memantau riwayat & belanjaan yang dibatalkan.
     */
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->findOrFail($id);

        if (!in_array($order->status, ['pending', 'processing'])) {
            return back()->with('error', 'Pesanan ini sudah tidak bisa dibatalkan.');
        }

        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Pesanan #' . $order->order_number . ' berhasil dibatalkan.');
    }
}