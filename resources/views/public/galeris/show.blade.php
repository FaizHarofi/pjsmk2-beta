@extends('layouts.app')
@section('title', $galeri->judul)

@section('content')
<div class="bg-bg-alt py-8">
    <div class="container mx-auto px-4 text-sm text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Beranda</a> /
        <a href="{{ route('galeris.index') }}" class="hover:text-sky-600">Galeri</a> /
        <span>{{ $galeri->judul }}</span>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $galeri->judul }}</h1>
        <p class="text-slate-500 mb-6">{{ $galeri->deskripsi }}</p>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="{ open: false, src: '' }">
            @foreach($galeri->fotos as $foto)
            <button @click="src = '{{ asset('storage/' . $foto->file_path) }}'; open = true" class="aspect-square overflow-hidden rounded-2xl">
                <img src="{{ asset('storage/' . $foto->file_path) }}" class="w-full h-full object-cover hover:scale-110 transition">
            </button>
            @endforeach
            <div x-show="open" @click="open = false" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4" x-transition>
                <img :src="src" class="max-w-full max-h-full rounded-2xl">
            </div>
        </div>
    </div>
</section>
@endsection
