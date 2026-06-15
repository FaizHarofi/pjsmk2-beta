@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

@if($pengumumen->count() > 0)
<div class="bg-red-50 border-b border-red-200">
    <div class="container mx-auto px-4 py-2 flex items-center gap-3">
        <span class="px-2 py-1 text-xs bg-red-600 text-white rounded">URGENT</span>
        <div class="flex-1 overflow-hidden">
            <div class="flex gap-8 animate-marquee whitespace-nowrap">
                @foreach($pengumumen as $p)
                <a href="#" class="text-sm text-red-700 hover:underline">{{ $p->judul }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@if($sliders->count() > 0)
<section x-data="{ current: 0, count: {{ $sliders->count() }} }" x-init="setInterval(() => current = (current + 1) % count, 5000)" class="relative h-[600px] overflow-hidden">
    @foreach($sliders as $i => $slider)
    <div x-show="current === {{ $i }}" x-transition.opacity class="absolute inset-0">
        <img src="{{ asset('storage/' . $slider->gambar) }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        <div class="absolute inset-0 flex items-center justify-center text-center">
            <div class="container mx-auto px-4 text-white max-w-3xl">
                @if($slider->judul)<h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $slider->judul }}</h1>@endif
                @if($slider->sub_judul)<p class="text-lg md:text-xl text-white/90 mb-6">{{ $slider->sub_judul }}</p>@endif
                @if($slider->link && $slider->tombol_text)
                <a href="{{ $slider->link }}" class="inline-block px-6 py-3 bg-secondary text-white rounded-lg font-semibold hover:bg-amber-600">{{ $slider->tombol_text }}</a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        @foreach($sliders as $i => $slider)
        <button @click="current = {{ $i }}" :class="current === {{ $i }} ? 'bg-white' : 'bg-white/40'" class="w-2 h-2 rounded-full"></button>
        @endforeach
    </div>
</section>
@else
<section class="h-[400px] bg-gradient-to-br from-primary to-primary-lt flex items-center justify-center text-white text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $sekolah->nama ?? 'SMKN 2 Pekanbaru' }}</h1>
        <p class="text-lg md:text-xl text-white/90">Sekolah Unggul Berkarakter dan Berdaya Saing Global</p>
    </div>
</section>
@endif

@if($sekolah && $sekolah->nama_kepsek)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                @if($sekolah->foto_kepsek)
                <img src="{{ asset('storage/' . $sekolah->foto_kepsek) }}" class="w-64 h-80 object-cover rounded-2xl border-4 border-primary shadow-xl mx-auto">
                @endif
            </div>
            <div>
                <h2 class="text-sm uppercase tracking-widest text-sky-600 font-semibold mb-2">Sambutan Kepala Sekolah</h2>
                <h3 class="text-3xl font-bold text-slate-800 mb-4">{{ $sekolah->nama_kepsek }}</h3>
                <div class="prose max-w-none text-slate-600">{!! Str::limit(strip_tags($sekolah->kata_sambutan), 300) !!}</div>
                <a href="{{ route('profil.sejarah') }}" class="inline-block mt-4 px-5 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">Baca Selengkapnya →</a>
            </div>
        </div>
    </div>
</section>
@endif

