@extends('layouts.admin')

@section('title')
Edit Review Pengguna
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-4">Edit Review Pengguna</h1>
        <p class="text-gray-600">Edit review yang diberikan oleh pengguna kepada produk kami.</p>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Pengguna</label>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-sm font-medium">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $review->user->name }}</p>
                                <p class="text-xs text-gray-500">Pesanan #{{ $review->order?->order_number ?? 'Direct' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Produk</label>
                        <div class="flex items-center space-x-3">
                            @if($review->product)
                                <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-sm font-medium">
                                    {{ substr($review->product->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $review->product->name }}</p>
                                    <p class="text-xs text-gray-500">Kategori: {{ $review->product->category->name ?? '-' }}</p>
                                </div>
                            @else
                                <span class="text-gray-500">Produk tidak tersedia</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Rating</label>
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="rating{{ $i }}" name="rating" value="{{ $i }}" 
                                    class="hidden" 
                                    {{ old('rating', $review->rating) == $i ? 'checked' : '' }}>
                                <label for="rating{{ $i }}" class="cursor-pointer text-yellow-400 hover:text-yellow-500 
                                    {{ old('rating', $review->rating) == $i ? 'text-yellow-500' : '' }}">
                                    â˜…
                                </label>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', $review->rating) }}">
                    </div>
                </div>
                
                <!-- Right Column -->
                <div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Komentar</label>
                        <textarea name="comment" id="comment" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('comment', $review->comment) }}</textarea>
                        @if ($errors->has('comment'))
                            <p class="mt-1 text-sm text-red-600">{{ $errors->first('comment') }}</p>
                        @endif
                    </div>
                    

                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Status Review</label>
                        <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending" {{ old('status', $review->status) == 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="mb-4" id="rejection-reason-field" {{ old('status', $review->status) !== 'rejected' ? 'style="display: none;"' : '' }}>
                        <label class="block text-gray-700 font-medium mb-2">Alasan Penolakan</label>
                        <input type="text" name="rejection_reason" id="rejection_reason" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('rejection_reason', $review->rejection_reason) }}">
                        <p class="mt-1 text-sm text-gray-500">Wajib diisi jika status ditolak</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Balasan Admin (Opsional)</label>
                        <textarea name="admin_reply" id="admin_reply" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('admin_reply', $review->admin_reply) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Balasan Anda akan ditampilkan di bawah review pengguna</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex justify-between items-center">
                <a href="{{ route('admin.reviews.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition">
                    Kembali ke Daftar Review
                </a>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript untuk menangani rating bintang
    document.querySelectorAll('input[name="rating"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.getElementById('rating-input').value = this.value;
            
            // Update visual representation
            document.querySelectorAll('label[for^="rating"]').forEach(label => {
                const ratingValue = parseInt(label.getAttribute('for').replace('rating', ''));
                if (ratingValue <= parseInt(this.value)) {
                    label.classList.remove('text-yellow-400', 'hover:text-yellow-500');
                    label.classList.add('text-yellow-500');
                } else {
                    label.classList.add('text-yellow-400', 'hover:text-yellow-500');
                    label.classList.remove('text-yellow-500');
                }
            });
        });
    });

    // JavaScript untuk menampilkan/menyembunyikan field alasan penolakan
    document.getElementById('status').addEventListener('change', function() {
        const rejectionReasonField = document.getElementById('rejection-reason-field');
        if (this.value === 'rejected') {
            rejectionReasonField.style.display = 'block';
        } else {
            rejectionReasonField.style.display = 'none';
        }
    });
</script>
@endsection