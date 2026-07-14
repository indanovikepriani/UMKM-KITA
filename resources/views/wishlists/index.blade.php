@extends('layouts.app')

@section('title', 'Favorit Saya - UMKM KITA')

@section('styles')
.wishlist-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(62, 39, 35, 0.8)), url('{{ asset("images/hero/about-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
@endsection

@section('content')
<header class="wishlist-hero h-[35vh] flex items-center justify-center pt-20 text-center text-white">
    <div class="px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-4">Favorit Saya</h1>
        <p class="text-sm md:text-base font-light text-gray-200">Produk-produk favorit yang Anda simpan</p>
    </div>
</header>

<div class="container mx-auto px-6 py-16 max-w-6xl">
    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
    @endif

    @if($wishlists->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($wishlists as $wishlist)
        @php $product = $wishlist->product; @endphp
        <div class="glass-card p-4 hover:shadow-lg transition group relative">
            <form action="{{ route('wishlists.toggle') }}" method="POST" class="absolute top-3 right-3 z-10">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit" class="w-8 h-8 bg-white/80 rounded-full flex items-center justify-center hover:bg-red-50 transition" aria-label="Hapus dari favorit">
                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                </button>
            </form>
            <a href="{{ route('menu.show', $product->slug) }}">
                <div class="relative pt-16 mb-4">
                    <div class="absolute -top-16 left-1/2 -translate-x-1/2 w-28 h-28 rounded-full overflow-hidden border-4 border-[#d2b48c] bg-[#f4eee6]">
                        @if($product->image)
                            <img src="{{ Str::startsWith($product->image, ['http://', 'https://']) ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-3xl">🍽️</div>
                        @endif
                    </div>
                </div>
                @if($product->category)
                <span class="text-[10px] uppercase font-bold tracking-wider text-[#8b5a2b] bg-amber-50 px-2 py-0.5 rounded-full">{{ $product->category->name }}</span>
                @endif
                <h3 class="font-bold text-gray-800 mt-2 line-clamp-1 text-sm">{{ $product->name }}</h3>
                @if($product->store)
                <p class="text-[10px] text-gray-400 mt-0.5">{{ $product->store->name }}</p>
                @endif
                <div class="mt-2">
                    @if($product->price && $product->price > $product->discount_price)
                        <span class="text-[#8b5a2b] font-bold text-sm">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        <span class="text-gray-400 text-xs line-through ml-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @else
                        <span class="text-[#8b5a2b] font-bold text-sm">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                    @endif
                </div>
            </a>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-16">
        <div class="text-6xl mb-4">💖</div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Favorit</h3>
        <p class="text-gray-500 mb-6">Mulai jelajahi menu kami dan simpan produk favorit Anda.</p>
        <a href="{{ route('menu.index') }}" class="inline-block bg-[#8b5a2b] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition text-sm">
            Jelajahi Menu
        </a>
    </div>
    @endif
</div>
@endsection
