@extends('layouts.app')
@section('title', 'Video')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Video</h1>
        <p class="text-slate-500 mt-2">Koleksi video kegiatan dan profil sekolah</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <form method="GET" class="mb-6 flex flex-wrap gap-3">
            <select name="kategori" class="px-4 py-2 border border-slate-300 rounded-lg">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
            <button class="px-5 py-2 bg-primary text-white rounded-lg">Filter</button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ open: false, src: '' }">
            @forelse($videos as $video)
            <button @click="src = '{{ $video->youtube_embed }}'; open = true" class="text-left group">
                <div class="relative aspect-video bg-slate-900 rounded-2xl overflow-hidden">
                    <img src="{{ $video->thumbnail }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center text-2xl">▶</div>
                    </div>
                </div>
                <h3 class="font-semibold text-slate-800 mt-2 group-hover:text-sky-600 line-clamp-2">{{ $video->judul }}</h3>
                <p class="text-xs text-slate-400 mt-1">{{ $video->views }} views · {{ $video->published_at?->format('d M Y') }}</p>
            </button>
            @empty
            <p class="col-span-3 text-slate-400 text-center py-12">Belum ada video.</p>
            @endforelse

            <div x-show="open" @click="open = false" x-transition class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4">
                <iframe :src="src" class="w-full max-w-4xl aspect-video rounded-2xl" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

        <div class="mt-8">{{ $videos->links() }}</div>
    </div>
</section>
@endsection
