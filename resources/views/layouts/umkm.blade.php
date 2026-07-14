<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel UMKM') - UMKM KITA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: var(--font-inter); }
        body { background: #f8f6f3; }
        .serif-font { font-family: var(--font-serif); }
        @stack('styles')
    </style>
</head>
<body class="min-h-screen">

    {{-- Desktop Sidebar --}}
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-[#2c1a12] text-white z-40 hidden lg:flex flex-col">
        <div class="p-5 border-b border-white/10">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#8b5a2b] rounded-lg flex items-center justify-center text-white font-bold text-sm">U</div>
                <div>
                    <div class="text-sm font-bold tracking-wide">UMKM KITA</div>
                    <div class="text-[10px] text-white/40 tracking-wider uppercase">Panel Mitra</div>
                </div>
            </a>
        </div>
        <nav class="flex-1 py-4 px-3 space-y-0.5 text-[13px] overflow-y-auto">
            <a href="{{ route('umkm.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.dashboard') ? 'active' : '' }}">
                <svg class="menu-icon w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('umkm.store.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.store.*') ? 'active' : '' }}">
                <svg class="menu-icon w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Toko Saya
            </a>
            <a href="{{ route('umkm.products.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.products.*') ? 'active' : '' }}">
                <svg class="menu-icon w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Produk
            </a>
            <a href="{{ route('umkm.orders.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.orders.*') ? 'active' : '' }}">
                <svg class="menu-icon w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Pesanan
            </a>
            <div class="pt-3 mt-3 border-t border-white/10">
                <a href="{{ route('account.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('account.*') ? 'active' : '' }}">
                    <svg class="menu-icon w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Akun Saya
                </a>
            </div>
        </nav>
        <div class="p-3 border-t border-white/10">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 text-xs text-white/40 hover:text-white/70 rounded-lg hover:bg-white/5 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-xs text-white/40 hover:text-red-400 rounded-lg hover:bg-white/5 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Mobile Header --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 bg-[#2c1a12] text-white z-40 px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button id="mobile-menu-btn" class="p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="font-bold text-sm">UMKM KITA - Panel Mitra</div>
        </div>
        <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="text-xs text-white/50">Logout</button></form>
    </div>

    {{-- Mobile Sidebar --}}
    <div id="mobile-sidebar" class="hidden fixed inset-0 z-50">
        <div id="mobile-overlay" class="absolute inset-0 bg-black/50"></div>
        <aside id="mobile-panel" class="absolute left-0 top-0 h-full w-64 bg-[#2c1a12] transform -translate-x-full transition-transform duration-300 flex flex-col">
            <div class="p-5 border-b border-white/10 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#8b5a2b] rounded-lg flex items-center justify-center text-white font-bold text-xs">U</div>
                    <div class="text-sm font-bold">Panel Mitra</div>
                </div>
                <button id="mobile-close-btn" class="text-white/50 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <nav class="flex-1 py-4 px-3 space-y-0.5 text-[13px]">
                <a href="{{ route('umkm.dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('umkm.store.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.store.*') ? 'active' : '' }}">Toko Saya</a>
                <a href="{{ route('umkm.products.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.products.*') ? 'active' : '' }}">Produk</a>
                <a href="{{ route('umkm.orders.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('umkm.orders.*') ? 'active' : '' }}">Pesanan</a>
                <div class="pt-3 mt-3 border-t border-white/10">
                    <a href="{{ route('account.index') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('account.*') ? 'active' : '' }}">Akun Saya</a>
                    <a href="{{ route('home') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg">Kembali ke Website</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-400 hover:bg-red-500/10 transition">Logout</button>
                    </form>
                </div>
            </nav>
        </aside>
    </div>

    {{-- Main Content --}}
    <main class="lg:ml-64 pt-16 lg:pt-0 min-h-screen">
        <div class="p-4 md:p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-xl text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-xl text-sm">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>

    <script>
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobilePanel = document.getElementById('mobile-panel');
        const mobileOverlay = document.getElementById('mobile-overlay');
        function openMobileMenu() {
            mobileSidebar.classList.remove('hidden');
            requestAnimationFrame(() => mobilePanel.classList.remove('-translate-x-full'));
        }
        function closeMobileMenu() {
            mobilePanel.classList.add('-translate-x-full');
            setTimeout(() => mobileSidebar.classList.add('hidden'), 300);
        }
        document.getElementById('mobile-menu-btn').addEventListener('click', openMobileMenu);
        document.getElementById('mobile-close-btn').addEventListener('click', closeMobileMenu);
        mobileOverlay.addEventListener('click', closeMobileMenu);
    </script>
    @stack('scripts')

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
