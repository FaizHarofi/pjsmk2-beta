@extends('layouts.app')
@section('title', $jurusan->nama)
@section('description', Str::limit(strip_tags($jurusan->deskripsi), 160))

@section('content')
<section class="relative h-80 bg-primary overflow-hidden">
    @if($jurusan->gambar)<img src="{{ asset('storage/' . $jurusan->gambar) }}" class="w-full h-full object-cover opacity-40">@endif
    <div class="absolute inset-0 flex items-center justify-center text-center text-white">
        <div>
            <div class="inline-block px-4 py-1 rounded-lg font-bold mb-2" style="background-color: {{ $jurusan->warna ?? '#0284C7' }}">{{ $jurusan->singkatan }}</div>
            <h1 class="text-4xl md:text-5xl font-bold">{{ $jurusan->nama }}</h1>
        </div>
    </div>
</section>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-4">Tentang Jurusan</h2>
                <div class="prose max-w-none text-slate-700">{!! $jurusan->deskripsi !!}</div>
            </div>
            <aside class="space-y-6">
                @if($jurusan->ketuaJurusan)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-3">Ketua Jurusan</h3>
                    <div class="flex items-center gap-3">
                        @if($jurusan->ketuaJurusan->foto)
                        <img src="{{ asset('storage/' . $jurusan->ketuaJurusan->foto) }}" class="w-14 h-14 rounded-full object-cover">
                        @endif
                        <div>
                            <p class="font-semibold text-slate-800">{{ $jurusan->ketuaJurusan->nama }}</p>
                            <p class="text-xs text-slate-500">{{ $jurusan->ketuaJurusan->jabatan ?? 'Ketua Jurusan' }}</p>
                        </div>
                    </div>
                    @if($jurusan->ketuaJurusan->sambutan)
                    <p class="text-sm text-slate-600 mt-3">{!! Str::limit(strip_tags($jurusan->ketuaJurusan->sambutan), 200) !!}</p>
                    @endif
                </div>
                @endif

                @if($jurusan->gurus->count() > 0)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
                    <h3 class="font-bold text-slate-800 mb-3">Guru Produktif</h3>
                    <ul class="space-y-2 text-sm">
                        @foreach($jurusan->gurus as $g)
                        <li class="text-slate-700">{{ $g->nama }} <span class="text-slate-400">— {{ $g->mapel }}</span></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </aside>
        </div>
    </div>
</section>

@if($jurusan->prestasis->count() > 0)
<section class="py-12 bg-bg-alt">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Prestasi Jurusan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($jurusan->prestasis as $p)
            <div class="bg-white rounded-2xl p-4 shadow-sm">
                <h4 class="font-semibold text-slate-800">{{ $p->judul }}</h4>
                <p class="text-sm text-slate-500">{{ $p->nama_siswa }} · {{ $p->tahun }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
