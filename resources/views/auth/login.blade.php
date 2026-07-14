@extends('layouts.app')

@section('title', 'Login - UMKM KITA')

@section('styles')
.auth-body {
    background-color: hsl(40, 72%, 69%);
}
.food-bg {
    background-image: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.5)), url('{{ asset("images/hero/auth-bg.jpg") }}');
    background-size: cover;
    background-position: center;
}
@endsection

@section('content')
<div class="auth-body min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row min-h-[550px]">
        
        <div class="md:w-1/2 food-bg p-12 text-white flex flex-col justify-between relative min-h-[250px] md:min-h-auto">
            <div>
                <a href="{{ route('home') }}" class="text-2xl font-bold serif-font tracking-wider text-[#f5ebd9] hover:text-white transition">➔ UMKM KITA</a>
            </div>
            <div>
                <h2 class="text-3xl font-bold serif-font text-[#f5ebd9] mb-2">Cita Rasa Lokal</h2>
                <p class="text-gray-200 text-xs font-light tracking-wide">Jelajahi kelezatan kuliner nusantara terbaik di platform kami.</p>
            </div>
            <div class="text-[10px] text-gray-400">
                &copy; 2026 UMKM KITA by Nowfey Computer.
            </div>
        </div>

        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800 serif-font">Selamat Datang</h3>
                <p class="text-gray-400 text-xs mt-1">Silahkan masuk ke akun Anda.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-xs text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Password</label>
                    <div class="password-toggle">
                        <input type="password" name="password" required
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800">
                        <button type="button" class="password-toggle-btn" onclick="var p=this.previousElementSibling; p.type=p.type==='password'?'text':'password';" aria-label="Tampilkan password">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 text-gray-500 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#8b5a2b] focus:ring-[#8b5a2b]">
                        <span>Ingat Saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-[#8b5a2b] hover:underline">Lupa Password?</a>
                </div>

                <button type="submit" 
                    class="w-full bg-[#3e2723] hover:bg-black text-white font-medium py-3 rounded-xl shadow-md transition duration-200 text-sm">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#8b5a2b] font-semibold hover:underline">Daftar Sekarang</a>
            </div>
        </div>
    </div>

</div>
@endsection
