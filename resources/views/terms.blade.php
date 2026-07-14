@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - UMKM KITA')

@section('styles')
.terms-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(62, 39, 35, 0.8)), url('{{ asset("images/hero/contact-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
@endsection

@section('content')
<header class="terms-hero h-[40vh] flex items-center justify-center pt-20 text-center text-white">
    <div class="px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-4">Syarat & Ketentuan</h1>
        <p class="text-sm md:text-base font-light text-gray-200">Ketahui lebih lanjut tentang penggunaan platform UMKM KITA</p>
    </div>
</header>

<main class="container mx-auto px-6 py-16 max-w-3xl">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
        <p class="text-xs text-gray-400 mb-8">Terakhir diperbarui: 14 Juli 2026</p>

        <div class="space-y-8 text-sm text-gray-600 leading-relaxed">
            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">1. Penerimaan Syarat</h2>
                <p>Dengan mengakses dan menggunakan platform UMKM KITA, Anda setuju untuk terikat oleh syarat dan ketentuan ini. Jika Anda tidak setuju dengan syarat ini, mohon untuk tidak menggunakan layanan kami.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">2. Deskripsi Layanan</h2>
                <p>UMKM KITA adalah platform marketplace yang menghubungkan pelanggan dengan UMKM (Usaha Mikro Kecil dan Menengah) lokal di area Batam. Kami menyediakan layanan pemesanan makanan dan minuman dari mitra UMKM terdaftar.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">3. Akun Pengguna</h2>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>Anda harus berusia minimal 17 tahun atau memiliki izin dari orang tua/wali untuk membuat akun.</li>
                    <li>Informasi yang Anda berikan harus akurat dan terkini.</li>
                    <li>Anda bertanggung jawab menjaga kerahasiaan akun dan kata sandi Anda.</li>
                    <li>Satu akun hanya boleh digunakan oleh satu orang.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">4. Pemesanan & Pembayaran</h2>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>Semua harga yang tercantum sudah termasuk pajak yang berlaku.</li>
                    <li>Pembayaran harus dilakukan sebelum atau saat pengiriman sesuai metode yang dipilih.</li>
                    <li>Kami menerima pembayaran melalui QRIS, transfer bank, dan COD.</li>
                    <li>Pesanan yang sudah dikonfirmasi tidak dapat dibatalkan setelah status berubah menjadi "Selesai".</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">5. Pengiriman</h2>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>Estimasi waktu pengiriman bersifat estimasi dan dapat berubah tergantung kondisi.</li>
                    <li>Biaya pengiriman ditentukan berdasarkan jarak dan ditampilkan saat checkout.</li>
                    <li>Pelanggan dapat memilih pengiriman kurir atau pengambilan sendiri (self-pickup).</li>
                    <li>Pengambilan sendiri (self-pickup) tidak dikenakan biaya pengiriman.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">6. Pembatalan & Pengembalian</h2>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>Pembatalan hanya dapat dilakukan selama status pesanan masih "Menunggu" atau "Diproses".</li>
                    <li>Pengembalian dana akan diproses dalam waktu 1-3 hari kerja setelah pembatalan disetujui.</li>
                    <li>Klaim atas pesanan yang rusak atau salah harus dilakukan dalam waktu 1 jam setelah diterima.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">7. Ulasan & Konten Pengguna</h2>
                <ul class="list-disc list-inside space-y-2 ml-4">
                    <li>Ulasan yang Anda berikan harus jujur dan tidak mengandung konten yang menyinggung.</li>
                    <li>UMKM KITA berhak menghapus ulasan yang melanggar pedoman komunitas.</li>
                    <li>Anda memberikan lisensi kepada UMKM KITA untuk menampilkan ulasan Anda di platform.</li>
                </ul>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">8. Privasi</h2>
                <p>Data pribadi Anda akan dikelola sesuai dengan kebijakan privasi kami. Kami tidak akan membagikan data pihak ketiga tanpa persetujuan Anda, kecuali diwajibkan oleh hukum.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">9. Batasan Tanggung Jawab</h2>
                <p>UMKM KITA bertindak sebagai perantara antara pelanggan dan mitra UMKM. Kami tidak bertanggung jawab atas kualitas produk yang disediakan oleh mitra, namun kami berkomitmen untuk menyelesaikan setiap keluhan dengan adil.</p>
            </section>

            <section>
                <h2 class="text-lg font-bold text-gray-800 serif-font mb-3">10. Perubahan Ketentuan</h2>
                <p>UMKM KITA berhak mengubah syarat dan ketentuan ini sewaktu-waktu. Perubahan akan diberitahukan melalui platform dan berlaku efektif sejak tanggal publikasi.</p>
            </section>
        </div>

        <div class="mt-10 pt-8 border-t border-gray-100 text-center">
            <p class="text-gray-500 text-sm mb-4">Pertanyaan tentang syarat & ketentuan?</p>
            <a href="{{ route('contact.index') }}" class="inline-block bg-[#8b5a2b] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition text-sm">
                Hubungi Kami
            </a>
        </div>
    </div>
</main>
@endsection
