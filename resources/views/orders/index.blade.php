@extends('layouts.app')

@section('title', 'Riwayat Pesanan - UMKM KITA')

@section('content')
    <main class="container mx-auto px-4 py-10 max-w-4xl flex-grow">

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl mb-8 shadow-sm">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <div class="mb-10">
            <h1 class="text-3xl md:text-4xl font-bold serif-font text-gray-800 mb-2">Riwayat Pesanan</h1>
            <p class="text-gray-500">Semua pesanan yang pernah Anda buat di UMKM KITA.</p>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="text-5xl mb-4">🧾</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 mb-6">Yuk mulai belanja menu favorit Anda sekarang.</p>
                <a href="{{ route('menu.index') }}" class="inline-block bg-[#8b5a2b] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition">Lihat Menu</a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                <a href="{{ route('orders.show', $order->id) }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-amber-200 transition">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">{{ $order->order_number }}</p>
                            <h3 class="font-bold text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $order->items->count() }} item</p>
                            @if($order->scheduled_at)
                            <p class="text-xs text-blue-600 mt-1 font-medium">📅 Jadwal: {{ $order->scheduled_at->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-lg text-[#8b5a2b] mb-2">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            <div class="flex gap-2 justify-end flex-wrap">
                                @php
                                    $payColor = $order->payment_status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600';
                                @endphp
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $order->status_color }}">{{ $order->status_label }}</span>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $payColor }} capitalize">{{ $order->payment_status }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </main>
@endsection
