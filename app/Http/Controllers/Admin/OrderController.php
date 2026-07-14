<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Mail\OrderStatusUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan (penjualan) dengan filter status.
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        // Ringkasan penjualan
        $summary = [
            'total_orders'   => Order::count(),
            'total_revenue'  => Order::where('payment_status', 'paid')->sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_orders'   => Order::whereDate('created_at', today())->count(),
            'unpaid_orders'  => Order::where('payment_status', 'unpaid')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'summary'));
    }

    /**
     * Tampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'payment');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Tampilkan form edit pesanan.
     */
    public function edit(Order $order)
    {
        // Load relasi yang diperlukan untuk form edit
        $order->load('user', 'items.product');
        
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update status pesanan / status pembayaran / catatan admin.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status'         => ['required', 'in:pending,processing,completed,cancelled'],
            'payment_status' => ['required', 'in:unpaid,paid,refunded'],
            'notes'          => ['nullable', 'string'],
        ]);

        $oldStatus = $order->status;
        $oldPaymentStatus = $order->payment_status;
        $newStatus = $validated['status'];
        $newPaymentStatus = $validated['payment_status'];

        $order->update($validated);

        if ($order->payment && $newPaymentStatus !== $oldPaymentStatus) {
            $paymentStatusMap = [
                'paid'     => 'success',
                'unpaid'   => 'pending',
                'refunded' => 'refunded',
            ];
            $order->payment->update([
                'status' => $paymentStatusMap[$newPaymentStatus] ?? $order->payment->status,
            ]);
        }

        // Restore stock on cancellation or refund
        if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }
        if ($oldPaymentStatus !== 'refunded' && $newPaymentStatus === 'refunded') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        if ($oldStatus !== $newStatus && $order->user) {
            try {
                Mail::to($order->user->email)->send(new OrderStatusUpdate($order, $oldStatus, $newStatus));
            } catch (\Exception $e) {
                // Email gagal, tapi update sudah tersimpan
            }
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Pesanan #' . $order->order_number . ' berhasil diperbarui!');
    }
}