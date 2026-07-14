@extends('layouts.app')
@section('title', 'Tentang Kami - UMKM KITA')
@section('styles')
.about-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(62, 39, 35, 0.8)), url('{{ asset("images/hero/about-hero.jpg") }}');
    background-size: cover;
    background-position: center;
    background-attachment: scroll;
    @media (min-width: 768px) {
        background-attachment: fixed;
    }
}
.image-pattern {
    background-image: radial-gradient(#d2b48c 2px, transparent 2px);
    background-size: 20px 20px;
}
@endsection
@section('content')
<!-- Hero Section -->
<header class="about-hero h-[50vh] flex items-center justify-center pt-20 text-center text-white">
    <div class="px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-4">Cerita Di Balik Rasa</h1>
        <p class="text-sm md:text-base font-light tracking-wide max-w-lg mx-auto text-gray-200">Dedikasi kami untuk melestarikan resep warisan nusantara dengan sentuhan kebersihan dan kualitas modern.</p>
    </div>
</header>

<!-- Story Section -->
<main class="container mx-auto px-6 py-20 max-w-6xl">
    <div class="flex flex-col md:flex-row items-center gap-16">
        <div class="md:w-1/2 relative">
            <div class="image-pattern absolute -top-6 -left-6 w-32 h-32 rounded-xl z-0"></div>
            <img src="{{ asset('images/hero/about-kitchen.jpg') }}" alt="Dapur UMKM KITA" class="rounded-3xl shadow-2xl relative z-10 w-full h-[400px] object-cover border-4 border-white">
            <div class="absolute -bottom-8 -right-8 bg-[#3e2723] text-white p-6 rounded-2xl z-20 shadow-xl hidden md:block">
                <p class="text-3xl font-bold serif-font mb-1 text-amber-300">10+</p>
                <p class="text-xs uppercase tracking-wider font-semibold">Tahun Pengalaman</p>
            </div>
        </div>
        <div class="md:w-1/2">
            <h3 class="text-[#8b5a2b] font-semibold tracking-wider uppercase text-xs mb-2">Awal Mula Kami</h3>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 serif-font mb-6">Berawal dari Dapur Kecil Keluarga</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                UMKM KITA didirikan dengan satu tujuan sederhana: membawa kehangatan masakan rumah ke meja makan Anda. Kami percaya bahwa setiap hidangan memiliki cerita, dan bahan-bahan lokal terbaik adalah kunci dari cita rasa otentik yang tak terlupakan.
            </p>
            <p class="text-gray-600 text-sm leading-relaxed mb-8">
                Bekerja sama dengan petani dan peternak lokal, kami memastikan setiap bahan yang masuk ke dapur kami adalah yang paling segar. Misi kami bukan sekadar menjual makanan, melainkan membagikan kebahagiaan dalam setiap suapan.
            </p>
            <a href="{{ route('menu.index') }}" class="inline-block border-2 border-[#3e2723] text-[#3e2723] hover:bg-[#3e2723] hover:text-white font-medium px-8 py-3 rounded-full transition duration-300 text-sm">
                Lihat Menu Kami
            </a>
        </div>
    </div>
</main>

<!-- Nilai Kami (Values) -->
<section class="bg-[#f5ebd9]/30 py-20 border-y border-gray-200/50">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h2 class="text-3xl font-bold text-gray-800 serif-font mb-12">Mengapa Memilih Kami?</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Value 1 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">🌱</div>
                <h3 class="text-lg font-bold text-gray-800 serif-font mb-2">Bahan Segar & Lokal</h3>
                <p class="text-gray-500 text-xs leading-relaxed">Kami memberdayakan petani lokal untuk mendapatkan bahan baku paling segar dan berkualitas tinggi setiap harinya.</p>
            </div>
            <!-- Value 2 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">👨‍🍳</div>
                <h3 class="text-lg font-bold text-gray-800 serif-font mb-2">Resep Otentik</h3>
                <p class="text-gray-500 text-xs leading-relaxed">Diolah menggunakan resep rahasia turun-temurun tanpa bahan pengawet buatan, menjaga keaslian rasa.</p>
            </div>
            <!-- Value 3 -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-14 h-14 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">✨</div>
                <h3 class="text-lg font-bold text-gray-800 serif-font mb-2">Higienis & Bersih</h3>
                <p class="text-gray-500 text-xs leading-relaxed">Standar kebersihan adalah prioritas utama kami. Dapur dan proses pengemasan diawasi dengan ketat.</p>
            </div>
        </div>
    </div>
</section>

<!-- Tim Kami -->
<section class="py-20">
    <div class="container mx-auto px-6 max-w-6xl text-center">
        <h3 class="text-[#8b5a2b] font-semibold tracking-wider uppercase text-xs mb-2">Tim Kami</h3>
        <h2 class="text-3xl font-bold text-gray-800 serif-font mb-12">Orang-Orang di Balik UMKM KITA</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-24 h-24 bg-amber-100 rounded-full mx-auto mb-4 flex items-center justify-center text-3xl">👩‍💼</div>
                <h4 class="font-bold text-gray-800 serif-font">Sari Dewi</h4>
                <p class="text-xs text-[#8b5a2b] font-medium mb-3">Founder & CEO</p>
                <p class="text-gray-500 text-xs leading-relaxed">Berdedikasi untuk memberdayakan UMKM lokal dan membawa produk mereka ke pasar yang lebih luas.</p>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-24 h-24 bg-amber-100 rounded-full mx-auto mb-4 flex items-center justify-center text-3xl">👨‍🍳</div>
                <h4 class="font-bold text-gray-800 serif-font">Budi Santoso</h4>
                <p class="text-xs text-[#8b5a2b] font-medium mb-3">Head Chef</p>
                <p class="text-gray-500 text-xs leading-relaxed">Ahli kuliner dengan pengalaman lebih dari 15 tahun mengolah masakan tradisional Nusantara.</p>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="w-24 h-24 bg-amber-100 rounded-full mx-auto mb-4 flex items-center justify-center text-3xl">👨‍💻</div>
                <h4 class="font-bold text-gray-800 serif-font">Andi Pratama</h4>
                <p class="text-xs text-[#8b5a2b] font-medium mb-3">Tech Lead</p>
                <p class="text-gray-500 text-xs leading-relaxed">Membangun platform digital yang memudahkan pelanggan menemukan produk UMKM berkualitas.</p>
            </div>
        </div>
    </div>
</section>
@endsection
