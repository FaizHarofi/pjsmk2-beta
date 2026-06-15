@extends('layouts.app')
@section('title', 'Guru & Staff')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Guru & Staff</h1>
        <p class="text-slate-500 mt-2">Tenaga pendidik profesional kami</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($gurus as $guru)
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100 text-center">
                <div class="aspect-square bg-slate-100">
                    @if($guru->foto)<img src="{{ asset('storage/' . $guru->foto) }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-4xl text-slate-300">👤</div>@endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-slate-800">{{ $guru->nama }}</h3>
                    <p class="text-sm text-sky-600">{{ $guru->jabatan ?? 'Guru' }}</p>
                    @if($guru->mapel)<p class="text-xs text-slate-500 mt-1">{{ $guru->mapel }}</p>@endif
                </div>
            </div>
            @empty
            <p class="col-span-4 text-slate-400 text-center py-12">Belum ada data guru.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
