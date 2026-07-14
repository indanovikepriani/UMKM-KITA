@extends('layouts.admin')

@section('title', 'Menu / Produk')

@section('content')

    <div class="mb-8 flex justify-between items-center flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold serif-font text-gray-800">Menu / Produk</h1>
            <p class="text-gray-500">Kelola daftar menu yang dijual di UMKM KITA.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="bg-[#8b5a2b] text-white font-semibold px-6 py-3 rounded-full hover:bg-[#6f4620] transition inline-flex items-center gap-2">
            <span>+</span> Tambah Menu
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="text-left px-6 py-3">Foto</th>
                        <th class="text-left px-6 py-3">Nama Menu</th>
                        <th class="text-left px-6 py-3">Kategori</th>
                        <th class="text-left px-6 py-3">Harga</th>
                        <th class="text-left px-6 py-3">Stok</th>
                        <th class="text-left px-6 py-3">Status</th>
                        <th class="text-left px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-xl object-cover">
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400 line-clamp-1 max-w-xs">{{ Str::limit($product->description, 60) }}</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500">{{ $product->category->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($product->price && $product->price > $product->discount_price)
                                <p class="text-gray-400 line-through text-xs">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="font-semibold text-[#8b5a2b]">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                            @else
                                <p class="font-semibold text-gray-800">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $product->stock }}</td>
                        <td class="px-6 py-4">
                            @if($product->is_available)
                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-green-100 text-green-700">Tersedia</span>
                            @else
                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-gray-100 text-gray-600">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-[#8b5a2b] font-semibold hover:underline mr-3">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus menu {{ $product->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 font-semibold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-400">Belum ada menu. Klik "Tambah Menu" untuk mulai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t">
            {{ $products->links() }}
        </div>
    </div>

@endsection
