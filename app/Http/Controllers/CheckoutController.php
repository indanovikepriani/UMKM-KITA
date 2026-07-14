<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    private function getSettings()
    {
        $path = storage_path('app/settings.json');
        $defaults = ['tax_rate' => 10, 'shipping_fee' => 10000];
        if (file_exists($path)) {
            $stored = json_decode(file_get_contents($path), true);
            return array_merge($defaults, $stored);
        }
        return $defaults;
    }

    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        $cartItems = $cart->items()->with('product')->get();

        $settings = $this->getSettings();
        $subtotal = $cart->total;
        $taxRate = $settings['tax_rate'] / 100;
        $tax = $subtotal * $taxRate;
        $deliveryFee = $settings['shipping_fee'];
        $total = $subtotal + $tax + $deliveryFee;

        return view('checkout', compact('cart', 'cartItems', 'subtotal', 'tax', 'deliveryFee', 'total', 'taxRate'));
    }

    public function process(Request $request)
    {
        // 1. VALIDASI DATA MASUKAN
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'delivery_option' => 'required|in:kurir,pickup',
            'payment_method' => 'required|in:transfer,qris,cod',
            'address' => 'required_if:delivery_option,kurir|nullable|string',
            'notes' => 'nullable|string',
            'schedule_date' => 'nullable|date|after_or_equal:today',
            'schedule_time' => 'nullable|required_with:schedule_date|date_format:H:i',
        ]);

        // 2. CEK KEMBALI KETERSEDIAAN KERANJANG
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }

        // 3. LOGIKA BLOKIR: Jika ambil sendiri (pickup), tidak boleh pilih COD
        if ($request->delivery_option === 'pickup' && $request->payment_method === 'cod') {
            return back()->withInput()->with('error', 'Metode pembayaran COD tidak diperbolehkan jika Anda mengambil pesanan sendiri!');
        }

        DB::beginTransaction();

        try {
            // 4. HITUNG NOMINAL DINAMIS BERDASARKAN SETTINGS & OPSI PENGIRIMAN
            $settings = $this->getSettings();
            $subtotal = $cart->total;
            $taxRate = $settings['tax_rate'] / 100;
            $tax = $subtotal * $taxRate;
            $deliveryFee = ($request->delivery_option === 'pickup') ? 0 : $settings['shipping_fee'];
            $total = $subtotal + $tax + $deliveryFee;

            // Hitung scheduled_at jika ada
            $scheduledAt = null;
            if ($request->filled('schedule_date') && $request->filled('schedule_time')) {
                $scheduledAt = $request->schedule_date . ' ' . $request->schedule_time . ':00';
            }

            // Ambil store_id dari produk pertama di cart
            $firstCartItem = $cart->items()->with('product')->first();
            $firstProduct = $firstCartItem?->product ?? null;
            $storeId = $firstProduct?->store_id ?? null;

            // Validate all cart items belong to the same store
            if ($storeId) {
                $differentStoreItems = $cart->items()->with('product')->get()
                    ->filter(fn($item) => $item->product && $item->product->store_id !== $storeId);
                if ($differentStoreItems->isNotEmpty()) {
                    DB::rollBack();
                    return back()->with('error', 'Semua produk dalam keranjang harus dari toko yang sama. Silakan checkout produk satu per toko.');
                }
            }

            // 5. BUAT DATA ORDER Baru
            $order = Order::create([
                'user_id' => Auth::id(),
                'store_id' => $storeId,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_address' => ($request->delivery_option === 'pickup') ? 'Ambil Sendiri di Lokasi UMKM' : $request->address,
                'phone' => $request->phone,
                'notes' => $request->notes,
                'scheduled_at' => $scheduledAt,
            ]);

            // 6. PINDAHKAN ITEM KERANJANG KE ORDER ITEMS & POTONG STOK
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product?->name ?? 'Produk Tidak Ditemukan',
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);

                // Mengurangi stok produk secara otomatis
                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // 7. BUAT REKORD PEMBAYARAN
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $total,
                'status' => 'pending',
            ]);

            // 8. BERSIHKAN KERANJANG BELANJA
            $cart->items()->delete();

            DB::commit();

            // 9. KIRIM EMAIL KONFIRMASI
            try {
                Mail::to($order->user->email)->send(new OrderConfirmation($order));
            } catch (\Exception $e) {
                // Email gagal dikirim, tapi order sudah terdaftar
            }

            // 10. REDIRECT KE HALAMAN SUCCESS (anti duplicate order on refresh)
            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran sesuai instruksi pada detail pesanan.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}