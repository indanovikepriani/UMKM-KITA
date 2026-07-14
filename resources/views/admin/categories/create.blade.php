@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Tambah Kategori Baru</h1>
        <p class="text-gray-600">Tambah kategori menu baru untuk mengorganisasi produk Anda.</p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Form Tambah Kategori</h2>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="px-6 py-4 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none"
                              placeholder="Jelaskan tentang kategori ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Kategori (opsional)</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:bg-[#f4eee6] file:text-[#8b5a2b] file:font-semibold hover:file:bg-amber-100">
                    <p class="mt-1 text-xs text-gray-500">Format JPG/PNG, maksimal 2MB.</p>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           class="w-4 h-4 text-[#8b5a2b] focus:ring-indigo-500 border-gray-300 rounded"
                           {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 block text-sm font-medium text-gray-900">
                        Aktif
                    </label>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 text-right">
                <a href="{{ route('admin.categories.index') }}" class="mr-3 bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="bg-[#8b5a2b] text-white px-6 py-2 rounded hover:bg-[#6f4620]">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection