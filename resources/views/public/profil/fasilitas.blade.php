@extends('layouts.app')
@section('title', 'Fasilitas')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Fasilitas Sekolah</h1>
        <p class="text-slate-500 mt-2">Sarana dan prasarana pendukung pembelajaran</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($fasilitas as $f)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                <div class="aspect-video bg-slate-100">
                    @if($f->gambar)<img src="{{ asset('uploads/' . $f->gambar) }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-4xl">🏛️</div>@endif
                </div>
                <div class="p-5">
                    <h3 class="font-bold text-slate-800">{{ $f->nama }}</h3>
                    <p class="text-sm text-slate-500 mt-2">{!! strip_tags($f->deskripsi) !!}</p>
                </div>
            </div>
            @empty
            <p class="col-span-3 text-slate-400 text-center py-12">Belum ada data.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
