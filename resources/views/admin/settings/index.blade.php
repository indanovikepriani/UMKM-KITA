@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>
        <p class="text-sm text-gray-500 mt-1">Konfigurasi pengaturan umum website UMKM KITA.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-3xl">
        @csrf
        @method('PUT')

        {{-- Store Information --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Informasi Toko
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Nama Toko</label>
                        <input type="text" name="store_name" value="{{ old('store_name', $settings['store_name']) }}" required
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Email Toko</label>
                        <input type="email" name="store_email" value="{{ old('store_email', $settings['store_email']) }}" required
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Telepon</label>
                        <input type="text" name="store_phone" value="{{ old('store_phone', $settings['store_phone']) }}"
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Mata Uang</label>
                        <select name="currency" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30">
                            <option value="IDR" @selected(old('currency', $settings['currency']) == 'IDR')>IDR (Rupiah)</option>
                            <option value="USD" @selected(old('currency', $settings['currency']) == 'USD')>USD (Dollar)</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Alamat</label>
                    <textarea name="store_address" rows="2" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">{{ old('store_address', $settings['store_address']) }}</textarea>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Deskripsi</label>
                    <textarea name="store_description" rows="2" maxlength="500" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">{{ old('store_description', $settings['store_description']) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Financial Settings --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Pengaturan Keuangan
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Pajak (%)</label>
                    <input type="number" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate']) }}" min="0" max="100" step="0.5"
                           class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                    <p class="text-[11px] text-gray-400 mt-1">Persentase pajak yang dikenakan pada setiap pesanan</p>
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Ongkos Kirim Default (Rp)</label>
                    <input type="number" name="shipping_fee" value="{{ old('shipping_fee', $settings['shipping_fee']) }}" min="0" step="1000"
                           class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                    <p class="text-[11px] text-gray-400 mt-1">Biaya pengiriman standar dalam Rupiah</p>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-[#8b5a2b] hover:bg-[#6f4620] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">Simpan Pengaturan</button>
        </div>
    </form>
@endsection
