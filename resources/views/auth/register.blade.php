@extends('layouts.app')

@section('title', 'Daftar - UMKM KITA')

@section('styles')
.auth-body {
    background-color: hsl(40, 72%, 69%);
}
.food-bg {
    background-image: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.5)), url('{{ asset("images/hero/register-bg.jpg") }}');
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
                <h2 class="text-3xl font-bold serif-font text-[#f5ebd9] mb-2">Bergabung Bersama</h2>
                <p class="text-gray-200 text-xs font-light tracking-wide">Buat akun untuk memesan kuliner favorit dengan mudah dan cepat.</p>
            </div>
            <div class="text-[10px] text-gray-400">
                &copy; 2026 UMKM KITA by Nowfey Computer.
            </div>
        </div>

        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-4">
                <h3 class="text-2xl font-bold text-gray-800 serif-font">Daftar Akun</h3>
                <p class="text-gray-400 text-xs mt-1">Lengkapi data diri Anda di bawah ini.</p>
            </div>

            @if ($errors->any())
                <div class="mb-3 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-xs text-red-600">
                    <ul class="list-disc pl-4 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="space-y-3">
                @csrf
                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-0.5">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-3 py-2 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-xs text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-0.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-xs text-gray-800">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-0.5">No. HP/WA</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full px-3 py-2 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-xs text-gray-800">
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-0.5">Alamat</label>
                        <input type="text" name="address" value="{{ old('address') }}" required
                            class="w-full px-3 py-2 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-xs text-gray-800">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-0.5">Password</label>
                        <div class="password-toggle">
                            <input type="password" name="password" required
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-xs text-gray-800">
                            <button type="button" class="password-toggle-btn" onclick="var p=this.previousElementSibling; p.type=p.type==='password'?'text':'password';" aria-label="Tampilkan password">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-0.5">Konfirmasi</label>
                        <div class="password-toggle">
                            <input type="password" name="password_confirmation" required
                                class="w-full px-3 py-2 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-xs text-gray-800">
                            <button type="button" class="password-toggle-btn" onclick="var p=this.previousElementSibling; p.type=p.type==='password'?'text':'password';" aria-label="Tampilkan password">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full bg-[#3e2723] hover:bg-black text-white font-medium py-2.5 rounded-xl shadow-md transition duration-200 text-sm">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center text-xs text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-[#8b5a2b] font-semibold hover:underline">Masuk disini</a>
            </div>
        </div>
    </div>

</div>
@endsection
