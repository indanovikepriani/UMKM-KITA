@extends('layouts.umkm')

@section('title', 'Buat Toko - UMKM KITA')

@section('content')
<div class="max-w-md mx-auto text-center py-20">
    <div class="w-20 h-20 bg-[#f4eee6] rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-[#8b5a2b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
    </div>
    <h1 class="text-2xl font-bold text-gray-800 mb-3">Anda Belum Punya Toko</h1>
    <p class="text-gray-500 mb-8 text-sm">Buat toko Anda sekarang agar pelanggan bisa menemukan dan membeli produk Anda.</p>
    <a href="{{ route('umkm.store.create') }}" class="bg-[#8b5a2b] text-white px-8 py-3 rounded-xl font-semibold hover:bg-[#6f4620] transition inline-block">Buat Toko Sekarang</a>
</div>
@endsection
