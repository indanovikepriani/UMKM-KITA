@extends('layouts.app')

@section('title', 'Checkout - UMKM KITA')

@section('styles')
    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
@endsection

@section('content')
    <main class="container mx-auto px-4 py-10 max-w-6xl flex-grow">
        <h1 class="text-3xl md:text-4xl font-bold serif-font text-gray-800 mb-8">Checkout Pesanan</h1>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                <p class="font-bold mb-1">Gagal memproses pesanan, mohon periksa kembali:</p>
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" class="flex flex-col lg:flex-row gap-8">
            @csrf

            <div class="w-full lg:w-2/3 space-y-6">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4 text-[#8b5a2b] border-b pb-2">Data Pembeli</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name ?? '' }}" required class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                            <input type="number" name="phone" required class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition" placeholder="08123456789">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4 text-[#8b5a2b] border-b pb-2">Metode Pengiriman</h2>
                    <div class="flex flex-col gap-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-amber-50 transition has-[:checked]:border-[#8b5a2b] has-[:checked]:bg-amber-50/30">
                            <input type="radio" name="delivery_option" value="kurir" class="w-5 h-5 text-[#8b5a2b] focus:ring-[#8b5a2b]" checked>
                            <div class="ml-3">
                                <span class="block font-medium text-gray-800">Kirim via Kurir</span>
                                <span class="block text-sm text-gray-500">Pesanan akan diantar ke alamat Anda.</span>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-amber-50 transition has-[:checked]:border-[#8b5a2b] has-[:checked]:bg-amber-50/30">
                            <input type="radio" name="delivery_option" value="pickup" class="w-5 h-5 text-[#8b5a2b] focus:ring-[#8b5a2b]">
                            <div class="ml-3">
                                <span class="block font-medium text-gray-800">Ambil Sendiri (Pick Up)</span>
                                <span class="block text-sm text-gray-500">Ambil pesanan langsung ke lokasi UMKM. (Tidak bisa COD)</span>
                            </div>
                        </label>
                    </div>

                    <div class="mt-4" id="address_container">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Pengiriman</label>
                        <textarea name="address" rows="3" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition" placeholder="Nama jalan, RT/RW, patokan rumah..."></textarea>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4 text-[#8b5a2b] border-b pb-2">Jadwalkan Pesanan</h2>
                    <p class="text-sm text-gray-500 mb-4">Pilih tanggal & waktu jika ingin pesanan diantar nanti. Kosongkan untuk pesanan sekarang.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal (Opsional)</label>
                            <input type="date" name="schedule_date" min="{{ date('Y-m-d') }}" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Waktu</label>
                            <input type="time" name="schedule_time" class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition text-sm">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4 text-[#8b5a2b] border-b pb-2">Metode Pembayaran</h2>
                    <div class="flex flex-col gap-3">
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-amber-50 transition has-[:checked]:border-[#8b5a2b] has-[:checked]:bg-amber-50/30">
                            <input type="radio" name="payment_method" value="transfer" class="w-5 h-5 text-[#8b5a2b] focus:ring-[#8b5a2b]" checked>
                            <span class="ml-3 font-medium text-gray-800">Transfer Bank</span>
                        </label>
                        <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-amber-50 transition has-[:checked]:border-[#8b5a2b] has-[:checked]:bg-amber-50/30">
                            <input type="radio" name="payment_method" value="qris" class="w-5 h-5 text-[#8b5a2b] focus:ring-[#8b5a2b]">
                            <span class="ml-3 font-medium text-gray-800">QRIS (Otomatis Generate)</span>
                        </label>
                        <label id="cod_container" class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-amber-50 transition has-[:checked]:border-[#8b5a2b] has-[:checked]:bg-amber-50/30">
                            <input type="radio" name="payment_method" id="payment_cod" value="cod" class="w-5 h-5 text-[#8b5a2b] focus:ring-[#8b5a2b]">
                            <div class="ml-3">
                                <span class="block font-medium text-gray-800">Cash on Delivery (COD)</span>
                                <span class="block text-xs text-gray-500">Bayar saat pesanan tiba.</span>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-[#f4eee6] p-6 rounded-3xl shadow-md sticky top-6">
                    <h2 class="text-xl font-bold serif-font text-gray-800 mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-6 max-h-60 overflow-y-auto pr-2 custom-scroll">
                        @forelse($cartItems as $item)
                            <div class="flex justify-between items-start text-sm border-b border-gray-300/40 pb-3">
                                <div>
                                    <span class="text-gray-800 font-medium block">{{ $item->product->name ?? $item->name ?? 'Produk' }}</span>
                                    <span class="text-gray-500 text-xs">Jumlah: x{{ $item->quantity ?? $item->qty ?? 1 }}</span>
                                </div>
                                <span class="font-semibold text-gray-800">Rp {{ number_format($item->subtotal ?? ($item->product->price ?? $item->price ?? 0) * ($item->quantity ?? $item->qty ?? 1), 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center italic">Keranjang Anda masih kosong.</p>
                        @endforelse
                    </div>

                    <hr class="border-gray-300 mb-4">

                    <div class="space-y-3 mb-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal Produk</span>
                            <span class="font-medium text-gray-800" id="summary-subtotal">Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pajak ({{ ($taxRate ?? 0.10) * 100 }}%)</span>
                            <span class="font-medium text-gray-800" id="summary-tax">Rp {{ number_format($tax ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium text-gray-800" id="summary-shipping">Rp {{ number_format($deliveryFee ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <hr class="border-gray-300 mb-4">
                    
                    <div class="flex justify-between items-center mb-6">
                        <span class="font-bold text-lg text-gray-800">Total Pembayaran</span>
                        <span class="font-bold text-2xl text-[#8b5a2b]" id="summary-total">Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="w-full bg-[#3e2723] hover:bg-black text-white py-4 rounded-xl transition text-base font-bold tracking-wide shadow-lg flex justify-center items-center gap-2 transform hover:-translate-y-1">
                        Buat Pesanan
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-4">Dengan menekan tombol ini, Anda menyetujui syarat & ketentuan yang berlaku.</p>
                </div>
            </div>
        </form>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deliveryRadios = document.querySelectorAll('input[name="delivery_option"]');
            const paymentCOD = document.getElementById('payment_cod');
            const codContainer = document.getElementById('cod_container');
            const paymentTransfer = document.querySelector('input[value="transfer"]');
            const addressTextarea = document.querySelector('textarea[name="address"]');

            const subtotal = {{ $subtotal ?? 0 }};
            const tax = {{ $tax ?? 0 }};
            const shippingFee = {{ $deliveryFee ?? 10000 }};
            const shippingEl = document.getElementById('summary-shipping');
            const totalEl = document.getElementById('summary-total');

            function formatRupiah(num) {
                return 'Rp ' + num.toLocaleString('id-ID');
            }

            deliveryRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'pickup') {
                        paymentCOD.disabled = true;
                        codContainer.classList.add('opacity-50', 'cursor-not-allowed');
                        addressTextarea.removeAttribute('required');
                        if (paymentCOD.checked) {
                            paymentTransfer.checked = true;
                        }
                        shippingEl.textContent = formatRupiah(0);
                        totalEl.textContent = formatRupiah(subtotal + tax);
                    } else {
                        paymentCOD.disabled = false;
                        codContainer.classList.remove('opacity-50', 'cursor-not-allowed');
                        addressTextarea.setAttribute('required', 'required');
                        shippingEl.textContent = formatRupiah(shippingFee);
                        totalEl.textContent = formatRupiah(subtotal + tax + shippingFee);
                    }
                });
            });
        });
    </script>
@endsection
