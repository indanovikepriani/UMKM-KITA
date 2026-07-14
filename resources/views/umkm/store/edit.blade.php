@extends('layouts.umkm')

@section('title', 'Edit Toko - UMKM KITA')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Toko</h1>
        <p class="text-gray-500 text-sm">Perbarui informasi toko Anda.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-4 text-sm">{{ session('error') }}</div>
    @endif

    <form action="{{ route('umkm.store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama Toko <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $store->name) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">{{ old('description', $store->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Alamat <span class="text-red-500">*</span></label>
                    <input type="text" name="address" value="{{ old('address', $store->address) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Area <span class="text-red-500">*</span></label>
                    <select name="area" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                        @foreach(['Batam Centre', 'Nagoya', 'Tiban', 'Sekupang', 'Batu Ampar', 'Lubuk Baja', 'Sungai Lekop', 'Kijang', 'Tanjung Pinggir', 'Belian', 'Piayu', 'Sungai Bedugul', 'Bengkong'] as $area)
                            <option value="{{ $area }}" {{ old('area', $store->area) == $area ? 'selected' : '' }}>{{ $area }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $store->phone) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $store->whatsapp) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="w-4 h-4 rounded" {{ $store->is_active ? 'checked' : '' }}>
                <label class="text-sm text-gray-700">Toko aktif (tampil di website)</label>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h3 class="font-bold text-gray-800">Jam Operasional</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach(['mon' => 'Senin', 'tue' => 'Selasa', 'wed' => 'Rabu', 'thu' => 'Kamis', 'fri' => 'Jumat', 'sat' => 'Sabtu', 'sun' => 'Minggu'] as $key => $day)
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">{{ $day }}</label>
                    <input type="text" name="hours_{{ $key }}" value="{{ old('hours_'.$key, $store->operating_hours[$key] ?? '08:00-22:00') }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-[#8b5a2b] text-sm outline-none">
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
            <h3 class="font-bold text-gray-800">Pengiriman</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Minimum Order (Rp)</label>
                    <input type="number" name="min_order" value="{{ old('min_order', $store->min_order) }}" min="0" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Radius (km)</label>
                    <input type="number" name="delivery_radius" value="{{ old('delivery_radius', $store->delivery_radius) }}" min="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Est. Waktu (menit)</label>
                    <input type="number" name="estimated_time" value="{{ old('estimated_time', $store->estimated_time) }}" min="5" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Foto Toko</label>
            @if($store->image)
                <img src="{{ asset($store->image) }}" alt="{{ $store->name }}" class="w-20 h-20 rounded-xl object-cover mb-3">
            @endif
            <input type="file" name="image" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:bg-[#f4eee6] file:text-[#8b5a2b] file:font-semibold hover:file:bg-amber-100">
        </div>

        <button type="submit" class="w-full bg-[#8b5a2b] text-white font-semibold py-3 rounded-xl hover:bg-[#6f4620] transition">Simpan Perubahan</button>
    </form>
</div>
@endsection
