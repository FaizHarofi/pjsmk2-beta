@extends('layouts.app')
@section('title', 'Jurusan')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Kompetensi Keahlian</h1>
        <p class="text-slate-500 mt-2">Berbagai jurusan yang tersedia di sekolah kami</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($jurusans as $j)
            <a href="{{ route('jurusans.show', $j->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 hover:shadow-xl transition">
                <div class="h-48 bg-slate-100 relative">
                    @if($j->gambar)<img src="{{ asset('storage/' . $j->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition">@endif
                    <div class="absolute top-3 left-3 px-3 py-1 rounded-lg text-white font-bold" style="background-color: {{ $j->warna ?? '#0284C7' }}">{{ $j->singkatan }}</div>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-slate-800 group-hover:text-sky-600">{{ $j->nama }}</h3>
                    <p class="text-sm text-slate-500 mt-2 line-clamp-3">{!! strip_tags($j->deskripsi) !!}</p>
                    <div class="text-sm text-sky-600 font-semibold mt-3">Selengkapnya →</div>
                </div>
            </a>
            @empty
            <p class="col-span-3 text-slate-400 text-center py-12">Belum ada jurusan.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
