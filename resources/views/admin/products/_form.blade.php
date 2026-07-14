{{-- Partial form dipakai bersama oleh create.blade.php & edit.blade.php --}}

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Kolom kiri: info utama --}}
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama Menu</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Deskripsi Menu</label>
                <textarea name="description" rows="5"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none"
                    placeholder="Jelaskan bahan, rasa, atau keunikan menu ini..." required>{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Kategori</label>
                <select name="category_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama UMKM / Mitra <span class="text-gray-400 normal-case">(opsional)</span></label>
                    <input type="text" name="umkm_name" value="{{ old('umkm_name', $product->umkm_name ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none"
                        placeholder="Nama UMKM yang memproduksi">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Asal UMKM <span class="text-gray-400 normal-case">(opsional)</span></label>
                    <input type="text" name="umkm_address" value="{{ old('umkm_address', $product->umkm_address ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none"
                        placeholder="Lokasi UMKM, contoh: Batam Centre">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Harga Jual / Diskon (Rp) <span class="text-red-500">*</span></label>
                    <p class="text-[10px] text-gray-400 mb-1.5 -mt-1">Harga yang dibayarkan pelanggan</p>
                    <input type="number" step="1" min="0" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Harga Asli / Normal (Rp)</label>
                    <p class="text-[10px] text-gray-400 mb-1.5 -mt-1">Harga sebelum diskon (harga coret)</p>
                    <input type="number" step="1" min="0" name="price" value="{{ old('price', $product->price ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none">
                </div>
            </div>
            <p class="text-[10px] text-gray-400 -mt-2">Jika tidak ada diskon, isi "Harga Jual" saja dan biarkan "Harga Asli" kosong.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Stok</label>
                    <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none" required>
                </div>
                <div class="flex items-end gap-6 pb-1">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="hidden" name="is_available" value="0">
                        <input type="checkbox" name="is_available" value="1" class="w-4 h-4 rounded"
                            {{ old('is_available', $product->is_available ?? true) ? 'checked' : '' }}>
                        Tersedia dijual
                    </label>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 rounded"
                            {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                        Menu unggulan
                    </label>
                </div>
            </div>

        </div>
    </div>

    {{-- Kolom kanan: foto menu --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Foto Menu</label>

            <div class="w-full aspect-square rounded-xl overflow-hidden bg-gray-50 border border-gray-100 mb-4 flex items-center justify-center">
                @if(isset($product) && $product->image)
                    <img id="preview-image" src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <img id="preview-image" src="" alt="Preview" class="w-full h-full object-cover hidden">
                    <span id="preview-placeholder" class="text-gray-300 text-sm">Belum ada foto</span>
                @endif
            </div>

            <input type="file" name="image" accept="image/*" onchange="previewImage(event)"
                class="w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:bg-[#f4eee6] file:text-[#8b5a2b] file:font-semibold hover:file:bg-amber-100">
            <p class="text-xs text-gray-400 mt-2">Format JPG/PNG, maksimal 2MB.</p>

            <button type="submit" class="w-full mt-6 bg-[#8b5a2b] text-white font-semibold py-3 rounded-full hover:bg-[#6f4620] transition">
                {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Menu' }}
            </button>
            <a href="{{ route('admin.products.index') }}" class="block text-center mt-3 text-sm text-gray-500 hover:text-gray-800">Batal</a>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const img = document.getElementById('preview-image');
        const placeholder = document.getElementById('preview-placeholder');
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    }
</script>
