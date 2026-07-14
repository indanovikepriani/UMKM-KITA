@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Detail Kategori</h1>
        <p class="text-gray-600">Informasi lengkap tentang kategori: {{ $category->name }}</p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Informasi Kategori</h2>
        </div>

        <div class="px-6 py-6 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Dasar</h3>
                    <p class="text-gray-600"><strong>Nama Kategori:</strong> {{ $category->name }}</p>
                    <p class="text-gray-600"><strong>Slug:</strong> {{ $category->slug }}</p>
                    <p class="text-gray-600"><strong>Deskripsi:</strong> {{ $category->description ?? '-' }}</p>
                    <p class="text-gray-600"><strong>Status:</strong> 
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </p>
                    <p class="text-gray-600"><strong>Dibuat pada:</strong> {{ $category->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-gray-600"><strong>Diupdate pada:</strong> {{ $category->updated_at->format('d M Y, H:i') }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Gambar Kategori</h3>
                    @if($category->image)
                        <div class="aspect-w-4 aspect-h-3 bg-gray-100 rounded-lg overflow-hidden mb-4">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Tidak ada gambar yang diunggah.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6 pt-6 border-t">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Produk dalam Kategori Ini</h3>
                @if($category->products->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($category->products as $product)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                         class="w-16 h-16 object-cover rounded mr-4">
                                @endif
                                <div class="flex-1">
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-500">Rp {{ number_format($product->final_price, 0, ',', '.') }}</p>
                                    @if($product->price && $product->price > $product->discount_price)
                                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                                            Diskon {{ $product->discount_percentage }}%
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Belum ada produk dalam kategori ini.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('admin.categories.edit', $category) }}" 
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Edit Kategori
        </a>
        <a href="{{ route('admin.categories.index') }}" 
           class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            Kembali ke Daftar
        </a>
    </div>
</div>
@endsection