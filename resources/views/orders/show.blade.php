@extends('layouts.app')

@section('title', 'Detail Pembayaran - UMKM KITA')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-4xl flex-grow">
        
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl mb-8 shadow-sm" role="alert">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-8 shadow-sm" role="alert">
            <p class="font-medium">{{ session('error') }}</p>
        </div>
        @endif

        <div class="text-center mb-10">
            <h1 class="text-3xl md:text-4xl font-bold serif-font text-gray-800 mb-2">Detail Pesanan #{{ $order->order_number }}</h1>
            <p class="text-gray-500">Tanggal Pesanan: {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>

        @if(in_array($order->status, ['pending', 'processing']))
        <div class="text-center mb-8">
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');" class="inline-block">
                @csrf
                <button type="submit" class="bg-red-50 text-red-600 border border-red-200 hover:bg-red-100 px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                    Batalkan Pesanan
                </button>
            </form>
        </div>
        @elseif($order->status == 'cancelled')
        <div class="text-center mb-8">
            <span class="inline-block bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-semibold">Pesanan ini telah dibatalkan</span>
        </div>
        @endif

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <h2 class="text-xl font-bold mb-6 text-[#8b5a2b]">Status Pesanan</h2>
            <div class="order-timeline">
                <div class="timeline-item completed">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Pesanan Dibuat</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                <div class="timeline-item {{ $order->payment_status == 'paid' ? 'completed' : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Pembayaran</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->payment_status == 'paid' ? 'Pembayaran telah diterima' : 'Menunggu pembayaran' }}</p>
                    </div>
                </div>
                <div class="timeline-item {{ in_array($order->status, ['processing', 'completed']) ? ($order->status == 'completed' ? 'completed' : 'active') : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Diproses</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ in_array($order->status, ['processing', 'completed']) ? 'Pesanan sedang diproses' : 'Menunggu diproses' }}</p>
                    </div>
                </div>
                <div class="timeline-item {{ $order->status == 'completed' ? 'completed' : '' }}">
                    <div class="timeline-marker"></div>
                    <div class="timeline-content">
                        <h4 class="font-semibold text-gray-800">Selesai</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $order->status == 'completed' ? 'Pesanan telah selesai' : 'Belum selesai' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-1/2">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 h-full">
                    <h2 class="text-xl font-bold mb-6 text-[#8b5a2b] border-b pb-3">Instruksi Pembayaran</h2>

                    @if($order->payment_status == 'paid')
                        <div class="text-center py-8">
                            <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Lunas!</h3>
                            <p class="text-gray-500 text-sm">Terima kasih, pesanan Anda sedang diproses oleh UMKM kami.</p>
                        </div>
                    
                    @elseif($order->payment && $order->payment->payment_method == 'qris')
                        <div class="text-center">
                            <p class="text-sm text-gray-600 mb-4">Scan kode QRIS di bawah ini menggunakan aplikasi M-Banking atau e-Wallet Anda.</p>
                            
                            <div class="bg-white p-4 inline-block rounded-2xl shadow-md border-2 border-[#f4eee6] mb-4">
                                <canvas id="qr-canvas"></canvas>
                            </div>

                            <div id="qris-timer" class="mb-4">
                                <p class="text-xs text-gray-500 mb-1">Sisa waktu pembayaran:</p>
                                <p class="text-2xl font-bold text-[#8b5a2b] font-mono" id="countdown">30:00</p>
                            </div>
                            
                            <p class="font-bold text-lg text-gray-800 mb-1">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</p>

                            <div class="mt-4 bg-gray-50 rounded-xl p-4 text-left">
                                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">E-Wallet yang Didukung</p>
                                <div class="flex flex-wrap justify-center gap-2 text-xs">
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Gopay</span>
                                    <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full">OVO</span>
                                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full">DANA</span>
                                    <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full">ShopeePay</span>
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full">LinkAja</span>
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">Mandiri Pay</span>
                                </div>
                            </div>

                            <p class="text-xs text-red-500 mt-4">*Harap simpan bukti transfer setelah melakukan pembayaran.</p>
                        </div>

                    @elseif($order->payment && $order->payment->payment_method == 'transfer')
                        <div>
                            <p class="text-sm text-gray-600 mb-4">Silakan transfer tepat sesuai nominal di bawah ini ke rekening UMKM KITA:</p>
                            
                            <div class="bg-[#fcfbf9] border border-amber-100 rounded-xl p-5 mb-6">
                                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Bank BCA</p>
                                <p class="text-2xl font-bold text-gray-800 tracking-widest mb-1">8765 4321 00</p>
                                <p class="text-sm text-[#8b5a2b] font-medium">a.n. UMKM KITA BERSAMA</p>
                            </div>

                            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-xl mb-6">
                                <span class="text-gray-600 font-medium">Total Transfer</span>
                                <span class="text-2xl font-bold text-[#8b5a2b]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                    @elseif($order->payment && $order->payment->payment_method == 'cod')
                        <div class="text-center py-8">
                            <div class="w-20 h-20 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Cash on Delivery (COD)</h3>
                            <p class="text-gray-500 text-sm mb-4">Anda akan membayar langsung kepada kurir kami saat pesanan tiba di tujuan.</p>
                            <p class="font-bold text-xl text-[#8b5a2b]">Siapkan Uang Pas: Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="bg-[#f4eee6] p-8 rounded-3xl shadow-sm h-full">
                    <h2 class="text-xl font-bold mb-6 text-gray-800 border-b border-gray-300 pb-3">Rincian Pesanan</h2>
                    
                    <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2">
                        @foreach($order->items as $item)
                        <div class="flex justify-between items-start text-sm">
                            <div class="flex items-center gap-3">
                                @if($item->product && $item->product->image)
                                <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset($item->product->image) }}" alt="{{ $item->product_name }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                @else
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->product_name }}</p>
                                    <p class="text-gray-500 text-xs">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <hr class="border-gray-300 mb-4">
                    
                    <div class="space-y-2 mb-4 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pajak (10%)</span>
                            <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($order->delivery_fee, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <hr class="border-gray-300 mb-4">

                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-800">Total Akhir</span>
                        <span class="font-bold text-xl text-[#8b5a2b]">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-8 bg-white p-4 rounded-xl border border-gray-200">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Pengiriman</h4>
                        <p class="text-sm font-medium text-gray-800">{{ $order->phone }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $order->shipping_address }}</p>
                        @if($order->scheduled_at)
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-0.5">Jadwal Pengiriman</p>
                            <p class="text-sm font-medium text-blue-600">{{ $order->scheduled_at->format('d M Y, H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    @if($order->payment && $order->payment->payment_method == 'qris' && $order->payment_status == 'unpaid')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <script>
        (function() {
            // QR Code generation
            var canvas = document.getElementById('qr-canvas');
            if (canvas) {
                var qrData = 'Bayar UMKM KITA - Order #{{ $order->order_number }} - Total Rp {{ number_format($order->total, 0, ',', '.') }}';
                QRCode.toCanvas(canvas, qrData, { width: 200, margin: 2, color: { dark: '#3e2723', light: '#ffffff' } });
            }

            // Countdown timer
            const created = new Date('{{ $order->created_at->toIso8601String() }}');
            const deadline = new Date(created.getTime() + 30 * 60 * 1000);
            const countdownEl = document.getElementById('countdown');

            function updateTimer() {
                const now = new Date();
                const diff = deadline - now;
                if (diff <= 0) {
                    countdownEl.textContent = '00:00';
                    countdownEl.classList.add('text-red-500');
                    return;
                }
                const mins = Math.floor(diff / 60000);
                const secs = Math.floor((diff % 60000) / 1000);
                countdownEl.textContent = String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
                requestAnimationFrame(updateTimer);
            }
            updateTimer();
        })();
    </script>
    @endif
@endsection
