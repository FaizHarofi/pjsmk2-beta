@extends('layouts.app')
@section('title', 'Galeri')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Galeri Foto</h1>
        <p class="text-slate-500 mt-2">Dokumentasi kegiatan sekolah</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($albums as $album)
            <a href="{{ route('galeris.show', $album->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition">
                <div class="aspect-video bg-slate-100">
                    @if($album->cover)<img src="{{ asset('storage/' . $album->cover) }}" class="w-full h-full object-cover group-hover:scale-105 transition">@endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-slate-800 group-hover:text-sky-600">{{ $album->judul }}</h3>
                    <p class="text-xs text-slate-400 mt-1">{{ $album->fotos_count }} foto · {{ $album->published_at?->format('d M Y') }}</p>
                </div>
            </a>
            @empty
            <p class="col-span-3 text-slate-400 text-center py-12">Belum ada album.</p>
            @endforelse
        </div>
        <div class="mt-8">{{ $albums->links() }}</div>
    </div>
</section>
@endsection
