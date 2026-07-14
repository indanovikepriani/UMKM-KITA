<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - UMKM KITA</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #fcfbf9; }
        .serif-font { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center px-4">
    <div class="text-center max-w-md">
        <div class="text-9xl font-bold text-[#3e2723]/10 serif-font mb-4">404</div>
        <div class="text-6xl mb-6">🍽️</div>
        <h1 class="text-2xl font-bold text-gray-800 serif-font mb-3">Oops! Hidangan Ini Tidak Tersedia</h1>
        <p class="text-gray-500 text-sm mb-8 leading-relaxed">Halaman yang Anda cari mungkin sudah dipindahkan, tidak tersedia, atau sedang dalam perbaikan oleh UMKM kami.</p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('home') }}" class="inline-block bg-[#8b5a2b] text-white px-8 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition text-sm">
                Kembali ke Beranda
            </a>
            <a href="{{ route('menu.index') }}" class="inline-block border-2 border-[#3e2723] text-[#3e2723] px-8 py-3 rounded-full font-semibold hover:bg-[#3e2723] hover:text-white transition text-sm">
                Lihat Menu
            </a>
        </div>
        <p class="text-xs text-gray-400 mt-8">&copy; {{ date('Y') }} UMKM KITA</p>
    </div>
</body>
</html>