@if($jurusans->count() > 0)
<section class="py-16 bg-bg-alt">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Jurusan Kami</h2>
            <p class="text-slate-500">Kompetensi Keahlian yang Tersedia</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($jurusans as $jurusan)
            <a href="{{ route('jurusans.show', $jurusan->slug) }}" class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-slate-100">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white text-2xl mb-4" style="background-color: {{ $jurusan->warna ?? '#0284C7' }}">
                    🎓
                </div>
                <div class="text-xs font-bold text-slate-400 uppercase mb-1">{{ $jurusan->singkatan }}</div>
                <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-sky-600">{{ $jurusan->nama }}</h3>
                <p class="text-sm text-slate-500 line-clamp-3">{!! Str::limit(strip_tags($jurusan->deskripsi), 100) !!}</p>
                <div class="text-sm text-sky-600 font-semibold mt-3">Lihat Detail →</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($artikels->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Artikel Terbaru</h2>
                <p class="text-slate-500">Berita dan Informasi Terkini</p>
            </div>
            <a href="{{ route('artikels.index') }}" class="text-sky-600 font-semibold text-sm hover:underline">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($artikels as $artikel)
            <a href="{{ route('artikels.show', $artikel->slug) }}" class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition border border-slate-100">
                <div class="h-48 bg-slate-100 overflow-hidden">
                    @if($artikel->gambar)
                    <img src="{{ asset('storage/' . $artikel->gambar) }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                    @endif
                </div>
                <div class="p-5">
                    @if($artikel->kategori)
                    <span class="inline-block px-2 py-1 text-xs rounded" style="background-color: {{ $artikel->kategori->warna }}20; color: {{ $artikel->kategori->warna }}">{{ $artikel->kategori->nama }}</span>
                    @endif
                    <h3 class="text-lg font-bold text-slate-800 mt-2 mb-2 group-hover:text-sky-600 line-clamp-2">{{ $artikel->judul }}</h3>
                    <p class="text-sm text-slate-500 line-clamp-2">{!! Str::limit(strip_tags($artikel->ringkasan), 120) !!}</p>
                    <div class="flex items-center justify-between mt-3 text-xs text-slate-400">
                        <span>{{ $artikel->published_at?->format('d M Y') }}</span>
                        <span>👁 {{ $artikel->views }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($videos->count() > 0)
<section class="py-16 bg-bg-alt">
    <div class="container mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Video</h2>
                <p class="text-slate-500">Video Kegiatan & Profil Sekolah</p>
            </div>
            <a href="{{ route('videos.index') }}" class="text-sky-600 font-semibold text-sm hover:underline">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($videos as $video)
            <a href="{{ route('videos.index') }}" class="group block">
                <div class="relative aspect-video bg-slate-900 rounded-2xl overflow-hidden">
                    <img src="{{ $video->thumbnail }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 rounded-full bg-white/90 flex items-center justify-center">▶</div>
                    </div>
                </div>
                <h3 class="text-base font-semibold text-slate-800 mt-2 group-hover:text-sky-600">{{ $video->judul }}</h3>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($prestasis->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Prestasi</h2>
            <p class="text-slate-500">Prestasi Siswa-siswi Kami</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($prestasis as $p)
            @php $colors = ['sekolah' => 'bg-slate-100 text-slate-700', 'kota' => 'bg-blue-100 text-blue-700', 'provinsi' => 'bg-yellow-100 text-yellow-700', 'nasional' => 'bg-orange-100 text-orange-700', 'internasional' => 'bg-green-100 text-green-700']; @endphp
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100">
                <div class="h-44 bg-slate-100">
                    @if($p->gambar)<img src="{{ asset('storage/' . $p->gambar) }}" class="w-full h-full object-cover">@endif
                </div>
                <div class="p-5">
                    <span class="px-2 py-1 text-xs rounded {{ $colors[$p->tingkat] ?? 'bg-slate-100 text-slate-700' }}">{{ ucfirst($p->tingkat) }}</span>
                    <h3 class="text-base font-bold text-slate-800 mt-2">{{ $p->judul }}</h3>
                    <p class="text-sm text-slate-500 mt-1">{{ $p->nama_siswa }} · {{ $p->tahun }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($albums->count() > 0)
<section class="py-16 bg-bg-alt">
    <div class="container mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Galeri</h2>
                <p class="text-slate-500">Dokumentasi Kegiatan Sekolah</p>
            </div>
            <a href="{{ route('galeris.index') }}" class="text-sky-600 font-semibold text-sm hover:underline">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($albums->take(4) as $album)
            <a href="{{ route('galeris.show', $album->slug) }}" class="relative aspect-square rounded-2xl overflow-hidden group">
                @if($album->cover)
                <img src="{{ asset('storage/' . $album->cover) }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                @elseif($album->fotos->first())
                <img src="{{ asset('storage/' . $album->fotos->first()->file_path) }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end p-3">
                    <span class="text-white text-sm font-semibold">{{ $album->judul }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($ekskuls->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">Ekstrakurikuler</h2>
            <p class="text-slate-500">Wadah Pengembangan Bakat Siswa</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($ekskuls as $e)
            <div class="bg-bg-alt rounded-2xl p-6 text-center hover:shadow-md transition">
                <div class="w-12 h-12 mx-auto mb-3 rounded-xl bg-primary/10 text-primary text-2xl flex items-center justify-center">⭐</div>
                <h3 class="font-bold text-slate-800">{{ $e->nama }}</h3>
                <p class="text-xs text-slate-500 mt-1">{{ $e->hari }} · {{ $e->jam }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($sekolah && $sekolah->latitude)
<section class="py-16 bg-bg-alt">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2 text-center">Kontak Kami</h2>
        <p class="text-slate-500 text-center mb-8">Hubungi kami untuk informasi lebih lanjut</p>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-3">Alamat</h3>
                <p class="text-slate-600">{{ $sekolah->alamat }}</p>
                <hr class="my-3">
                <h3 class="font-bold text-slate-800 mb-2">Telepon</h3>
                <p class="text-slate-600">{{ $sekolah->telepon }}</p>
                <hr class="my-3">
                <h3 class="font-bold text-slate-800 mb-2">Email</h3>
                <p class="text-slate-600">{{ $sekolah->email }}</p>
            </div>
            <div class="rounded-2xl overflow-hidden">
                <iframe src="https://www.google.com/maps?q={{ $sekolah->latitude }},{{ $sekolah->longitude }}&hl=id&z=15&output=embed" class="w-full h-full min-h-[300px] border-0"></iframe>
            </div>
        </div>
    </div>
</section>
@endif

@if($linkTerkaits->count() > 0)
<section class="py-12 bg-white border-t border-slate-200">
    <div class="container mx-auto px-4">
        <h3 class="text-center text-sm uppercase tracking-widest text-slate-500 mb-6">Link Terkait</h3>
        <div class="flex flex-wrap items-center justify-center gap-6">
            @foreach($linkTerkaits as $link)
            <a href="{{ $link->url }}" target="_blank" class="text-slate-600 hover:text-sky-600 text-sm font-semibold">{{ $link->nama }}</a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
