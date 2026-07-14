@extends('layouts.umkm')

@section('title', 'Pesanan - UMKM KITA')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pesanan</h1>
    <p class="text-gray-500 text-sm">Kelola pesanan yang masuk ke toko Anda.</p>
</div>

{{-- Filter --}}
<div class="flex gap-2 mb-6 overflow-x-auto pb-2">
    <a href="{{ route('umkm.orders.index') }}" class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap {{ !request('status') ? 'bg-[#8b5a2b] text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Semua</a>
    <a href="{{ route('umkm.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Menunggu ({{ $pendingCount }})</a>
    <a href="{{ route('umkm.orders.index', ['status' => 'processing']) }}" class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap {{ request('status') == 'processing' ? 'bg-blue-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Diproses ({{ $processingCount }})</a>
    <a href="{{ route('umkm.orders.index', ['status' => 'completed']) }}" class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap {{ request('status') == 'completed' ? 'bg-green-500 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Selesai</a>
</div>

{{-- Orders Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-6 py-3">No. Pesanan</th>
                    <th class="text-left px-6 py-3">Pelanggan</th>
                    <th class="text-left px-6 py-3">Items</th>
                    <th class="text-left px-6 py-3">Total</th>
                    <th class="text-left px-6 py-3">Status</th>
                    <th class="text-left px-6 py-3">Tanggal</th>
                    <th class="text-left px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 font-medium">{{ $order->order_number }}</td>
                    <td class="px-6 py-3 text-gray-600">{{ $order->user->name ?? '-' }}</td>
                    <td class="px-6 py-3 text-gray-500">{{ $order->items->count() }} item</td>
                    <td class="px-6 py-3 font-semibold text-[#8b5a2b]">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-3">
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $order->status_color }}">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-3 text-gray-500 text-xs">{{ $order->created_at->format('d M Y, H:i') }}@if($order->scheduled_at)<br><span class="text-blue-600 font-medium">📅 {{ $order->scheduled_at->format('d M H:i') }}</span>@endif</td>
                    <td class="px-6 py-3">
                        <a href="{{ route('umkm.orders.show', $order) }}" class="text-[#8b5a2b] font-semibold text-xs hover:underline">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">Belum ada pesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $orders->appends(request()->query())->links() }}</div>
@endsection
