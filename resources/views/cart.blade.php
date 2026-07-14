@extends('layouts.app')
@section('title', 'Keranjang - UMKM KITA')
@section('styles')
.glass-panel {
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.5);
}
@endsection
@section('content')
<main class="flex-grow container mx-auto px-4 pt-32 pb-12 max-w-6xl">

    <div class="mb-8">
        <h1 class="text-3xl font-bold serif-font text-gray-800">Keranjang Belanja</h1>
        <p class="text-gray-500 text-sm mt-1">Periksa kembali pesanan Anda sebelum melanjutkan ke pembayaran.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-sm text-green-700 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-sm text-red-700 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="flex flex-col lg:flex-row gap-8">

            <div class="w-full lg:w-2/3 space-y-4">
                @foreach($cartItems as $item)
                <div class="glass-panel p-4 rounded-2xl shadow-sm flex flex-col sm:flex-row items-center gap-4 border border-gray-100 transition hover:shadow-md">

                    <div class="w-24 h-24 rounded-full border-2 border-[#d2b48c] overflow-hidden flex-shrink-0">
                        <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                    </div>

                    <div class="flex-grow text-center sm:text-left">
                        <h3 class="text-lg font-bold text-gray-800">{{ $item->product->name }}</h3>
                        <p class="text-[#8b5a2b] font-semibold text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>

                    <div class="flex items-center gap-4 mt-4 sm:mt-0">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center bg-gray-50 rounded-full border border-gray-200 p-1">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                class="w-16 bg-transparent text-center text-sm font-semibold outline-none text-gray-700" onchange="this.form.submit()">
                        </form>

                        <div class="font-bold text-gray-800 w-24 text-right">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>

                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition" title="Hapus">
                                ✕
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-32">
                    <h3 class="text-xl font-bold serif-font text-gray-800 mb-6 border-b pb-4">Ringkasan Belanja</h3>

                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span>Total Item</span>
                            <span class="font-medium">{{ $cart->total_items }} Porsi</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-400">
                            <span>*Pajak & Ongkir dihitung saat checkout</span>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-gray-800">Total Sementara</span>
                            <span class="text-xl font-bold text-[#8b5a2b]">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="block w-full bg-[#3e2723] text-white text-center py-4 rounded-xl font-semibold hover:bg-black transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-200">
                        Lanjut ke Pembayaran ➔
                    </a>

                    <a href="{{ route('menu.index') }}" class="block w-full text-center mt-4 text-sm text-[#8b5a2b] font-medium hover:underline">
                        + Tambah Menu Lain
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white p-12 rounded-3xl shadow-sm border border-gray-100 text-center max-w-2xl mx-auto mt-8">
            <div class="text-6xl mb-6 opacity-50">🛒</div>
            <h2 class="text-2xl font-bold serif-font text-gray-800 mb-2">Keranjang Masih Kosong</h2>
            <p class="text-gray-500 text-sm mb-8">Wah, belum ada hidangan yang kamu pilih. Yuk, cari menu favoritmu sekarang!</p>
            <a href="{{ route('menu.index') }}" class="inline-block bg-[#3e2723] text-white px-8 py-3 rounded-full font-semibold hover:bg-black transition shadow-md">
                Mulai Pesan Makanan
            </a>
        </div>
    @endif
</main>
@endsection
