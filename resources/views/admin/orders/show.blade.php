@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')

<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Kembali ke daftar pesanan</a>
    <div class="flex items-center justify-between mt-2">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pesanan #{{ $order->order_number }}</h1>
            <p class="text-sm text-gray-500 mt-1">Dibuat: {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="flex gap-2">
            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $order->status_color }}">{{ $order->status_label }}</span>
            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : ($order->payment_status === 'refunded' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                {{ $order->payment_status === 'paid' ? 'Dibayar' : ($order->payment_status === 'refunded' ? 'Dikembalikan' : 'Belum Dibayar') }}
            </span>
        </div>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm flex items-center gap-2">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Kiri: Info Pesanan --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Detail Pelanggan --}}
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Informasi Pelanggan</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs">Nama</p>
                    <p class="font-medium text-gray-800">{{ $order->user->name ?? 'Tidak Diketahui' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Email</p>
                    <p class="font-medium text-gray-800">{{ $order->user->email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Telepon</p>
                    <p class="font-medium text-gray-800">{{ $order->phone ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs">Alamat Pengiriman</p>
                    <p class="font-medium text-gray-800">{{ $order->shipping_address ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Item Pesanan</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                    <div class="flex items-center gap-3">
                        @if($item->product && $item->product->image)
                            <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset($item->product->image) }}" alt="{{ $item->product_name }}" class="w-10 h-10 rounded-lg object-cover border border-gray-100">
                        @else
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                        <div>
                            <p class="font-medium text-gray-800 text-sm">{{ $item->product_name }}</p>
                            <p class="text-gray-500 text-xs">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <span class="font-semibold text-sm text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100 space-y-2 text-sm">
                <div class="flex justify-between text-gray-500">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Pajak</span>
                    <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-gray-500">
                    <span>Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-gray-800 pt-2 border-t border-gray-100">
                    <span>Total</span>
                    <span class="text-[#8b5a2b]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Catatan --}}
        @if($order->notes)
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Catatan Admin</h3>
            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
        </div>
        @endif
    </div>

    {{-- Kolom Kanan: Aksi --}}
    <div class="space-y-6">

        {{-- Ringkasan --}}
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Ringkasan</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Metode Pembayaran</span>
                    <span class="font-medium text-gray-800 uppercase">{{ $order->payment ? $order->payment->payment_method : '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status Pembayaran</span>
                    <span class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-amber-600' }}">
                        {{ $order->payment_status === 'paid' ? 'Dibayar' : ($order->payment_status === 'refunded' ? 'Dikembalikan' : 'Belum Dibayar') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status Pesanan</span>
                    <span class="font-medium text-gray-800">{{ $order->status_label }}</span>
                </div>
                @if($order->store)
                <div class="flex justify-between">
                    <span class="text-gray-500">Toko</span>
                    <span class="font-medium text-gray-800">{{ $order->store->name }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Aksi --}}
        <div class="bg-white rounded-xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Aksi</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.orders.edit', $order->id) }}" class="block w-full text-center bg-[#8b5a2b] text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-[#6f4620] transition">
                    Edit Pesanan
                </a>
                <button onclick="downloadStrukPDF()" class="block w-full text-center bg-gray-100 text-gray-700 text-sm font-semibold py-2.5 rounded-lg hover:bg-gray-200 transition">
                    Unduh Struk PDF
                </button>
                <a href="{{ route('admin.orders.index') }}" class="block w-full text-center bg-white border border-gray-200 text-gray-600 text-sm font-semibold py-2.5 rounded-lg hover:bg-gray-50 transition">
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        {{-- Struk PDF (hidden, untuk export) --}}
        <div id="area-struk" class="hidden">
            <div style="font-family: Arial, sans-serif; padding: 20px; color: #333;">
                <div style="text-align: center; border-bottom: 2px solid #3e2723; padding-bottom: 10px; margin-bottom: 15px;">
                    <h2 style="margin: 0; font-size: 20px; color: #3e2723;">UMKM KITA</h2>
                    <p style="margin: 2px 0 0; font-size: 11px; color: #888;">Nota Resmi Bukti Pemesanan</p>
                    <p style="margin: 2px 0 0; font-size: 10px; color: #aaa;">#{{ $order->order_number }} | {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px dotted #ddd; font-size: 12px;">
                    <span>{{ $item->product_name }} (x{{ $item->quantity }})</span>
                    <span style="font-weight: bold;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div style="margin-top: 10px; font-size: 12px;">
                    <div style="display: flex; justify-content: space-between;"><span>Subtotal</span><span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
                    <div style="display: flex; justify-content: space-between;"><span>Pajak</span><span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span></div>
                    <div style="display: flex; justify-content: space-between;"><span>Ongkir</span><span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span></div>
                    <div style="display: flex; justify-content: space-between; font-weight: bold; font-size: 14px; border-top: 2px solid #3e2723; margin-top: 6px; padding-top: 6px;">
                        <span>Total</span><span style="color: #8b5a2b;">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
                <p style="text-align: center; font-size: 9px; color: #aaa; margin-top: 15px;">Terima Kasih Telah Berbelanja di UMKM KITA</p>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function downloadStrukPDF() {
        const element = document.getElementById('area-struk');
        element.classList.remove('hidden');
        const options = {
            margin: [10, 10, 10, 10],
            filename: 'Struk-{{ $order->order_number }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(options).from(element).save().then(() => {
            element.classList.add('hidden');
        });
    }
</script>
@endpush
