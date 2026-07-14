@extends('layouts.app')

@section('title', 'Toko UMKM - UMKM KITA')

@section('content')
<main class="container mx-auto px-4 py-8 flex-grow">

    {{-- Hero --}}
    <div class="relative rounded-3xl overflow-hidden mb-10 h-48 md:h-64">
        <div class="absolute inset-0 bg-gradient-to-r from-[#3e2723] to-[#8b5a2b]"></div>
        <div class="relative z-10 flex flex-col justify-center h-full px-8 md:px-12">
            <h1 class="text-3xl md:text-4xl font-bold text-white serif-font mb-2">Toko UMKM Batam</h1>
            <p class="text-white/80 text-sm md:text-base">Temukan produk terbaik dari UMKM lokal di berbagai area Batam.</p>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 mb-8">
        <form action="{{ route('stores.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko..." class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none text-sm">
            <select name="area" class="px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none text-sm">
                <option value="">Semua Area</option>
                @foreach($areas as $area)
                    <option value="{{ $area }}" {{ request('area') == $area ? 'selected' : '' }}>{{ $area }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-[#8b5a2b] text-white px-6 py-2.5 rounded-xl font-semibold text-sm hover:bg-[#6f4620] transition">Cari</button>
        </form>
    </div>

    {{-- Store Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($stores as $store)
        <a href="{{ route('stores.show', $store->slug) }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
            <div class="h-40 bg-gray-100 overflow-hidden">
                @if($store->image)
                    <img src="{{ asset($store->image) }}" alt="{{ $store->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-4xl bg-gradient-to-br from-[#f4eee6] to-[#e8ddd0]">🏪</div>
                @endif
            </div>
            <div class="p-5">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-bold text-gray-800 group-hover:text-[#8b5a2b] transition">{{ $store->name }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $store->area }}</p>
                    </div>
                    @if($store->isOpen())
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Buka</span>
                    @else
                        <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Tutup</span>
                    @endif
                </div>
                <div class="flex items-center gap-3 mt-3 text-xs text-gray-500">
                    @if($store->average_rating > 0)
                        <span class="flex items-center gap-1"><span class="text-[#8b5a2b]">★</span> {{ number_format($store->average_rating, 1) }}</span>
                    @endif
                    <span>± {{ $store->estimated_time }} menit</span>
                    @if($store->min_order > 0)
                        <span>Min. Rp {{ number_format($store->min_order, 0, ',', '.') }}</span>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full text-center py-16">
            <div class="text-6xl mb-4">🏪</div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Toko</h3>
            <p class="text-gray-500 mb-6">Toko UMKM belum tersedia di area ini.</p>
            <a href="{{ route('home') }}" class="inline-block bg-[#8b5a2b] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition">Kembali ke Beranda</a>
        </div>
        @endforelse
    </div>

    <div class="mt-8">{{ $stores->appends(request()->query())->links() }}</div>
</main>
@endsection
