@extends('layouts.admin')

@section('title', 'Edit Pesanan #' . $order->order_number)

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold serif-font text-gray-800">Edit Pesanan</h1>
    <p class="text-gray-500">Mengubah status pesanan, pembayaran, dan catatan untuk pesanan #{{ $order->order_number }}</p>
    
    <div class="mt-4 flex items-center space-x-3">
        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-sm text-[#8b5a2b] hover:text-[#8b5a2b]/80">
            ← Kembali ke Detail Pesanan
        </a>
    </div>
</div>

{{-- Form Edit Pesanan --}}
<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kolom Kiri: Status Pesanan --}}
            <div class="space-y-4">
                <h2 class="text-lg font-medium text-gray-800">Status Pesanan</h2>
                
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#8b5a2b] focus:border-[#8b5a2b] bg-gray-50">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                    <select name="payment_status" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#8b5a2b] focus:border-[#8b5a2b] bg-gray-50">
                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                        <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>
            </div>
            
            {{-- Kolom Kanan: Informasi Pesanan --}}
            <div class="space-y-4">
                <h2 class="text-lg font-medium text-gray-800">Informasi Pesanan</h2>
                
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Nomor Pesanan</label>
                    <p class="px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 font-mono text-sm">{{ $order->order_number }}</p>
                </div>
                
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Pelanggan</label>
                    <p class="px-4 py-3 rounded-xl border border-gray-200 bg-gray-50">{{ $order->user->name ?? 'Tidak Diketahui' }}</p>
                </div>
                
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Tanggal Pesanan</label>
                    <p class="px-4 py-3 rounded-xl border border-gray-200 bg-gray-50">{{ $order->created_at->format('d F Y, H:i') }}</p>
                </div>
                
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Total Pesanan</label>
                    <p class="px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 font-bold text-lg text-[#8b5a2b]">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Catatan Admin --}}
        <div class="border-t pt-6">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Catatan Admin</h2>
            
            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
                <textarea name="notes" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#8b5a2b] focus:border-[#8b5a2b] bg-gray-50 placeholder-gray-400">{{ old('notes', $order->notes) }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Catatan ini hanya visible untuk admin dan tidak akan dikirim ke pelanggan.</p>
            </div>
        </div>
        
        {{-- Tombol Aksi --}}
        <div class="mt-8 pt-6 border-t">
            <div class="flex justify-end space-x-4">
                <button type="button" 
                        onclick="window.history.back()"
                        class="px-6 py-3 rounded-xl font-medium text-gray-700 bg-gray-50 hover:bg-gray-100 transition">
                    Batal
                </button>
                
                <button type="submit" 
                        class="px-6 py-3 rounded-xl font-medium text-white bg-[#8b5a2b] hover:bg-black transition">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Tambahkan validasi atau interaktivitas jika diperlukan
    document.addEventListener('DOMContentLoaded', function() {
        // Fokus ke field pertama saat form dimuat
        const form = document.querySelector('form');
        if (form) {
            const firstInput = form.querySelector('select, textarea, input');
            if (firstInput) {
                firstInput.focus();
            }
        }
    });
</script>
@endpush