@extends('layouts.umkm')

@section('title', 'Detail Pesanan - UMKM KITA')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan #{{ $order->order_number }}</h1>
            <p class="text-gray-500 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ route('umkm.orders.index') }}" class="text-[#8b5a2b] text-sm font-semibold hover:underline">← Kembali</a>
    </div>

    {{-- Status --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-800">Status Pesanan</h3>
            <span class="px-3 py-1 text-sm font-medium rounded-full {{ $order->status_color }}">
                {{ $order->status_label }}
            </span>
        </div>

        @if(in_array($order->status, ['pending', 'processing']))
        <div class="flex gap-2">
            @if($order->status === 'pending')
                <form action="{{ route('umkm.orders.updateStatus', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="processing">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-600 transition">Terima & Proses</button>
                </form>
            @endif
            @if($order->status === 'processing')
                <form action="{{ route('umkm.orders.updateStatus', $order) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition">Selesai</button>
                </form>
            @endif
            <form action="{{ route('umkm.orders.updateStatus', $order) }}" method="POST" onsubmit="return confirm('Tolak pesanan ini?')">
                @csrf @method('PUT')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-100 transition">Tolak</button>
            </form>
        </div>
        @endif
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-bold text-gray-800 mb-4">Item Pesanan</h3>
        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                @if($item->product && $item->product->image)
                    <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset($item->product->image) }}" alt="{{ $item->product_name }}" class="w-12 h-12 rounded-lg object-cover">
                @else
                    <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400">📦</div>
                @endif
                <div class="flex-1">
                    <p class="font-medium text-gray-800 text-sm">{{ $item->product_name }}</p>
                    <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
                <p class="font-semibold text-gray-800 text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Summary --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-bold text-gray-800 mb-4">Ringkasan</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Pajak</span><span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Ongkos Kirim</span><span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span></div>
            <div class="flex justify-between font-bold text-[#8b5a2b] text-base pt-2 border-t"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
        </div>
    </div>

    {{-- Customer Info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4">Info Pelanggan</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Nama</span><span>{{ $order->user->name ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Telepon</span><span>{{ $order->phone ?? '-' }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Alamat</span><span class="text-right max-w-[60%]">{{ $order->shipping_address ?? '-' }}</span></div>
            @if($order->scheduled_at)
                <div class="flex justify-between"><span class="text-gray-500">Jadwal Pengiriman</span><span class="text-blue-600 font-medium">{{ $order->scheduled_at->format('d M Y, H:i') }}</span></div>
            @endif
            @if($order->notes)
                <div class="pt-2 border-t border-gray-100">
                    <span class="text-gray-500">Catatan:</span>
                    <p class="text-gray-700 mt-1">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
