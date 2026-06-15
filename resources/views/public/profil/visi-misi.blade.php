@extends('layouts.app')
@section('title', 'Visi & Misi')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Visi & Misi</h1>
        <p class="text-slate-500 mt-2">Arah dan tujuan pendidikan kami</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-6">
            <h2 class="text-2xl font-bold text-slate-800 mb-3">Visi</h2>
            <p class="text-slate-700 leading-relaxed">{{ $sekolah->visi ?? 'Belum ada data.' }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-2xl font-bold text-slate-800 mb-3">Misi</h2>
            <div class="prose max-w-none text-slate-700">{!! $sekolah->misi ?? 'Belum ada data.' !!}</div>
        </div>
    </div>
</section>
@endsection
