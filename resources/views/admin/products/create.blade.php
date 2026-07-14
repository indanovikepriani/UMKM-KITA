@extends('layouts.admin')

@section('title', 'Tambah Menu')

@section('content')

    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Kembali ke daftar menu</a>
        <h1 class="text-3xl font-bold serif-font text-gray-800 mt-2">Tambah Menu Baru</h1>
        <p class="text-gray-500">Lengkapi informasi menu yang akan ditambahkan ke katalog.</p>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form')
    </form>

@endsection
