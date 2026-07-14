@extends('layouts.umkm')

@section('title', 'Tambah Produk - UMKM KITA')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Produk</h1>
        <p class="text-gray-500 text-sm">Tambahkan produk baru ke toko {{ $store->name }}.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-4 text-sm">{{ session('error') }}</div>
    @endif

    <form action="{{ route('umkm.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="3" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Harga Jual / Diskon (Rp) <span class="text-red-500">*</span></label>
                    <p class="text-[10px] text-gray-400 mb-1.5 -mt-1">Harga yang dibayarkan pelanggan</p>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Harga Asli / Normal (Rp)</label>
                    <p class="text-[10px] text-gray-400 mb-1.5 -mt-1">Harga sebelum diskon (harga coret)</p>
                    <input type="number" name="price" value="{{ old('price') }}" min="0" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
            </div>
            <p class="text-[10px] text-gray-400 -mt-2">Jika tidak ada diskon, isi "Harga Jual" saja dan biarkan "Harga Asli" kosong.</p>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Stok <span class="text-red-500">*</span></label>
                <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Foto Produk <span class="text-red-500">*</span></label>
            <input type="file" name="image" accept="image/*" required class="w-full text-sm file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:bg-[#f4eee6] file:text-[#8b5a2b] file:font-semibold hover:file:bg-amber-100">
        </div>

        <button type="submit" class="w-full bg-[#8b5a2b] text-white font-semibold py-3 rounded-xl hover:bg-[#6f4620] transition">Tambah Produk</button>
    </form>
</div>
@endsection
