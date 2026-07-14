@extends('layouts.app')

@section('title', 'Lupa Password - UMKM KITA')

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
                <h2 class="text-3xl font-bold serif-font text-[#f5ebd9] mb-2">Lupa Password?</h2>
                <p class="text-gray-200 text-xs font-light tracking-wide">Masukkan email Anda dan kami akan mengirimkan link untuk reset password.</p>
            </div>
            <div class="text-[10px] text-gray-400">&copy; 2026 UMKM KITA by Nowfey Computer.</div>
        </div>

        <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800 serif-font">Reset Password</h3>
                <p class="text-gray-400 text-xs mt-1">Kami akan mengirimkan link reset ke email Anda.</p>
            </div>

            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-500 rounded-r-xl text-xs text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-xl text-xs text-red-600">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-semibold uppercase tracking-wider text-gray-500 mb-1">Email Terdaftar</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 outline-none focus:border-[#8b5a2b] transition text-sm text-gray-800"
                        placeholder="Masukkan email Anda">
                </div>

                <button type="submit" 
                    class="w-full bg-[#3e2723] hover:bg-black text-white font-medium py-3 rounded-xl shadow-md transition duration-200 text-sm">
                    Kirim Link Reset
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
