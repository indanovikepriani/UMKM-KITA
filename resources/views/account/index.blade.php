@extends('layouts.app')

@section('title', 'Akun Saya - UMKM KITA')

@section('styles')
.tab-btn.active { background-color: #8b5a2b; color: white; }
@endsection

@section('content')
<main class="container mx-auto px-4 py-10 max-w-5xl flex-grow pt-24">

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r-xl mb-8 shadow-sm">
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl mb-8 shadow-sm">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold serif-font text-gray-800 mb-2">Akun Saya</h1>
        <p class="text-gray-500">Kelola profil dan lihat ringkasan aktivitas pesanan Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Sidebar profil --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-28 h-28 mx-auto rounded-full overflow-hidden bg-[#f4eee6] flex items-center justify-center mb-4 border-4 border-white shadow">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-3xl font-bold text-[#8b5a2b] serif-font">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <h3 class="font-bold text-lg text-gray-800">{{ $user->name }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>

                <form action="{{ route('account.updateAvatar') }}" method="POST" enctype="multipart/form-data" class="text-left">
                    @csrf
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Ganti Foto Profil</label>
                    <input type="file" name="avatar" accept="image/*" class="w-full text-xs mb-3 file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:bg-[#f4eee6] file:text-[#8b5a2b] file:font-semibold hover:file:bg-amber-100">
                    <button type="submit" class="w-full bg-gray-100 text-gray-700 text-sm font-semibold py-2 rounded-full hover:bg-gray-200 transition">Upload Foto</button>
                </form>
            </div>

            {{-- Ringkasan pesanan --}}
            <div class="bg-[#f4eee6] rounded-3xl p-8 mt-6">
                <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4">Ringkasan Pesanan</h4>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Total Pesanan</span>
                        <span class="font-bold text-gray-800">{{ $orderStats['total_orders'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Selesai</span>
                        <span class="font-bold text-green-700">{{ $orderStats['completed_orders'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Diproses</span>
                        <span class="font-bold text-amber-700">{{ $orderStats['pending_orders'] }}</span>
                    </div>
                </div>
                <a href="{{ route('orders.index') }}" class="block text-center mt-6 bg-[#8b5a2b] text-white text-sm font-semibold py-2.5 rounded-full hover:bg-[#6f4620] transition">Lihat Semua Pesanan</a>
                <a href="{{ route('wishlists.index') }}" class="block text-center mt-3 bg-white text-[#8b5a2b] border border-[#8b5a2b] text-sm font-semibold py-2.5 rounded-full hover:bg-[#8b5a2b] hover:text-white transition">Favorit Saya</a>
            </div>
        </div>

        {{-- Form profil & password --}}
        <div class="lg:col-span-2 space-y-8">

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-3">Informasi Profil</h2>
                <form action="{{ route('account.updateProfile') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">No. Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Role</label>
                            <input type="text" value="{{ ucfirst($user->role) }}" class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 text-gray-500" disabled>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Alamat</label>
                        <textarea name="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>{{ old('address', $user->address) }}</textarea>
                    </div>
                    <button type="submit" class="bg-[#8b5a2b] text-white font-semibold px-6 py-3 rounded-full hover:bg-[#6f4620] transition">Simpan Perubahan</button>
                </form>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-bold mb-6 text-gray-800 border-b pb-3">Ubah Password</h2>
                <form action="{{ route('account.updatePassword') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Password Baru</label>
                            <input type="password" name="password" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                        </div>
                    </div>
                    <button type="submit" class="bg-gray-800 text-white font-semibold px-6 py-3 rounded-full hover:bg-gray-900 transition">Update Password</button>
                </form>
            </div>

            {{-- Pesanan terbaru --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <div class="flex justify-between items-center border-b pb-3 mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Pesanan Terbaru</h2>
                    <a href="{{ route('orders.index') }}" class="text-sm text-[#8b5a2b] font-semibold hover:underline">Lihat Semua</a>
                </div>
                @if($recentOrders->isEmpty())
                    <p class="text-gray-500 text-sm">Belum ada pesanan.</p>
                @else
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                        <a href="{{ route('orders.show', $order->id) }}" class="flex justify-between items-center p-4 rounded-xl hover:bg-[#fcfbf9] border border-gray-100 transition">
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-[#8b5a2b] text-sm">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $order->status_color }}">{{ $order->status_label }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
