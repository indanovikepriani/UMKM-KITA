<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara memesan makanan di UMKM KITA?',
                'answer' => 'Pilih menu favorit Anda, masukkan ke keranjang, lalu lakukan checkout. Anda bisa memilih pengiriman kurir atau ambil sendiri di toko.',
                'category' => 'Pemesanan',
            ],
            [
                'question' => 'Metode pembayaran apa yang diterima?',
                'answer' => 'Kami menerima pembayaran melalui QRIS (Gopay, OVO, DANA, ShopeePay, LinkAja), transfer bank, dan COD (Cash on Delivery) untuk pengiriman kurir.',
                'category' => 'Pembayaran',
            ],
            [
                'question' => 'Bagaimana cara melacak status pesanan saya?',
                'answer' => 'Anda bisa melacak pesanan melalui halaman "Pesanan Saya" di akun Anda, atau gunakan fitur "Lacak Pesanan" di halaman tracking tanpa perlu login.',
                'category' => 'Pesanan',
            ],
            [
                'question' => 'Bisakah saya menjadwalkan pengiriman untuk waktu tertentu?',
                'answer' => 'Ya, saat checkout Anda bisa memilih opsi "Jadwalkan Pengiriman" dan memilih tanggal serta jam pengiriman yang diinginkan.',
                'category' => 'Pengiriman',
            ],
            [
                'question' => 'Berapa lama waktu pengiriman?',
                'answer' => 'Waktu estimasi pengiriman bervariasi tergantung lokasi Anda dan toko yang dipilih. Rata-rata waktu pengiriman adalah 30-60 menit untuk area Batam.',
                'category' => 'Pengiriman',
            ],
            [
                'question' => 'Bagaimana jika pesanan saya batal atau salah?',
                'answer' => 'Anda bisa membatalkan pesanan selama status masih "Menunggu" atau "Diproses". Hubungi kami atau ubah status pesanan melalui halaman detail pesanan.',
                'category' => 'Pesanan',
            ],
            [
                'question' => 'Bagaimana cara menjadi mitra UMKM di platform ini?',
                'answer' => 'Hubungi kami melalui WhatsApp atau halaman kontak. Tim kami akan membantu proses pendaftaran dan verifikasi toko Anda.',
                'category' => 'Mitra',
            ],
            [
                'question' => 'Apakah ada minimal pesanan?',
                'answer' => 'Minimal pesanan ditentukan oleh masing-masing toko. Informasi ini terlihat di halaman detail toko sebelum Anda melakukan pemesanan.',
                'category' => 'Pemesanan',
            ],
            [
                'question' => 'Bagaimana cara mengubah profil atau password?',
                'answer' => 'Klik "Akun Saya" di navigasi, lalu ubah data profil atau password Anda di form yang tersedia.',
                'category' => 'Akun',
            ],
            [
                'question' => 'Bagaimana cara memberikan ulasan untuk produk?',
                'answer' => 'Setelah pesanan selesai, Anda bisa memberikan ulasan dan rating bintang melalui halaman detail pesanan atau halaman produk.',
                'category' => 'Lainnya',
            ],
        ];

        return view('faq', compact('faqs'));
    }
}
