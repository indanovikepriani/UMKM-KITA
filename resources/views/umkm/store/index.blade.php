@extends('layouts.umkm')

@section('title', 'Toko Saya - UMKM KITA')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Toko Saya</h1>
            <p class="text-gray-500 text-sm">Kelola informasi toko Anda.</p>
        </div>
        <a href="{{ route('umkm.store.edit') }}" class="bg-[#8b5a2b] text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-[#6f4620] transition">Edit Toko</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="flex items-start gap-4">
            @if($store->image)
                <img src="{{ asset($store->image) }}" alt="{{ $store->name }}" class="w-20 h-20 rounded-xl object-cover">
            @else
                <div class="w-20 h-20 rounded-xl bg-[#f4eee6] flex items-center justify-center text-[#8b5a2b] text-2xl">🏪</div>
            @endif
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-800">{{ $store->name }}</h2>
                <p class="text-sm text-gray-500">{{ $store->address }}, {{ $store->area }}</p>
                <div class="flex items-center gap-2 mt-2">
                    @if($store->isOpen())
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Buka</span>
                    @else
                        <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Tutup</span>
                    @endif
                    @if($store->is_active)
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Aktif</span>
                    @else
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-xs font-semibold rounded-full">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>

        @if($store->description)
            <p class="text-gray-600 text-sm">{{ $store->description }}</p>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-gray-100">
            <div>
                <p class="text-xs text-gray-400 mb-1">Telepon</p>
                <p class="text-sm font-medium text-gray-700">{{ $store->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">WhatsApp</p>
                <p class="text-sm font-medium text-gray-700">{{ $store->whatsapp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Min. Order</p>
                <p class="text-sm font-medium text-gray-700">Rp {{ number_format($store->min_order, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Estimasi Pengiriman</p>
                <p class="text-sm font-medium text-gray-700">{{ $store->estimated_time }} menit</p>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100">
            <p class="text-xs text-gray-400 mb-2">Jam Operasional</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                @foreach($store->operating_hours ?? [] as $day => $hours)
                    <div class="text-xs">
                        <span class="font-medium text-gray-600">{{ strtoupper($day) }}:</span>
                        <span class="text-gray-500">{{ $hours }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
