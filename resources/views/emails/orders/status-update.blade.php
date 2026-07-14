<x-mail::message>
# Status Pesanan Diperbarui

Halo **{{ $order->user->name }}**,

Status pesanan Anda telah diperbarui.

<x-mail::panel>
**Nomor Pesanan:** #{{ $orderNumber }}<br>
**Status Sebelumnya:** {{ ucfirst($oldStatus) }}<br>
**Status Terkini:** {{ ucfirst($newStatus) }}<br>
**Total:** **Rp {{ number_format($order->total, 0, ',', '.') }}**
</x-mail::panel>

@if($newStatus === 'processing')
Pesanan Anda sedang diproses oleh UMKM kami. Mohon tunggu informasi selanjutnya.
@elseif($newStatus === 'completed')
Pesanan Anda telah selesai! Terima kasih telah berbelanja di UMKM KITA. Kami harap Anda puas dengan produk yang diterima.
@elseif($newStatus === 'cancelled')
Pesanan Anda telah dibatalkan. Jika ada pertanyaan, silakan hubungi kami.
@endif

<x-mail::button :url="route('orders.show', $order->id)">
Lihat Detail Pesanan
</x-mail::button>

Hormat kami,<br>
**{{ config('app.name', 'UMKM KITA') }}**
</x-mail::message>
