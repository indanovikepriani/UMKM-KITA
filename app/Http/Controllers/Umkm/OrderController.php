<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $store = Auth::user()->store;
        if (!$store) return redirect()->route('umkm.store.create');

        $query = Order::where('store_id', $store->id);

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);
        $pendingCount = Order::where('store_id', $store->id)->where('status', 'pending')->count();
        $processingCount = Order::where('store_id', $store->id)->where('status', 'processing')->count();

        return view('umkm.orders.index', compact('orders', 'store', 'pendingCount', 'processingCount'));
    }

    public function show(Order $order)
    {
        $store = Auth::user()->store;
        if (!$store || $order->store_id !== $store->id) {
            return redirect()->route('umkm.orders.index')->with('error', 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['items.product', 'user', 'payment']);
        return view('umkm.orders.show', compact('order', 'store'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $store = Auth::user()->store;
        if (!$store || $order->store_id !== $store->id) {
            return redirect()->route('umkm.orders.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'status' => 'required|in:processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Restore stock on cancellation
        if ($oldStatus !== 'cancelled' && $request->status === 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
