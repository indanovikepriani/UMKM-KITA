<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMKM KITA')</title>
    <meta name="description" content="@yield('meta_description', 'UMKM KITA - Marketplace kuliner UMKM terpercaya di Batam. Temukan berbagai makanan dan minuman lezat dari UMKM lokal.')">
    <meta property="og:title" content="@yield('og_title', 'UMKM KITA')">
    <meta property="og:description" content="@yield('og_description', 'Marketplace kuliner UMKM terpercaya di Batam. Temukan berbagai makanan dan minuman lezat dari UMKM lokal.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🍳</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #fcfbf9; color: #333; }
        @yield('styles')
    </style>
</head>
<body class="antialiased flex flex-col min-h-screen">

    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[200] focus:bg-white focus:text-[#3e2723] focus:px-4 focus:py-2 focus:rounded-lg focus:shadow-lg focus:font-semibold">Langsung ke konten</a>

    <nav class="fixed top-0 left-0 w-full z-50 p-6 flex justify-between items-center text-white bg-[#3e2723]/90 backdrop-blur-md shadow-md" role="navigation" aria-label="Navigasi utama">
        <div class="text-2xl font-bold serif-font tracking-wider">
            <a href="{{ route('home') }}">UMKM KITA</a>
        </div>
        <div class="hidden md:flex space-x-8 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-amber-300 transition {{ request()->routeIs('home') ? 'text-amber-300' : '' }}">Home</a>
            <a href="{{ route('stores.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('stores.*') ? 'text-amber-300' : '' }}">Toko</a>
            <a href="{{ route('menu.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('menu.*') ? 'text-amber-300' : '' }}">Menu</a>
            <a href="{{ route('about') }}" class="hover:text-amber-300 transition {{ request()->routeIs('about') ? 'text-amber-300' : '' }}">About Us</a>
            <a href="{{ route('contact.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('contact.*') ? 'text-amber-300' : '' }}">Contact</a>
            <a href="{{ route('testimonials.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('testimonials.*') ? 'text-amber-300' : '' }}">Review User</a>
            <a href="{{ route('tracking.index') }}" class="hover:text-amber-300 transition {{ request()->routeIs('tracking.*') ? 'text-amber-300' : '' }}">Lacak Pesanan</a>
        </div>
        <div class="hidden md:flex space-x-4 items-center">
            <a href="{{ route('cart.index') }}" class="hover:text-amber-300" aria-label="Keranjang belanja">
                <svg class="w-5 h-5 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                Keranjang
            </a>
            @auth
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="bg-[#8b5a2b] px-4 py-2 rounded-full hover:bg-[#6f4620] transition text-sm font-semibold">Admin Panel</a>
                @endif
                @if(Auth::user()->role === 'umkm')
                <a href="{{ route('umkm.dashboard') }}" class="bg-[#8b5a2b] px-4 py-2 rounded-full hover:bg-[#6f4620] transition text-sm font-semibold">Panel UMKM</a>
                @endif
                <a href="{{ route('account.index') }}" class="bg-white/20 px-4 py-2 rounded-full hover:bg-white hover:text-black transition">Akun Saya</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500/80 px-4 py-2 rounded-full hover:bg-red-600 transition text-sm font-semibold">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-white text-black px-5 py-2 rounded-full font-semibold hover:bg-amber-100 transition">Login / Register</a>
            @endauth
        </div>
        <button id="mobile-menu-btn" class="md:hidden p-2 -mr-2" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobile-sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </nav>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true" aria-label="Menu navigasi mobile">
        <div id="mobile-overlay" class="absolute inset-0 bg-black/50"></div>
        <div id="mobile-panel" class="absolute top-0 left-0 h-full w-72 bg-[#3e2723] text-white shadow-xl transform -translate-x-full transition-transform duration-300">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <span class="text-xl font-bold serif-font">UMKM KITA</span>
                    <button id="mobile-close-btn" class="p-2 -mr-2 hover:text-amber-300" aria-label="Tutup menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('home') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Home</a>
                    <a href="{{ route('stores.index') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Toko</a>
                    <a href="{{ route('menu.index') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Menu</a>
                    <a href="{{ route('about') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">About Us</a>
                    <a href="{{ route('contact.index') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Contact</a>
                    <a href="{{ route('testimonials.index') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Review User</a>
                    <a href="{{ route('tracking.index') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Lacak Pesanan</a>
                </nav>
                <hr class="border-white/20 my-6">
                <div class="space-y-2">
                    <a href="{{ route('cart.index') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Keranjang</a>
                    @auth
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 rounded-xl bg-[#8b5a2b] hover:bg-[#6f4620] transition font-semibold">Admin Panel</a>
                        @endif
                        @if(Auth::user()->role === 'umkm')
                        <a href="{{ route('umkm.dashboard') }}" class="block py-3 px-4 rounded-xl bg-[#8b5a2b] hover:bg-[#6f4620] transition font-semibold">Panel UMKM</a>
                        @endif
                        <a href="{{ route('account.index') }}" class="block py-3 px-4 rounded-xl hover:bg-white/10 transition font-medium">Akun Saya</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left py-3 px-4 rounded-xl hover:bg-red-500/20 transition font-medium text-red-400">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block py-3 px-4 rounded-xl bg-white text-[#3e2723] text-center font-semibold hover:bg-amber-100 transition">Login / Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <main id="main-content" class="flex-1">
    @yield('content')
    </main>

    <footer class="bg-[#3e2723] text-white mt-auto">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold serif-font tracking-wider mb-4">UMKM KITA</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">
                        Marketplace kuliner UMKM terpercaya di Batam. Menghubungkan Anda dengan cita rasa autentik dari para pelaku UMKM lokal.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="text-gray-400 hover:text-amber-300 transition" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-amber-300 transition" aria-label="Instagram">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 016.11 2.525c.636-.247 1.363-.416 2.427-.465C8.88 2.013 9.235 2 11.667 2h.648zm-.08 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/></svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-amber-300 transition" aria-label="WhatsApp">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Navigasi</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-300 transition">Home</a></li>
                        <li><a href="{{ route('stores.index') }}" class="hover:text-amber-300 transition">Toko</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-amber-300 transition">Menu</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-amber-300 transition">About Us</a></li>
                        <li><a href="{{ route('contact.index') }}" class="hover:text-amber-300 transition">Contact</a></li>
                        <li><a href="{{ route('testimonials.index') }}" class="hover:text-amber-300 transition">Review User</a></li>
                        <li><a href="{{ route('faq.index') }}" class="hover:text-amber-300 transition">FAQ</a></li>
                        <li><a href="{{ route('terms.index') }}" class="hover:text-amber-300 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Kontak</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex items-start space-x-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Batam, Kepulauan Riau</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 flex-shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4 flex-shrink-0 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>info@umkmkita.com</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Jam Operasional</h4>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li class="flex justify-between">
                            <span>Senin - Jumat</span>
                            <span class="font-medium text-white">08:00 - 18:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sabtu</span>
                            <span class="font-medium text-white">08:00 - 15:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Minggu</span>
                            <span class="text-gray-500">Libur</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-600/50 py-6">
            <div class="container mx-auto px-6 text-center text-sm text-gray-400">
                &copy; 2026 UMKM KITA by Nowfey Computer. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobilePanel = document.getElementById('mobile-panel');
        const mobileOverlay = document.getElementById('mobile-overlay');
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');

        function openMobileMenu() {
            mobileSidebar.classList.remove('hidden');
            mobileMenuBtn.setAttribute('aria-expanded', 'true');
            requestAnimationFrame(() => mobilePanel.classList.remove('-translate-x-full'));
            document.getElementById('mobile-close-btn').focus();
        }
        function closeMobileMenu() {
            mobilePanel.classList.add('-translate-x-full');
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
            setTimeout(() => mobileSidebar.classList.add('hidden'), 300);
            mobileMenuBtn.focus();
        }

        mobileMenuBtn.addEventListener('click', openMobileMenu);
        document.getElementById('mobile-close-btn').addEventListener('click', closeMobileMenu);
        mobileOverlay.addEventListener('click', closeMobileMenu);
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !mobileSidebar.classList.contains('hidden')) {
                closeMobileMenu();
            }
        });
    </script>

    <!-- Back to Top Button -->
    <button id="back-to-top" onclick="window.scrollTo({top:0,behavior:'smooth'})" class="hidden fixed bottom-6 right-6 w-12 h-12 bg-[#8b5a2b] text-white rounded-full shadow-lg hover:bg-[#6f4620] transition z-50 flex items-center justify-center" aria-label="Kembali ke atas">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
    </button>
    <script>
        window.addEventListener('scroll', function() {
            var btn = document.getElementById('back-to-top');
            if (window.scrollY > 300) { btn.classList.remove('hidden'); btn.classList.add('flex'); }
            else { btn.classList.add('hidden'); btn.classList.remove('flex'); }
        });
    </script>

    @yield('scripts')

    <script>
        document.addEventListener('submit', function(e) {
            var btn = e.target.querySelector('button[type="submit"]');
            if (btn && !btn.classList.contains('btn-loading')) {
                btn.classList.add('btn-loading');
                var originalText = btn.innerHTML;
                btn.setAttribute('data-original', originalText);
                btn.innerHTML = '<svg class="w-4 h-4 inline animate-spin mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> Memproses...';
                btn.disabled = true;
            }
        });
    </script>
</body>
</html>
