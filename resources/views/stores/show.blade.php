@extends('layouts.app')

@section('title', $store->name . ' - UMKM KITA')

@section('content')
<main class="container mx-auto px-4 py-8 flex-grow">

    <nav class="text-sm mb-6 text-gray-500 font-medium">
        <a href="{{ route('home') }}" class="hover:text-[#8b5a2b] transition">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('stores.index') }}" class="hover:text-[#8b5a2b] transition">Toko</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800">{{ $store->name }}</span>
    </nav>

    {{-- Store Header --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="h-48 md:h-64 bg-gray-100">
            @if($store->image)
                <img src="{{ asset($store->image) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 text-6xl bg-gradient-to-br from-[#f4eee6] to-[#e8ddd0]">🏪</div>
            @endif
        </div>
        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-2xl md:text-3xl font-bold serif-font text-gray-800">{{ $store->name }}</h1>
                        @if($store->isOpen())
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Buka</span>
                        @else
                            <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Tutup</span>
                        @endif
                    </div>
                    <p class="text-gray-500 text-sm mb-3">{{ $store->address }}, {{ $store->area }}</p>
                    @if($store->description)
                        <p class="text-gray-600 text-sm max-w-xl">{{ $store->description }}</p>
                    @endif
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    @if($store->whatsapp)
                        <a href="https://wa.me/{{ $store->whatsapp }}" target="_blank" class="bg-[#25D366] text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-[#1ebe57] transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.012c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>

            {{-- Store Info --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Rating</p>
                    <p class="text-sm font-semibold text-gray-800">
                        @if($store->average_rating > 0)
                            ★ {{ number_format($store->average_rating, 1) }} ({{ $store->review_count }})
                        @else
                            Belum ada rating
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Estimasi Pengiriman</p>
                    <p class="text-sm font-semibold text-gray-800">± {{ $store->estimated_time }} menit</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Minimum Order</p>
                    <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($store->min_order, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Jam Buka Hari Ini</p>
                    <p class="text-sm font-semibold {{ $store->isOpen() ? 'text-green-600' : 'text-red-600' }}">{{ $store->today_hours }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Products --}}
    <div class="mb-6">
        <h2 class="text-xl font-bold serif-font text-gray-800">Menu dari {{ $store->name }}</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @forelse($products as $product)
        <a href="{{ route('menu.show', $product->slug) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
            <div class="h-36 bg-gray-100 overflow-hidden">
                @if($product->image)
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-3xl">📦</div>
                @endif
            </div>
            <div class="p-4">
                <h3 class="font-bold text-gray-800 text-sm group-hover:text-[#8b5a2b] transition">{{ $product->name }}</h3>
                <div class="mt-1">
                    @if($product->price && $product->price > $product->discount_price)
                        <span class="text-[#8b5a2b] font-bold text-sm">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        <span class="text-gray-400 text-xs line-through ml-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-[#8b5a2b] font-bold text-sm">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="text-6xl mb-4">🍽️</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Menu</h3>
            <p class="text-gray-500 mb-6">Toko ini belum memiliki produk yang tersedia.</p>
            <a href="{{ route('menu.index') }}" class="inline-block bg-[#8b5a2b] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition">Lihat Menu Lainnya</a>
        </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $products->links() }}</div>
</main>
@endsection
