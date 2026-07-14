@extends('layouts.app')

@section('title', 'UMKM KITA - Taste The Best')

@section('styles')
.hero-bg {
    background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), url('{{ asset("images/hero/home-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
.feature-connector {
    position: absolute;
    top: 50%;
    left: 10%;
    right: 10%;
    height: 2px;
    background-color: #d2b48c;
    z-index: 0;
    transform: translateY(-50%);
}
@endsection

@section('content')
<header class="hero-bg h-screen flex items-center pt-16">
    <div class="container mx-auto px-6 md:px-12">
        <div class="max-w-2xl text-white">
            <h1 class="text-5xl md:text-7xl font-bold leading-tight mb-6 text-[#f5ebd9]">Enjoy the perfect<br>Taste!</h1>
            <p class="text-lg md:text-xl mb-8 font-light text-gray-200">Dari makan malam romantis hingga kumpul keluarga, UMKM KITA beradaptasi dengan kebutuhan Anda. Sajian istimewa membuat setiap pertemuan menjadi ekstra spesial.</p>
            <a href="{{ route('menu.index') }}" class="inline-block bg-white text-black font-semibold text-lg px-8 py-4 rounded-full shadow-lg hover:bg-amber-100 hover:scale-105 transition transform duration-300">Place Your Order Now</a>
        </div>
    </div>
</header>

<section class="py-20 relative overflow-hidden bg-gradient-to-b from-white to-[#fdfbf7]">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-16 text-gray-800">Features</h2>
        <div class="relative max-w-4xl mx-auto hidden md:block">
            <div class="feature-connector"></div>
        </div>
        
        <div class="flex flex-col md:flex-row justify-center items-center gap-10 md:gap-20 relative z-10">
            <div class="group cursor-pointer">
                <div class="w-40 h-40 rounded-full border-4 border-[#d2b48c] overflow-hidden shadow-xl transform transition duration-500 group-hover:scale-110">
                    <img src="{{ asset('images/hero/feature-1.jpg') }}" alt="Bahan Segar" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="group cursor-pointer">
                <div class="w-40 h-40 rounded-full border-4 border-[#d2b48c] overflow-hidden shadow-xl transform transition duration-500 group-hover:scale-110">
                    <img src="{{ asset('images/hero/feature-2.jpg') }}" alt="Rasa Autentik" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="group cursor-pointer">
                <div class="w-40 h-40 rounded-full border-4 border-[#d2b48c] overflow-hidden shadow-xl transform transition duration-500 group-hover:scale-110">
                    <img src="{{ asset('images/hero/feature-3.jpg') }}" alt="Pengiriman Cepat" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-[#fdfbf7]">
    <div class="container mx-auto px-6 flex flex-col md:flex-row items-center gap-12">
        <div class="md:w-1/3 flex justify-center">
            <img src="{{ asset('images/hero/chef.jpg') }}" alt="Chef" class="w-64 md:w-80 rounded-2xl shadow-2xl rotate-3 hover:rotate-0 transition duration-500">
        </div>
        <div class="md:w-2/3 max-w-2xl">
            <h2 class="text-4xl font-bold mb-6 text-gray-800">Why Choose Us?</h2>
            <p class="text-gray-600 mb-6 leading-relaxed">Memilih UMKM KITA bukan hanya sekadar memuaskan rasa hunger Anda, ini tentang merangkul pengalaman kuliner yang terasa berkesan dan bermakna. Bahan lokal berkualitas, dimasak dengan sepenuh hati.</p>
            <h3 class="text-xl font-semibold mb-3 text-gray-800">An Atmosphere That Feels Like Home</h3>
            <p class="text-gray-600 leading-relaxed">Dari momen Anda menyantap hidangan kami, cita rasa otentik bumbu nusantara akan menyambut Anda. Baik merayakan momen spesial atau sekadar bersantai setelah hari yang panjang, hidangan kami membuat setiap porsi terasa personal.</p>
        </div>
    </div>
</section>

<section class="py-20 bg-gradient-to-b from-[#fdfbf7] to-[#f4eee6]">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-4xl font-bold mb-16 text-gray-800">Rekomendasi Menu</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            @forelse($featuredProducts->take(4) as $product)
            <div class="glass-card p-6 flex flex-col items-center pt-16 relative mt-16 hover:-translate-y-2 transition duration-300 group">
                <a href="{{ route('menu.show', $product->slug) }}" class="w-40 h-40 rounded-full border-4 border-[#d2b48c] overflow-hidden absolute -top-20 shadow-lg block transform group-hover:scale-105 transition duration-300">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </a>
                <h3 class="text-xl font-bold mt-8 mb-2 hover:text-[#8b5a2b] transition">
                    <a href="{{ route('menu.show', $product->slug) }}">{{ $product->name }}</a>
                </h3>
                <p class="text-gray-500 text-sm mb-4 min-h-[40px]">{{ Str::limit($product->description, 50) }}</p>
                <div class="mt-auto w-full">
                    @if($product->price && $product->price > $product->discount_price)
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-[#8b5a2b] font-bold text-lg">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        </div>
                    @else
                        <p class="text-[#8b5a2b] font-bold text-lg mb-4">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                    @endif
                    @if($product->stock > 0)
                        <a href="{{ route('menu.show', $product->slug) }}" class="w-full bg-[#3e2723] text-white py-2.5 rounded-full hover:bg-black transition text-sm font-semibold text-center block shadow-md">
                            Lihat Detail Menu
                        </a>
                    @else
                        <button type="button" disabled class="w-full bg-gray-200 text-gray-400 py-2.5 rounded-full text-sm font-semibold cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full text-gray-500 italic">Menu belum tersedia. Silakan tambahkan dari panel admin.</div>
            @endforelse
        </div>
        
        <div class="mt-16">
            <a href="{{ route('menu.index') }}" class="text-[#8b5a2b] font-semibold border-b-2 border-[#8b5a2b] pb-1 hover:text-black hover:border-black transition">Lihat Semua Menu ➔</a>
        </div>
    </div>
</section>

<section class="relative py-24 bg-white overflow-hidden border-t border-gray-100">
    <img src="{{ asset('images/hero/feature-3.jpg') }}" class="absolute -left-20 top-1/2 transform -translate-y-1/2 rounded-full shadow-2xl opacity-40 hidden lg:block" alt="Dekorasi kiri">
    <img src="{{ asset('images/hero/feature-3.jpg') }}" class="absolute -right-20 top-1/2 transform -translate-y-1/2 rounded-full shadow-2xl opacity-40 hidden lg:block" alt="Dekorasi kanan">
    <div class="container mx-auto px-6 text-center relative z-10">
        <h2 class="text-4xl md:text-5xl font-bold mb-4 serif-font text-[#3e2723] uppercase tracking-wide">Punya Usaha UMKM?</h2>
        <p class="text-gray-600 mb-10 text-xl">
            Mau produk kamu ditampilin di website <span class="font-bold">UMKM KITA</span>?<br>
            <span class="text-lg font-medium text-gray-500">Mari jalin kerjasama dan majukan usaha lokal bersama! Silahkan hubungi kami.</span>
        </p>
        <div class="max-w-md mx-auto flex justify-center">
            <a href="https://wa.me/6281234567890?text=Halo%20Admin%20UMKM%20KITA,%20saya%20punya%20usaha%20dan%20tertarik%20ingin%20menampilkan%20produk%20saya%20di%20website%20Anda." target="_blank" class="bg-[#25D366] text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-[#1ebe57] transition flex items-center gap-3 shadow-xl hover:shadow-2xl hover:-translate-y-1 transform duration-300">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.012c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                </svg>
                Hubungi Admin via WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection
