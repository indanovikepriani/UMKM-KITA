<x-mail::message>
# Pesanan Berhasil Dibuat! 🎉

Halo **{{ $order->user->name }}**,

Terima kasih telah berbelanja di UMKM KITA. Pesanan Anda telah berhasil dibuat dan sedang menunggu pembayaran.

<x-mail::panel>
**Nomor Pesanan:** #{{ $orderNumber }}<br>
**Tanggal:** {{ $order->created_at->format('d M Y, H:i') }}<br>
**Total:** **Rp {{ number_format($order->total, 0, ',', '.') }}**
</x-mail::panel>

## Rincian Pesanan

@foreach($order->items as $item)
- {{ $item->product_name }} × {{ $item->quantity }} — Rp {{ number_format($item->subtotal, 0, ',', '.') }}
@endforeach

<x-mail::table>
| Keterangan | Nominal |
|:-----------|--------:|
| Subtotal | Rp {{ number_format($order->subtotal, 0, ',', '.') }} |
| Pajak | Rp {{ number_format($order->tax, 0, ',', '.') }} |
| Ongkos Kirim | Rp {{ number_format($order->delivery_fee, 0, ',', '.') }} |
| **Total** | **Rp {{ number_format($order->total, 0, ',', '.') }}** |
</x-mail::table>

@component('mail::panel')
**Metode Pembayaran:** {{ ucfirst($order->payment->payment_method) }}
@endcomponent

Silakan selesaikan pembayaran sesuai instruksi yang tertera di halaman detail pesanan.

<x-mail::button :url="route('orders.show', $order->id)">
Lihat Detail Pesanan
</x-mail::button>

Hormat kami,<br>
**{{ config('app.name', 'UMKM KITA') }}**
</x-mail::message>
