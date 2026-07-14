@extends('layouts.app')

@section('title', "{{ $product->name }} - UMKM KITA")

@section('styles')
textarea::-webkit-scrollbar {
    width: 8px;
}
textarea::-webkit-scrollbar-track {
    background: #f1f1f1; 
    border-radius: 8px;
}
textarea::-webkit-scrollbar-thumb {
    background: #d2b48c; 
    border-radius: 8px;
}
textarea::-webkit-scrollbar-thumb:hover {
    background: #8b5a2b; 
}
@endsection

@section('content')
<main class="container mx-auto px-4 py-12 md:py-20 max-w-6xl flex-grow">
    
    <nav class="text-sm mb-8 text-gray-500 font-medium">
        <a href="{{ route('home') }}" class="hover:text-[#8b5a2b] transition">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('menu.index') }}" class="hover:text-[#8b5a2b] transition">Menu</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-12">
        <div class="flex flex-col md:flex-row gap-10 md:gap-16">
            
            <div class="w-full md:w-1/2">
                <div class="rounded-3xl overflow-hidden shadow-md border-4 border-[#f4eee6] group relative">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500 ease-in-out">
                </div>
            </div>

            <div class="w-full md:w-1/2 flex flex-col justify-center">
                
                <div class="flex flex-wrap justify-between items-center mb-4 gap-4">
                    <span class="text-[11px] uppercase font-bold tracking-wider text-amber-700 bg-amber-50 px-3 py-1.5 rounded-full">
                        {{ $product->category->name ?? 'Kategori' }}
                    </span>
                    
                    <div class="text-sm text-gray-500 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-lg shadow-sm">🧑‍🍳</span>
                        <span>Dibuat oleh: <strong class="text-[#8b5a2b]">{{ $product->umkm_name ?? 'Mitra UMKM' }}</strong>
                            @if($product->umkm_address)
                                <span class="text-gray-400 font-normal">• {{ $product->umkm_address }}</span>
                            @endif
                        </span>
                    </div>
                </div>

                <h1 class="text-3xl md:text-5xl font-bold serif-font text-gray-800 mb-4 leading-tight">
                    {{ $product->name }}
                </h1>

                <div class="mb-4">
                    @if($product->price && $product->price > $product->discount_price)
                        <div class="flex items-center gap-3">
                            <span class="text-3xl font-bold text-[#8b5a2b]">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="text-lg text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-white bg-red-500 px-2 py-0.5 rounded-full">-{{ $product->discount_percentage }}%</span>
                        </div>
                    @else
                        <span class="text-3xl font-bold text-[#8b5a2b]">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                    @endif
                </div>

                <p class="text-sm text-gray-500 mb-6">
                    Status Stok: 
                    @if($product->stock > 0)
                        <span class="text-green-600 font-bold bg-green-50 px-2 py-1 rounded-md">{{ $product->stock }} Porsi Tersedia</span>
                    @else
                        <span class="text-red-500 font-bold bg-red-50 px-2 py-1 rounded-md">Habis / Sold Out</span>
                    @endif
                </p>

                <div class="prose text-gray-600 text-sm md:text-base leading-relaxed mb-8">
                    <p>{{ $product->description }}</p>
                </div>

                <hr class="border-gray-100 mb-8">

                @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-1/3">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Porsi</label>
                            <div class="flex items-center border border-gray-200 rounded-xl bg-white overflow-hidden shadow-sm">
                                <button type="button" onclick="decrementQty()" class="px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-[#8b5a2b] transition font-bold">-</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-full text-center py-3 outline-none font-semibold text-gray-800" readonly>
                                <button type="button" onclick="incrementQty()" class="px-4 py-3 text-gray-500 hover:bg-gray-50 hover:text-[#8b5a2b] transition font-bold">+</button>
                            </div>
                        </div>
                    </div>

                    <div class="w-full">
                        <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan <span class="text-gray-400 font-normal">(Opsional)</span>
                        </label>
                        <textarea id="note" name="note" rows="3" placeholder="Contoh: Tidak pedas, tanpa seledri, ekstra kuah..." class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] text-sm text-gray-700 shadow-sm transition resize-y"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#3e2723] hover:bg-black text-white py-4 rounded-xl transition text-base font-bold tracking-wide shadow-lg flex justify-center items-center gap-2 transform hover:-translate-y-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Tambahkan ke Keranjang
                    </button>
                </form>
                @auth
                <form action="{{ route('wishlists.toggle') }}" method="POST" class="mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-full border-2 border-[#8b5a2b] text-[#8b5a2b] hover:bg-[#8b5a2b] hover:text-white py-3 rounded-xl transition text-sm font-semibold flex justify-center items-center gap-2">
                        @if(auth()->user()->wishlists()->where('product_id', $product->id)->exists())
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                            Hapus dari Favorit
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                            Tambah ke Favorit
                        @endif
                    </button>
                </form>
                @endauth
                @else
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 text-center">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-lg font-bold text-gray-700 mb-1">Mohon Maaf, Stok Habis</h3>
                        <p class="text-sm text-gray-500">Menu ini sedang tidak tersedia saat ini. Silakan cek kembali nanti atau pilih menu lezat lainnya.</p>
                        <a href="{{ route('menu.index') }}" class="mt-4 inline-block text-[#8b5a2b] font-semibold hover:underline">Lihat Menu Lainnya</a>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- Reviews Section --}}

    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold serif-font text-gray-800">Ulasan Pelanggan</h2>
            <div class="flex items-center gap-2">
                @if($avgRating > 0)
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($avgRating))
                                <svg class="w-5 h-5 text-[#8b5a2b]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @elseif($i <= ceil($avgRating))
                                <svg class="w-5 h-5 text-[#8b5a2b]" fill="currentColor" viewBox="0 0 20 20">
                                    <defs><linearGradient id="half{{ $i }}"><stop offset="50%" stop-color="currentColor"/><stop offset="50%" stop-color="#d1d5db"/></linearGradient></defs>
                                    <path fill="url(#half{{ $i }})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-500">{{ $avgRating }} ({{ $reviews->count() }} ulasan)</span>
                @else
                    <span class="text-sm text-gray-400">Belum ada ulasan</span>
                @endif
            </div>
        </div>

        @if($reviews->isEmpty())
            <div class="bg-gray-50 rounded-2xl p-8 text-center border border-gray-100">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($reviews as $review)
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#f4eee6] flex items-center justify-center text-[#8b5a2b] font-bold text-sm flex-shrink-0">
                            {{ substr($review->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-800 text-sm">{{ $review->user->name ?? 'Anonymous' }}</h4>
                                    <div class="flex items-center gap-1 mt-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-{{ $i <= $review->rating ? '[#8b5a2b]' : 'gray-300' }} text-xs">★</span>
                                        @endfor
                                        <span class="text-xs text-gray-400 ml-1">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                            @if($review->admin_reply)
                                <div class="mt-3 bg-gray-50 rounded-xl p-3 border-l-2 border-[#8b5a2b]">
                                    <p class="text-xs font-semibold text-[#8b5a2b] mb-1">Balasan Admin:</p>
                                    <p class="text-sm text-gray-600">{{ $review->admin_reply }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($reviews->count() >= 5)
                <div class="text-center mt-6">
                    <a href="{{ route('testimonials.index') }}" class="text-[#8b5a2b] font-semibold hover:underline text-sm">Lihat Semua Ulasan →</a>
                </div>
            @endif
        @endif
    </div>
</main>
@endsection

@section('scripts')
<script>
    function incrementQty() {
        let input = document.getElementById('quantity');
        let max = parseInt(input.getAttribute('max'));
        let val = parseInt(input.value);
        if(val < max) {
            input.value = val + 1;
        }
    }

    function decrementQty() {
        let input = document.getElementById('quantity');
        let val = parseInt(input.value);
        if(val > 1) {
            input.value = val - 1;
        }
    }
</script>
@endsection
