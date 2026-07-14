@extends('layouts.admin')

@section('title', 'Laporan Stok Produk')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold serif-font text-gray-800">Laporan Stok Produk</h1>
    <p class="text-gray-500">Lihat dan cetak laporan stok inventory produk.</p>
</div>

{{-- Form Filter --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
    <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
        
        <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kategori (Opsional)</label>
            <select name="category_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#8b5a2b] focus:ring focus:ring-[#8b5a2b] focus:ring-opacity-50">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="w-full md:w-1/3">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Stok (Opsional)</label>
            <select name="stock_level" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-[#8b5a2b] focus:ring focus:ring-[#8b5a2b] focus:ring-opacity-50">
                <option value="">Semua Tingkat Stok</option>
                <option value="out_of_stock" {{ request('stock_level') == 'out_of_stock' ? 'selected' : '' }}>Habis (Stok 0)</option>
                <option value="low_stock" {{ request('stock_level') == 'low_stock' ? 'selected' : '' }}>Stok Rendah (< 10)</option>
                <option value="normal" {{ request('stock_level') == 'normal' ? 'selected' : '' }}>Normal (>= 10)</option>
            </select>
        </div>

        <div class="w-full md:w-1/3 flex gap-2">
            <button type="submit" class="w-1/2 bg-gray-800 hover:bg-black text-white px-4 py-2.5 rounded-xl font-medium transition">
                Filter Data
            </button>
            
            {{-- Tombol Cetak (Akan mengirim parameter print=true beserta filter yang aktif) --}}
            <button type="submit" name="print" value="true" formtarget="_blank" class="w-1/2 bg-[#8b5a2b] hover:bg-amber-900 text-white px-4 py-2.5 rounded-xl font-medium transition flex justify-center items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
                </svg>
                Cetak PDF
            </button>
        </div>
    </form>
</div>

{{-- Statistik Ringkasan --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
        <h3 class="text-lg font-medium text-gray-500 mb-2">Total Produk</h3>
        <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
        <h3 class="text-lg font-medium text-gray-500 mb-2">Stok Rendah</h3>
        <p class="text-2xl font-bold text-orange-500">{{ $lowStockProducts }}</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
        <h3 class="text-lg font-medium text-gray-500 mb-2">Habis Stok</h3>
        <p class="text-2xl font-bold text-red-500">{{ $outOfStockProducts }}</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
        <h3 class="text-lg font-medium text-gray-500 mb-2">Nilai Inventaris</h3>
        <p class="text-2xl font-bold text-[#8b5a2b]">Rp {{ number_format($totalInventoryValue, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Tabel Data --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b flex justify-between items-center bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Daftar Produk</h2>
        <span class="text-sm text-gray-500">Menampilkan {{ $products->count() }} produk</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-white text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-6 py-4 border-b">No</th>
                    <th class="text-left px-6 py-4 border-b">Nama Produk</th>
                    <th class="text-left px-6 py-4 border-b">Kategori</th>
                    <th class="text-center px-6 py-4 border-b">Stok</th>
                    <th class="text-right px-6 py-4 border-b">Harga</th>
                    <th class="text-right px-6 py-4 border-b">Nilai Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $index => $product)
                <tr class="hover:bg-gray-50 {{ $product->stock == 0 ? 'bg-red-50' : ($product->stock < 10 ? 'bg-orange-50' : '') }}">
                    <td class="px-6 py-4 text-center text-gray-600">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 text-gray-800 font-medium">{{ $product->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $product->category->name ?? 'Tanpa Kategori' }}</td>
                    <td class="px-6 py-4 text-center font-medium 
                        {{ $product->stock == 0 ? 'text-red-600' : ($product->stock < 10 ? 'text-orange-600' : 'text-green-600') }}
                    ">
                        {{ $product->stock }}
                    </td>
                    <td class="px-6 py-4 text-right text-gray-800">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right text-gray-800 font-medium">
                        Rp {{ number_format($product->stock * $product->discount_price, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">Tidak ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Tambahkan interaktivitas jika diperlukan
</script>
@endpush