@extends('layouts.app')

@section('title', 'Menu Makanan - UMKM KITA')

@section('styles')
.menu-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('{{ asset("images/hero/menu-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
.category-active {
    background-color: #3e2723;
    color: white;
    border-color: #3e2723;
}
@endsection

@section('content')
<header class="menu-hero h-[40vh] flex items-center justify-center pt-20 text-center text-white">
    <div>
        <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-2">Our Delicious Menu</h1>
        <p class="text-sm md:text-base font-light tracking-wide max-w-md mx-auto px-4">Pilih dan nikmati berbagai hidangan kuliner lokal terbaik yang diolah secara higienis dan penuh cita rasa.</p>
    </div>
</header>

<main class="container mx-auto px-4 py-12 max-w-7xl -mt-10 relative z-10">
    
    <form action="{{ route('menu.index') }}" method="GET" class="mb-12 space-y-6">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="w-full md:w-1/3 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu favoritmu..." 
                    class="w-full pl-4 pr-10 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] text-sm">
                <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-[#8b5a2b]" aria-label="Cari">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>
            </div>

            <div class="w-full md:w-auto flex items-center gap-2">
                <label class="text-xs text-gray-500 font-medium whitespace-nowrap">Urutkan:</label>
                <select name="sort" onchange="this.form.submit()" 
                    class="px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] text-sm bg-white cursor-pointer">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama (A-Z)</option>
                </select>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('menu.index', array_merge(request()->except('category'), ['category' => ''])) }}" 
               class="px-5 py-2 rounded-full border border-gray-200 text-sm font-medium transition duration-200 shadow-sm hover:border-[#8b5a2b] {{ request('category') == '' ? 'category-active' : 'bg-white text-gray-600' }}">
               Semua Menu
            </a>
            @foreach($categories as $cat)
            <a href="{{ route('menu.index', array_merge(request()->except('category'), ['category' => $cat->id])) }}" 
               class="px-5 py-2 rounded-full border border-gray-200 text-sm font-medium transition duration-200 shadow-sm hover:border-[#8b5a2b] {{ request('category') == $cat->id ? 'category-active' : 'bg-white text-gray-600' }}">
               {{ $cat->name }}
            </a>
            @endforeach
        </div>
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-16 pt-10">
        @forelse($products as $product)
        <div class="glass-card p-5 flex flex-col items-center pt-20 relative rounded-3xl hover:-translate-y-2 transition duration-300 shadow-sm group">
            
            <a href="{{ route('menu.show', $product->slug) }}" class="w-36 h-36 rounded-full border-4 border-[#d2b48c] overflow-hidden absolute -top-16 shadow-md bg-white block transform group-hover:scale-105 transition duration-300">
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </a>
            
            <span class="text-[10px] uppercase font-bold tracking-wider text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full mb-2">
                {{ $product->category->name ?? 'Lainnya' }}
            </span>

            <h3 class="text-lg font-bold text-gray-800 text-center line-clamp-1 mb-1 hover:text-[#8b5a2b] transition">
                <a href="{{ route('menu.show', $product->slug) }}">{{ $product->name }}</a>
            </h3>
            <p class="text-gray-400 text-xs text-center line-clamp-2 min-h-[32px] px-2 mb-4">{{ $product->description }}</p>
            
            <div class="mt-auto w-full text-center">
                @if($product->price && $product->price > $product->discount_price)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-[#8b5a2b] font-bold text-base">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        </div>
                    @else
                    <p class="text-[#8b5a2b] font-bold text-base mb-4">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                    @endif
                
                @if($product->stock > 0)
                    <a href="{{ route('menu.show', $product->slug) }}" class="w-full bg-[#3e2723] hover:bg-black text-white py-2.5 rounded-xl transition text-xs font-semibold tracking-wide shadow-sm block text-center">
                        Lihat Detail & Pesan
                    </a>
                @else
                    <button type="button" disabled class="w-full bg-gray-200 text-gray-400 py-2.5 rounded-xl text-xs font-semibold cursor-not-allowed">
                        Stok Habis
                    </button>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="text-6xl mb-4">🍽️</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Menu Tidak Ditemukan</h3>
            <p class="text-gray-500 mb-6">Tidak ada produk kuliner yang cocok dengan pencarian Anda.</p>
            <a href="{{ route('menu.index') }}" class="inline-block bg-[#8b5a2b] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition">Lihat Semua Menu</a>
        </div>
        @endforelse
    </div>

    <div class="mt-16 flex justify-center">
        {{ $products->appends(request()->query())->links() }}
    </div>

</main>
@endsection
