@extends('layouts.umkm')

@section('title', 'Dashboard - UMKM KITA')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-500 text-sm">Selamat datang, {{ Auth::user()->name }}! Berikut ringkasan toko Anda.</p>
</div>

{{-- KPI Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Produk</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalProducts }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Pesanan</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalOrders }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Pesanan Pending</p>
        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
        <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Pendapatan</p>
        <p class="text-2xl font-bold text-[#8b5a2b] mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
</div>

{{-- Store Status --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-bold text-gray-800">{{ $store->name }}</h2>
            <p class="text-sm text-gray-500">{{ $store->area }} • {{ $store->today_hours }}</p>
        </div>
        <div class="flex items-center gap-2">
            @if($store->isOpen())
                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Buka</span>
            @else
                <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Tutup</span>
            @endif
            @if($store->is_active)
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Aktif</span>
            @else
                <span class="px-3 py-1 bg-gray-100 text-gray-500 text-xs font-semibold rounded-full">Nonaktif</span>
            @endif
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Pesanan Terbaru</h3>
        <a href="{{ route('umkm.orders.index') }}" class="text-[#8b5a2b] text-sm font-semibold hover:underline">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-6 py-3">No. Pesanan</th>
                    <th class="text-left px-6 py-3">Pelanggan</th>
                    <th class="text-left px-6 py-3">Total</th>
                    <th class="text-left px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-medium">{{ $order->order_number }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $order->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 font-semibold text-[#8b5a2b]">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-3">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $order->status_color }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
