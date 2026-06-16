@extends('layouts.app')
@section('title', 'Artikel & Berita')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Artikel & Berita</h1>
        <p class="text-slate-500 mt-2">Informasi dan berita terbaru dari sekolah</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <form method="GET" class="mb-6 flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..." class="px-4 py-2 border border-slate-300 rounded-lg flex-1 min-w-[200px]">
            <select name="kategori" class="px-4 py-2 border border-slate-300 rounded-lg">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
            <button class="px-5 py-2 bg-primary text-white rounded-lg">Cari</button>
        </form>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                @forelse($artikels as $artikel)
                <a href="{{ route('artikels.show', $artikel->slug) }}" class="block bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-md transition group">
                    <div class="md:flex">
                        <div class="md:w-1/3 h-48 md:h-auto bg-slate-100">
                            @if($artikel->gambar)<img src="{{ asset('uploads/' . $artikel->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition">@endif
                        </div>
                        <div class="p-5 md:w-2/3">
                            @if($artikel->kategori)
                            <span class="inline-block px-2 py-1 text-xs rounded" style="background-color: {{ $artikel->kategori->warna }}20; color: {{ $artikel->kategori->warna }}">{{ $artikel->kategori->nama }}</span>
                            @endif
                            <h3 class="text-lg font-bold text-slate-800 mt-2 group-hover:text-sky-600">{{ $artikel->judul }}</h3>
                            <p class="text-sm text-slate-500 mt-2 line-clamp-2">{!! strip_tags($artikel->ringkasan) !!}</p>
                            <div class="flex items-center gap-3 mt-3 text-xs text-slate-400">
                                <span>{{ $artikel->published_at?->format('d M Y') }}</span>
                                <span>·</span>
                                <span>👁 {{ $artikel->views }} views</span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <p class="text-slate-400 text-center py-12">Belum ada artikel.</p>
                @endforelse

                <div>{{ $artikels->links() }}</div>
            </div>

            <aside class="space-y-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-3">Kategori</h3>
                    <ul class="space-y-2 text-sm">
                        @foreach($kategoris as $k)
                        <li><a href="?kategori={{ $k->id }}" class="text-slate-600 hover:text-sky-600">{{ $k->nama }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-3">Populer</h3>
                    <ul class="space-y-3">
                        @foreach($populer as $i => $p)
                        <li class="flex gap-3">
                            <span class="text-2xl font-bold text-slate-300">{{ $i + 1 }}</span>
                            <a href="{{ route('artikels.show', $p->slug) }}" class="text-sm font-semibold text-slate-700 hover:text-sky-600 line-clamp-2">{{ $p->judul }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @if($tags->count() > 0)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-3">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                        <span class="px-2 py-1 text-xs bg-slate-100 text-slate-600 rounded">{{ $tag->nama }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>
</section>
@endsection
