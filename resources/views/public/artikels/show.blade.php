@extends('layouts.app')
@section('title', $artikel->judul)
@section('description', $artikel->ringkasan)

@section('content')
<div class="bg-bg-alt py-8">
    <div class="container mx-auto px-4 text-sm text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-sky-600">Beranda</a> /
        <a href="{{ route('artikels.index') }}" class="hover:text-sky-600">Artikel</a> /
        <span>{{ $artikel->judul }}</span>
    </div>
</div>

<article class="py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        @if($artikel->kategori)
        <span class="inline-block px-3 py-1 text-xs rounded-full font-semibold mb-3" style="background-color: {{ $artikel->kategori->warna }}20; color: {{ $artikel->kategori->warna }}">{{ $artikel->kategori->nama }}</span>
        @endif
        <h1 class="text-3xl md:text-4xl font-bold text-slate-800">{{ $artikel->judul }}</h1>
        <div class="flex flex-wrap items-center gap-4 mt-4 text-sm text-slate-500">
            <span>📅 {{ $artikel->published_at?->format('d M Y') }}</span>
            <span>👤 {{ $artikel->user->name }}</span>
            <span>👁 {{ $artikel->views }} views</span>
        </div>
        @if($artikel->gambar)
        <img src="{{ asset('storage/' . $artikel->gambar) }}" class="w-full h-auto rounded-2xl mt-6">
        @endif
        <div class="prose max-w-none mt-6 text-slate-700 leading-relaxed">
            {!! $artikel->konten !!}
        </div>
        @if($artikel->tags->count() > 0)
        <div class="mt-8 flex flex-wrap gap-2">
            @foreach($artikel->tags as $tag)
            <span class="px-3 py-1 text-xs bg-slate-100 text-slate-600 rounded-full">#{{ $tag->nama }}</span>
            @endforeach
        </div>
        @endif
    </div>
</article>

@if($related->count() > 0)
<section class="py-12 bg-bg-alt">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Artikel Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $r)
            <a href="{{ route('artikels.show', $r->slug) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-md group">
                <div class="h-40 bg-slate-100">
                    @if($r->gambar)<img src="{{ asset('storage/' . $r->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition">@endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-slate-800 group-hover:text-sky-600 line-clamp-2">{{ $r->judul }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
