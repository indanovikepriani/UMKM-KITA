@extends('layouts.umkm')

@section('title', 'Produk Saya - UMKM KITA')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Produk Saya</h1>
        <p class="text-gray-500 text-sm">{{ $products->total() }} produk</p>
    </div>
    <a href="{{ route('umkm.products.create') }}" class="bg-[#8b5a2b] text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-[#6f4620] transition">+ Tambah Produk</a>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($products as $product)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="h-40 bg-gray-100 overflow-hidden">
            @if($product->image)
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 text-3xl">📦</div>
            @endif
        </div>
        <div class="p-4">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-sm">{{ $product->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $product->category->name ?? '-' }}</p>
                </div>
                <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $product->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $product->is_available ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="mt-2">
                @if($product->price && $product->price > $product->discount_price)
                    <span class="text-[#8b5a2b] font-bold text-sm">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                    <span class="text-gray-400 text-xs line-through ml-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @else
                    <span class="text-[#8b5a2b] font-bold text-sm">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                @endif
                <span class="text-gray-400 text-xs ml-2">• Stok: {{ $product->stock }}</span>
            </div>
            <div class="flex gap-2 mt-3">
                <a href="{{ route('umkm.products.edit', $product) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold py-2 rounded-lg transition">Edit</a>
                <form action="{{ route('umkm.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold px-4 py-2 rounded-lg transition">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16 text-gray-400">
        <p class="mb-4">Belum ada produk.</p>
        <a href="{{ route('umkm.products.create') }}" class="text-[#8b5a2b] font-semibold hover:underline">Tambah Produk Pertama</a>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $products->appends(request()->query())->links() }}
</div>
@endsection
