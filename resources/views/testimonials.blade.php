@extends('layouts.app')

@section('title', 'Testimoni Pengguna - UMKM KITA')

@section('styles')
.review-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(62, 39, 35, 0.8)), url('{{ asset("images/hero/testimonials-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
.glass-card {
    background: rgba(255, 255, 255, 1);
    border: 1px solid rgba(230, 230, 230, 0.7);
}
@endsection

@section('content')
    <!-- Hero Section -->
    <header class="review-hero h-[40vh] flex items-center justify-center pt-20 text-center text-white">
        <div class="px-4">
            <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-3">Testimoni Pengguna</h1>
            <p class="text-sm md:text-base font-light tracking-wide max-w-lg mx-auto text-gray-200">Kumpulan ulasan dan pengalaman nyata dari pengguna setia yang telah mencicipi hidangan kami.</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-6 py-16 max-w-7xl -mt-10 relative z-10">

        <!-- Reviews Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($reviews as $review)
                <div class="glass-card p-8 rounded-3xl shadow-sm hover:shadow-md transition duration-300 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 text-9xl text-gray-50 opacity-50 font-serif group-hover:scale-110 transition duration-500">"</div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="flex text-[#8b5a2b] mb-4 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    ★
                                @else
                                    <span class="text-gray-300">★</span>
                                @endif
                            @endfor
                        </div>

                        <p class="text-gray-600 text-sm leading-relaxed mb-6 flex-grow italic">
                            "{{ $review->comment }}"
                        </p>

                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-[#3e2723] text-[#f5ebd9] flex items-center justify-center font-bold text-sm uppercase flex-shrink-0">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $review->user->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-medium">{{ $review->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        @if($review->product)
                            <div class="mt-4 pt-3 border-t border-gray-100 text-sm text-gray-500">
                                Produk: <strong>{{ $review->product->name }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-12 rounded-3xl shadow-sm border border-gray-100 text-center">
                    <div class="text-4xl mb-4">🍽️</div>
                    <h3 class="text-xl font-bold text-gray-800 serif-font mb-2">Belum Ada Testimoni</h3>
                    <p class="text-gray-500 text-sm">Jadilah yang pertama memberikan testimoni setelah pesanan Anda selesai!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $reviews->links() }}
        </div>

        <!-- Review Form (below reviews) -->
        @auth
        <div class="mt-16 bg-white p-8 rounded-3xl shadow-md border border-gray-100">
            <h2 class="text-2xl font-bold serif-font text-gray-800 mb-2">Tulis Review Anda</h2>
            <p class="text-gray-500 text-sm mb-6">Bagikan pengalaman Anda dengan produk UMKM KITA.</p>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl mb-4 text-sm">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-4 text-sm">
                    @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
                </div>
            @endif

            <form action="{{ route('reviews.storeDirect') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk <span class="text-red-500">*</span></label>
                        <select name="product_id" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition text-sm">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-1 mt-2" id="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" data-value="{{ $i }}" class="star-btn text-2xl text-gray-300 hover:text-[#8b5a2b] transition">★</button>
                            @endfor
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 5) }}">
                            <span class="text-sm text-gray-500 ml-2" id="rating-label">5 Bintang</span>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Komentar</label>
                    <textarea name="comment" rows="3" maxlength="1000" placeholder="Ceritakan pengalaman Anda dengan produk ini..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition text-sm">{{ old('comment') }}</textarea>
                </div>
                <button type="submit" class="bg-[#3e2723] hover:bg-black text-white px-8 py-3 rounded-xl font-semibold text-sm transition shadow-md">Kirim Review</button>
            </form>
        </div>
        @else
        <div class="mt-16 bg-[#f4eee6] p-6 rounded-3xl text-center">
            <p class="text-gray-700 mb-0">Ingin memberikan review? <a href="{{ route('login') }}" class="text-[#8b5a2b] font-bold hover:underline">Login</a> terlebih dahulu.</p>
        </div>
        @endauth

    </main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-btn');
    const input = document.getElementById('rating-input');
    const label = document.getElementById('rating-label');
    const ratingLabels = ['', '1 Bintang', '2 Bintang', '3 Bintang', '4 Bintang', '5 Bintang'];

    function updateStars(val) {
        stars.forEach(s => {
            s.classList.toggle('text-[#8b5a2b]', parseInt(s.dataset.value) <= val);
            s.classList.toggle('text-gray-300', parseInt(s.dataset.value) > val);
        });
        label.textContent = ratingLabels[val];
    }

    stars.forEach(star => {
        star.addEventListener('click', function() {
            input.value = this.dataset.value;
            updateStars(parseInt(this.dataset.value));
        });
        star.addEventListener('mouseenter', function() {
            updateStars(parseInt(this.dataset.value));
        });
    });

    document.getElementById('star-rating').addEventListener('mouseleave', function() {
        updateStars(parseInt(input.value));
    });

    updateStars(parseInt(input.value));
});
</script>
@endsection
