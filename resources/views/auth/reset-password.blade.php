@extends('layouts.app')

@section('title', 'Reset Password - UMKM KITA')

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
    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row min-h-[500px]">
        
        <div class="md:w-1/2 food-bg p-12 text-white flex flex-col justify-between relative min-h-[250px] md:min-h-auto">
            <div>
                <a href="{{ route('home') }}" class="text-2xl font-bold serif-font tracking-wider text-[#f5ebd9] hover:text-white transition">➔ UMKM KITA</a>
            </div>
            <div>
                <h2 class="text-3xl font-bold serif-font text-[#f5ebd9] mb-2">Password Baru</h2>
                <p class="text-gray-200 text-xs font-light tracking-wide">Buat password baru yang kuat untuk akun Anda.</p>
            </div>
            <div class="text-[10px] text-gray-400">&copy; 2026 UMKM KITA by Nowfey Computer.</div>
        </div>

        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800 serif-font">Buat Password Baru</h3>
                <p class="text-gray-400 text-xs mt-1">Masukkan password baru Anda di bawah ini.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-xs text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Email</label>
                    <input type="email" name="email" value="{{ $email ?? old('email') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Password Baru</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800"
                        placeholder="Minimal 6 karakter">
                </div>

                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800"
                        placeholder="Ulangi password baru">
                </div>

                <button type="submit" 
                    class="w-full bg-[#3e2723] hover:bg-black text-white font-medium py-3 rounded-xl shadow-md transition duration-200 text-sm">
                    Reset Password
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-gray-500">
                Ingat password? 
                <a href="{{ route('login') }}" class="text-[#8b5a2b] font-semibold hover:underline">Kembali ke Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
