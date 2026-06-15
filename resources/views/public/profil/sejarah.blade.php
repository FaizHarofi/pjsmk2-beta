@extends('layouts.app')
@section('title', 'Sejarah Sekolah')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Sejarah Sekolah</h1>
        <p class="text-slate-500 mt-2">Perjalanan panjang {{ $sekolah->nama ?? 'SMKN 2 Pekanbaru' }}</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="prose max-w-none text-slate-700">{!! $sekolah->sejarah ?? '<p>Belum ada data sejarah.</p>' !!}</div>
    </div>
</section>
@endsection
