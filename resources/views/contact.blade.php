@extends('layouts.app')

@section('title', 'Hubungi Kami - UMKM KITA')

@section('styles')
.contact-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(62, 39, 35, 0.7)), url('{{ asset("images/hero/contact-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
.glass-panel {
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid rgba(230, 230, 230, 0.5);
}
@endsection

@section('content')
    <!-- Hero Section -->
    <header class="contact-hero h-[40vh] flex items-center justify-center pt-20 text-center text-white">
        <div class="px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-3">Hubungi Kami</h1>
            <p class="text-sm md:text-base font-light tracking-wide max-w-lg mx-auto text-gray-200">Ada pertanyaan atau butuh bantuan pesanan? Tim kami siap membantu Anda dengan senang hati.</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-16 max-w-6xl -mt-16 relative z-10">
        
        <div class="flex flex-col lg:flex-row gap-10">
            
            <!-- Contact Information Card -->
            <div class="lg:w-1/3 glass-panel p-8 rounded-3xl shadow-xl flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 serif-font mb-6">Informasi Kontak</h2>
                    
                    <div class="space-y-6">
                        <!-- Address -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-[#8b5a2b] flex-shrink-0">
                                📍
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Outlet</h4>
                                <p class="text-sm text-gray-700 font-medium">Iteba, Tiban Ayu,<br>Sekupang,<br>Batam</p>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-[#8b5a2b] flex-shrink-0">
                                📞
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Telepon / WhatsApp</h4>
                                <p class="text-sm text-gray-700 font-medium">+62 815 3682 9053</p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-[#8b5a2b] flex-shrink-0">
                                ✉️
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email</h4>
                                <p class="text-sm text-gray-700 font-medium">hello@umkmkita.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jam Operasional</h4>
                    <p class="text-sm text-gray-700">Senin - Minggu: 09.00 - 22.00 WIB</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:w-2/3 bg-white p-8 md:p-10 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-800 serif-font mb-2">Kirim Pesan</h3>
                <p class="text-gray-500 text-xs mb-8">Isi formulir di bawah ini dan kami akan membalas pesan Anda secepatnya.</p>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-sm text-green-700 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800 bg-gray-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Alamat Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800 bg-gray-50 focus:bg-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Subjek</label>
                        <input type="text" name="subject" required class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800 bg-gray-50 focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Pesan Anda</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800 bg-gray-50 focus:bg-white resize-none"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full md:w-auto px-8 py-3 bg-[#3e2723] hover:bg-black text-white font-medium rounded-xl shadow-md transition duration-200 text-sm">
                            Kirim Pesan Sekarang
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
@endsection
