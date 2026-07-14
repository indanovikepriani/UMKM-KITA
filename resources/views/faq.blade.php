@extends('layouts.app')

@section('title', 'FAQ - UMKM KITA')

@section('styles')
.faq-hero {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(62, 39, 35, 0.8)), url('{{ asset("images/hero/menu-hero.jpg") }}');
    background-size: cover;
    background-position: center;
}
.faq-item { border-bottom: 1px solid #e5e7eb; }
.faq-item:last-child { border-bottom: none; }
.faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease; }
.faq-answer.open { max-height: 200px; padding-top: 12px; }
.faq-icon { transition: transform 0.3s ease; }
.faq-item.active .faq-icon { transform: rotate(45deg); }
@endsection

@section('content')
<header class="faq-hero h-[40vh] flex items-center justify-center pt-20 text-center text-white">
    <div class="px-4">
        <h1 class="text-4xl md:text-5xl font-bold text-[#f5ebd9] mb-4">Pertanyaan Umum</h1>
        <p class="text-sm md:text-base font-light text-gray-200">Temukan jawaban atas pertanyaan yang sering ditanyakan</p>
    </div>
</header>

<main class="container mx-auto px-6 py-16 max-w-3xl">
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
        <div class="mb-8">
            <div class="flex flex-wrap gap-2 justify-center" id="faq-categories">
                <button class="faq-cat-btn active px-4 py-2 rounded-full text-sm font-medium bg-[#3e2723] text-white transition" data-cat="all">Semua</button>
                @php $categories = collect($faqs)->pluck('category')->unique(); @endphp
                @foreach($categories as $cat)
                <button class="faq-cat-btn px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition" data-cat="{{ $cat }}">{{ $cat }}</button>
                @endforeach
            </div>
        </div>

        <div class="space-y-0" id="faq-list">
            @foreach($faqs as $index => $faq)
            <div class="faq-item py-4 cursor-pointer" data-category="{{ $faq['category'] }}" onclick="toggleFaq(this)">
                <div class="flex items-center justify-between gap-4">
                    <h3 class="font-semibold text-gray-800 text-sm">{{ $faq['question'] }}</h3>
                    <svg class="faq-icon w-5 h-5 text-[#8b5a2b] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <div class="faq-answer text-gray-500 text-sm leading-relaxed">
                    {{ $faq['answer'] }}
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 text-center pt-8 border-t border-gray-100">
            <p class="text-gray-500 text-sm mb-4">Masih punya pertanyaan?</p>
            <a href="{{ route('contact.index') }}" class="inline-block bg-[#8b5a2b] text-white px-6 py-3 rounded-full font-semibold hover:bg-[#6f4620] transition text-sm">
                Hubungi Kami
            </a>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
function toggleFaq(el) {
    const answer = el.querySelector('.faq-answer');
    const isOpen = el.classList.contains('active');
    
    document.querySelectorAll('.faq-item').forEach(item => {
        item.classList.remove('active');
        item.querySelector('.faq-answer').classList.remove('open');
    });
    
    if (!isOpen) {
        el.classList.add('active');
        answer.classList.add('open');
    }
}

document.querySelectorAll('.faq-cat-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.faq-cat-btn').forEach(b => {
            b.classList.remove('active', 'bg-[#3e2723]', 'text-white');
            b.classList.add('bg-gray-100', 'text-gray-600');
        });
        this.classList.add('active', 'bg-[#3e2723]', 'text-white');
        this.classList.remove('bg-gray-100', 'text-gray-600');
        
        const cat = this.dataset.cat;
        document.querySelectorAll('.faq-item').forEach(item => {
            if (cat === 'all' || item.dataset.category === cat) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
