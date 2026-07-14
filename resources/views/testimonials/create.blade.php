@extends('layouts.app')

@section('title', 'Buat Testimoni - UMKM KITA')

@section('content')
<div class="container mx-auto px-4 py-20 max-w-2xl flex-grow">

    <nav class="text-sm mb-8 text-gray-500 font-medium">
        <a href="{{ route('home') }}" class="hover:text-[#8b5a2b] transition">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('orders.index') }}" class="hover:text-[#8b5a2b] transition">Pesanan Saya</a>
        <span class="mx-2">/</span>
        <span class="text-gray-800">Buat Testimoni</span>
    </nav>

    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
        <h1 class="text-2xl font-bold serif-font text-gray-800 mb-2">Buat Testimoni</h1>
        <p class="text-gray-500 text-sm mb-6">Pesanan #{{ $order->order_number }} — {{ $order->created_at->format('d M Y') }}</p>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-4 text-sm">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-4 text-sm">
                @foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
        @endif

        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Produk dalam Pesanan</h3>
            <div class="space-y-2">
                @foreach($order->items as $item)
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    @if($item->product && $item->product->image)
                        <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset($item->product->image) }}" alt="{{ $item->product_name }}" class="w-10 h-10 rounded-lg object-cover">
                    @else
                        <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center text-gray-400 text-xs">📦</div>
                    @endif
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <form action="{{ route('testimonials.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">

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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Komentar <span class="text-red-500">*</span></label>
                <textarea name="comment" rows="4" maxlength="1000" required placeholder="Ceritakan pengalaman Anda..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#8b5a2b] focus:ring-1 focus:ring-[#8b5a2b] outline-none transition text-sm">{{ old('comment') }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-[#3e2723] hover:bg-black text-white px-8 py-3 rounded-xl font-semibold text-sm transition shadow-md">Kirim Testimoni</button>
                <a href="{{ route('orders.show', $order->id) }}" class="px-6 py-3 rounded-xl font-semibold text-sm text-gray-600 border border-gray-200 hover:bg-gray-50 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
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
