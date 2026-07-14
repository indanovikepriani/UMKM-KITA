@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-800 inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke daftar users
        </a>
    </div>

    <div class="max-w-2xl">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Edit User</h1>
        <p class="text-sm text-gray-500 mb-6">Perbarui informasi akun <strong>{{ $user->name }}</strong></p>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                </div>
                <div>
                    <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Role</label>
                    <select name="role" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30">
                        <option value="customer" @selected(old('role', $user->role) == 'customer')>Customer</option>
                        <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Alamat</label>
                <textarea name="address" rows="2" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">{{ old('address', $user->address) }}</textarea>
            </div>

            <div class="border-t border-gray-100 pt-5">
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-3">Ubah Password (opsional)</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Password Baru</label>
                        <input type="password" name="password" minlength="6"
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" minlength="6"
                               class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#8b5a2b] hover:bg-[#6f4620] text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition">Simpan Perubahan</button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 rounded-lg text-sm font-semibold text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition">Batal</a>
            </div>
        </form>
    </div>
@endsection
