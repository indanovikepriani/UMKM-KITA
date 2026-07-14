@extends('layouts.umkm')

@section('title', 'Edit Produk - UMKM KITA')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Produk</h1>
        <p class="text-gray-500 text-sm">Perbarui informasi produk {{ $product->name }}.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-4 text-sm">{{ session('error') }}</div>
    @endif

    <form action="{{ route('umkm.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="3" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Harga Jual / Diskon (Rp) <span class="text-red-500">*</span></label>
                    <p class="text-[10px] text-gray-400 mb-1.5 -mt-1">Harga yang dibayarkan pelanggan</p>
                    <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Harga Asli / Normal (Rp)</label>
                    <p class="text-[10px] text-gray-400 mb-1.5 -mt-1">Harga sebelum diskon (harga coret)</p>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
            </div>
            <p class="text-[10px] text-gray-400 -mt-2">Jika tidak ada diskon, isi "Harga Jual" saja dan biarkan "Harga Asli" kosong.</p>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
                <div class="flex items-end gap-4 pb-1">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1" class="w-4 h-4 rounded" {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                        Tersedia
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        Unggulan
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Foto Produk</label>
            @if($product->image)
                <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-20 h-20 rounded-xl object-cover mb-3">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:bg-[#f4eee6] file:text-[#8b5a2b] file:font-semibold hover:file:bg-amber-100">
        </div>

        <button type="submit" class="w-full bg-[#8b5a2b] text-white font-semibold py-3 rounded-xl hover:bg-[#6f4620] transition">Simpan Perubahan</button>
    </form>
</div>
@endsection
