@extends('layouts.app')

@section('title', 'Lacak Pesanan - UMKM KITA')

@section('styles')
.tracking-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(62, 39, 35, 0.8)), url('{{ asset("images/hero/menu-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
@endsection

@section('content')
<header class="tracking-hero h-[40vh] flex items-center justify-center pt-20 text-center text-white">
    <div class="px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-4">Lacak Pesanan</h1>
        <p class="text-sm md:text-base font-light text-gray-200">Masukkan nomor pesanan untuk melacak status pengiriman</p>
    </div>
</header>

<main class="container mx-auto px-6 py-16 max-w-2xl">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
        <form action="{{ route('tracking.search') }}" method="GET" class="mb-8">
            <div class="flex gap-3">
                <input type="text" name="order_number" value="{{ request('order_number', $order->order_number ?? '') }}" 
                    placeholder="Masukkan nomor pesanan (contoh: ORD-...)" required
                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b] text-sm">
                <button type="submit" class="bg-[#8b5a2b] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#6f4620] transition text-sm">
                    Lacak
                </button>
            </div>
            @error('order_number')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </form>

        @if(isset($order))
        <div class="border-t border-gray-100 pt-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Nomor Pesanan</p>
                    <p class="font-bold text-gray-800">{{ $order->order_number }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $order->status_color }}">{{ $order->status_label }}</span>
            </div>

            @if($order->store)
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Toko</p>
                <p class="font-semibold text-gray-800">{{ $order->store->name }}</p>
            </div>
            @endif

            <div class="order-timeline mb-6">
                <div class="timeline-item completed">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Pesanan Dibuat</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="timeline-item {{ $order->payment_status == 'paid' ? 'completed' : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Pembayaran</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->payment_status == 'paid' ? 'Pembayaran diterima' : 'Menunggu pembayaran' }}</p>
                    </div>
                </div>
                <div class="timeline-item {{ in_array($order->status, ['processing', 'completed']) ? ($order->status == 'completed' ? 'completed' : 'active') : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Diproses</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ in_array($order->status, ['processing', 'completed']) ? 'Sedang diproses' : 'Menunggu diproses' }}</p>
                    </div>
                </div>
                <div class="timeline-item {{ $order->status == 'completed' ? 'completed' : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Selesai</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->status == 'completed' ? 'Pesanan selesai' : 'Belum selesai' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#f4eee6] rounded-xl p-4">
                <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Rincian</p>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $item->product_name }} x{{ $item->quantity }}</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                    <hr class="border-gray-200">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Pajak</span>
                        <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Ongkir</span>
                        <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between font-bold">
                        <span>Total</span>
                        <span class="text-[#8b5a2b]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @elseif(request('order_number'))
        <div class="text-center py-8">
            <div class="text-5xl mb-4">🔍</div>
            <h3 class="font-bold text-gray-800 mb-2">Pesanan Tidak Ditemukan</h3>
            <p class="text-gray-500 text-sm">Pastikan nomor pesanan yang Anda masukkan sudah benar.</p>
        </div>
        @else
        <div class="text-center py-8">
            <div class="text-5xl mb-4">📦</div>
            <h3 class="font-bold text-gray-800 mb-2">Masukkan Nomor Pesanan</h3>
            <p class="text-gray-500 text-sm">Nomor pesanan bisa Anda temukan di email konfirmasi atau halaman "Pesanan Saya".</p>
        </div>
        @endif
    </div>
</main>
@endsection
