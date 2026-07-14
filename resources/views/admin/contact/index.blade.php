@extends('layouts.admin')

@section('title', 'Kontak IT Support')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kontak IT Support</h1>
        <p class="text-sm text-gray-500 mt-1">Hubungi tim IT jika terjadi kerusakan atau gangguan pada sistem.</p>
    </div>

    <div class="max-w-3xl">
        {{-- IT Support Contact Card --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-[#8b5a2b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Tim IT Support
            </h3>
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-[#8b5a2b] rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Email</p>
                        <p class="text-sm font-semibold text-gray-800">support@umkmkita.com</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-[#8b5a2b] rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Telepon / WhatsApp</p>
                        <p class="text-sm font-semibold text-gray-800">0812-3456-7890</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-10 h-10 bg-[#8b5a2b] rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Alamat Kantor</p>
                        <p class="text-sm font-semibold text-gray-800">Jl. Teknologi No. 42, Kota Bandung</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Operating Hours --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 mb-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Jam Operasional
            </h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Senin - Jumat</span>
                    <span class="font-semibold text-gray-800">08:00 - 17:00 WIB</span>
                </div>
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="text-gray-500">Sabtu</span>
                    <span class="font-semibold text-gray-800">09:00 - 14:00 WIB</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-500">Minggu & Hari Libur</span>
                    <span class="font-semibold text-red-500">Tutup</span>
                </div>
            </div>
        </div>

        {{-- Common Issues --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Masalah Umum & Solusi
            </h3>
            <div class="space-y-3">
                <div class="p-3 bg-amber-50 rounded-lg border border-amber-100">
                    <p class="text-sm font-semibold text-amber-800 mb-1">Halaman tidak bisa dibuka</p>
                    <p class="text-xs text-amber-700">Coba clear cache browser (Ctrl+Shift+R) atau logout lalu login kembali.</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                    <p class="text-sm font-semibold text-blue-800 mb-1">Data pesanan tidak muncul</p>
                    <p class="text-xs text-blue-700">Periksa koneksi database di XAMPP. Pastikan Apache & MySQL berjalan.</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-lg border border-purple-100">
                    <p class="text-sm font-semibold text-purple-800 mb-1">Upload gambar gagal</p>
                    <p class="text-xs text-purple-700">Pastikan ukuran file di bawah 2MB dan format JPEG/PNG.</p>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-sm font-semibold text-gray-800 mb-1">Error 500 Internal Server</p>
                    <p class="text-xs text-gray-600">Jalankan <code class="bg-gray-200 px-1 rounded">php artisan optimize:clear</code> di terminal, lalu restart Apache.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
