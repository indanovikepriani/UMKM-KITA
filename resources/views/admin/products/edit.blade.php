@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')

    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-800">← Kembali ke daftar menu</a>
        <h1 class="text-3xl font-bold serif-font text-gray-800 mt-2">Edit Menu: {{ $product->name }}</h1>
        <p class="text-gray-500">Perbarui foto, deskripsi, harga, atau ketersediaan menu ini.</p>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form')
    </form>

@endsection
