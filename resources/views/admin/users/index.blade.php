@extends('layouts.admin')

@section('title', 'Users')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Users</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola seluruh akun yang terdaftar di website UMKM KITA.</p>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Total Users</p>
            <p class="text-xl font-bold text-gray-800">{{ $summary['total_users'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Admin</p>
            <p class="text-xl font-bold text-blue-600">{{ $summary['total_admins'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Customers</p>
            <p class="text-xl font-bold text-green-600">{{ $summary['total_customers'] }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-[11px] text-gray-400 uppercase tracking-wider font-medium mb-1">Baru Bulan Ini</p>
            <p class="text-xl font-bold text-[#8b5a2b]">{{ $summary['new_this_month'] }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <form action="{{ route('admin.users.index') }}" method="GET" class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm mb-5 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, email, atau telepon..."
                   class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30 focus:border-[#8b5a2b]">
        </div>
        <div>
            <label class="block text-[11px] font-semibold text-gray-500 mb-1 uppercase tracking-wider">Role</label>
            <select name="role" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#8b5a2b]/30">
                <option value="">Semua</option>
                <option value="customer" @selected(request('role') == 'customer')>Customer</option>
                <option value="admin" @selected(request('role') == 'admin')>Admin</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-[#3e2723] hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-semibold transition">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition">Reset</a>
        </div>
    </form>

    {{-- Users Table --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-[11px] uppercase tracking-wider">
                    <tr>
                        <th class="text-left px-5 py-3 font-semibold">User</th>
                        <th class="text-left px-5 py-3 font-semibold">Email</th>
                        <th class="text-left px-5 py-3 font-semibold">Telepon</th>
                        <th class="text-left px-5 py-3 font-semibold">Role</th>
                        <th class="text-left px-5 py-3 font-semibold">Terdaftar</th>
                        <th class="text-right px-5 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 {{ $user->role === 'admin' ? 'bg-blue-500' : 'bg-[#8b5a2b]' }}">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $user->email }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $user->phone ?? '-' }}</td>
                        <td class="px-5 py-3">
                            @if($user->role === 'admin')
                                <span class="text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-600 rounded-md">Admin</span>
                            @else
                                <span class="text-xs font-semibold px-2 py-1 bg-gray-100 text-gray-600 rounded-md">Customer</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-400 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-1.5 text-gray-400 hover:text-[#8b5a2b] hover:bg-gray-100 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">Belum ada user terdaftar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-5 py-3 border-t border-gray-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
@endsection
