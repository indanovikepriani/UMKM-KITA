@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Orders Management</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau seluruh pesanan, status pembayaran, dan kelola data penjualan.</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Total Pesanan</p>
            <p class="text-xl font-bold text-gray-800">{{ $summary['total_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Total Pendapatan</p>
            <p class="text-xl font-bold text-green-600">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Pesanan Hari Ini</p>
            <p class="text-xl font-bold text-gray-800">{{ $summary['today_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Menunggu</p>
            <p class="text-xl font-bold text-amber-600">{{ $summary['pending_orders'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Belum Bayar</p>
            <p class="text-xl font-bold text-red-600">{{ $summary['unpaid_orders'] }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <form action="{{ route('admin.orders.index') }}" method="GET" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-5 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="No. pesanan atau nama pelanggan..."
                   class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
        </div>
        <div>
            <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Status</label>
            <select name="status" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30">
                <option value="">Semua</option>
                @php
                    $statusLabels = ['pending' => 'Menunggu', 'processing' => 'Diproses', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
                @endphp
                @foreach(['pending', 'processing', 'completed', 'cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status') == $s)>{{ $statusLabels[$s] ?? ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Pembayaran</label>
            <select name="payment_status" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30">
                <option value="">Semua</option>
                <option value="unpaid" @selected(request('payment_status') == 'unpaid')>Belum Bayar</option>
                <option value="paid" @selected(request('payment_status') == 'paid')>Sudah Bayar</option>
                <option value="refunded" @selected(request('payment_status') == 'refunded')>Refund</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-[#3e2723] hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Filter</button>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition">Reset</a>
        </div>
    </form>

    {{-- Orders Table --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">No. Pesanan</th>
                        <th class="text-left px-5 py-3 font-semibold">Pelanggan</th>
                        <th class="text-left px-5 py-3 font-semibold">Item</th>
                        <th class="text-left px-5 py-3 font-semibold">Total</th>
                        <th class="text-left px-5 py-3 font-semibold">Status</th>
                        <th class="text-left px-5 py-3 font-semibold">Pembayaran</th>
                        <th class="text-left px-5 py-3 font-semibold">Tanggal</th>
                        <th class="text-right px-5 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    @php
                        $payColor = match($order->payment_status) {
                            'paid' => 'bg-green-100 text-green-700',
                            'refunded' => 'bg-gray-200 text-gray-600',
                            default => 'bg-red-100 text-red-600',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 transition {{ $order->payment_status == 'unpaid' ? 'bg-red-50/50' : '' }}">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $order->order_number }}</td>
                        <td class="px-5 py-3 text-gray-600 text-xs">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $order->items->count() }} item</td>
                        <td class="px-5 py-3 font-semibold text-[#8b5a2b] text-xs">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-semibold px-2 py-1 rounded-md {{ $order->status_color }}">{{ $order->status_label }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-semibold px-2 py-1 rounded-md {{ $payColor }}">{{ $order->payment_status == 'unpaid' ? 'Belum Bayar' : ucfirst($order->payment_status) }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="text-[#8b5a2b] font-semibold text-xs hover:underline">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada data pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
@endsection
