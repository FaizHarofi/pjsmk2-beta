<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '') — {{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ (sekolah() && sekolah()->favicon) ? asset('uploads/' . sekolah()->favicon) : asset('assets/img/favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="description" content="@yield('description', sekolah()->nama ?? 'Website Resmi')">
    <meta property="og:title" content="@yield('title', '') — {{ sekolah()->nama ?? '' }}">
    <meta property="og:description" content="@yield('description', '')">
    <meta property="og:image" content="@yield('image', (sekolah() && sekolah()->logo) ? asset('uploads/' . sekolah()->logo) : '')">
    <meta property="og:type" content="website">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-900 antialiased">

{{-- Topbar --}}
<div class="bg-primary text-white text-sm">
    <div class="container mx-auto px-4 py-2 flex flex-wrap items-center justify-between gap-2">
        <div class="flex items-center gap-4 flex-wrap">
            @if(sekolah() && sekolah()->telepon)
            <span class="flex items-center gap-1">📞 {{ sekolah()->telepon }}</span>
            @endif
            @if(sekolah() && sekolah()->email)
            <span class="flex items-center gap-1">✉️ {{ sekolah()->email }}</span>
            @endif
        </div>
        <div class="flex items-center gap-3">
            @if(sekolah() && sekolah()->facebook_url)<a href="{{ sekolah()->facebook_url }}" target="_blank" class="hover:opacity-80">Facebook</a>@endif
            @if(sekolah() && sekolah()->instagram_url)<a href="{{ sekolah()->instagram_url }}" target="_blank" class="hover:opacity-80">Instagram</a>@endif
            @if(sekolah() && sekolah()->youtube_url)<a href="{{ sekolah()->youtube_url }}" target="_blank" class="hover:opacity-80">YouTube</a>@endif
        </div>
    </div>
</div>

{{-- Navbar --}}
<nav x-data="{ open: false, profil: false, jurusan: false }" class="sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if(sekolah() && sekolah()->logo)
                <img src="{{ asset('uploads/' . sekolah()->logo) }}" class="h-10 w-10 object-contain" alt="Logo">
                <div class="font-bold text-primary leading-tight">{{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</div>
                @else
                <img src="{{ asset('assets/img/logo.png') }}" class="h-10 w-10 object-contain" alt="Logo">
                <div>
                    <div class="font-bold text-primary leading-tight">{{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</div>
                    <div class="text-xs text-slate-500">Pekanbaru</div>
                </div>
                @endif
            </a>
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}" class="px-3 py-2 text-sm rounded {{ request()->routeIs('home') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600' }}">Beranda</a>
                <div class="relative" @mouseenter="profil = true" @mouseleave="profil = false">
                    <button class="px-3 py-2 text-sm text-slate-700 hover:text-sky-600 flex items-center gap-1">Profil <span class="text-xs">▾</span></button>
                    <div x-show="profil" x-transition class="absolute top-full left-0 bg-white border border-slate-200 rounded-lg shadow-lg w-48 py-1">
                        <a href="{{ route('profil.sejarah') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Sejarah</a>
                        <a href="{{ route('profil.visi-misi') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Visi & Misi</a>
                        <a href="{{ route('profil.fasilitas') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Fasilitas</a>
                    </div>
                </div>
                <div class="relative" @mouseenter="jurusan = true" @mouseleave="jurusan = false">
                    <button class="px-3 py-2 text-sm text-slate-700 hover:text-sky-600 flex items-center gap-1">Jurusan <span class="text-xs">▾</span></button>
                    <div x-show="jurusan" x-transition class="absolute top-full left-0 bg-white border border-slate-200 rounded-lg shadow-lg w-56 py-1">
                        @foreach(\App\Models\Jurusan::active()->ordered()->get() as $j)
                        <a href="{{ route('jurusans.show', $j->slug) }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">{{ $j->nama }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('artikels.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('artikels.*') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600' }}">Artikel</a>
                <a href="{{ route('videos.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('videos.*') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600' }}">Video</a>
                <a href="{{ route('galeris.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('galeris.*') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600' }}">Galeri</a>
                <a href="{{ route('gurus.index') }}" class="px-3 py-2 text-sm {{ request()->routeIs('gurus.*') ? 'text-sky-600 font-semibold' : 'text-slate-700 hover:text-sky-600' }}">Guru</a>
                <a href="{{ route('kontak.index') }}" class="px-4 py-2 ml-2 text-sm bg-secondary text-white rounded-lg hover:bg-amber-600">Kontak</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 ml-1 text-sm bg-primary text-white rounded-lg hover:bg-sky-800">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 ml-1 text-sm border border-primary text-primary rounded-lg hover:bg-primary hover:text-white">Login</a>
                @endauth
            </div>
            <button @click="open = !open" class="lg:hidden p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <div x-show="open" @click.away="open = false" class="lg:hidden border-t border-slate-200 bg-white">
        <div class="container mx-auto px-4 py-2 space-y-1">
            <a href="{{ route('home') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Beranda</a>
            <a href="{{ route('profil.sejarah') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Profil - Sejarah</a>
            <a href="{{ route('profil.visi-misi') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Profil - Visi Misi</a>
            <a href="{{ route('profil.fasilitas') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Profil - Fasilitas</a>
            <a href="{{ route('jurusans.index') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Jurusan</a>
            <a href="{{ route('artikels.index') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Artikel</a>
            <a href="{{ route('videos.index') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Video</a>
            <a href="{{ route('galeris.index') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Galeri</a>
            <a href="{{ route('gurus.index') }}" class="block px-3 py-2 text-sm rounded hover:bg-slate-50">Guru</a>
            <a href="{{ route('kontak.index') }}" class="block px-3 py-2 text-sm rounded bg-secondary text-white">Kontak</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 text-sm rounded bg-primary text-white">Admin Panel</a>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 text-sm rounded border border-primary text-primary">Login</a>
            @endauth
        </div>
    </div>
</nav>

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-transition class="bg-green-50 border-b border-green-200 text-green-700">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-green-500">&times;</button>
    </div>
</div>
@endif

<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-primary text-white mt-16">
    <div class="container mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
            <h3 class="font-bold text-lg mb-3">{{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</h3>
            <p class="text-sm text-white/80">{{ sekolah()->alamat ?? '-' }}</p>
            <p class="text-sm text-white/80 mt-2">{{ sekolah()->telepon ?? '-' }}</p>
            <p class="text-sm text-white/80">{{ sekolah()->email ?? '-' }}</p>
        </div>
        <div>
            <h3 class="font-bold mb-3">Jurusan</h3>
            <ul class="space-y-1 text-sm text-white/80">
                @foreach(\App\Models\Jurusan::active()->ordered()->take(4)->get() as $j)
                <li><a href="{{ route('jurusans.show', $j->slug) }}" class="hover:text-white">{{ $j->singkatan }} - {{ $j->nama }}</a></li>
                @endforeach
            </ul>
        </div>
        <div>
            <h3 class="font-bold mb-3">Link</h3>
            <ul class="space-y-1 text-sm text-white/80">
                <li><a href="{{ route('artikels.index') }}" class="hover:text-white">Artikel</a></li>
                <li><a href="{{ route('videos.index') }}" class="hover:text-white">Video</a></li>
                <li><a href="{{ route('galeris.index') }}" class="hover:text-white">Galeri</a></li>
                <li><a href="{{ route('gurus.index') }}" class="hover:text-white">Guru & Staff</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold mb-3">Sosial Media</h3>
            <div class="flex gap-3">
                @if(sekolah() && sekolah()->facebook_url)<a href="{{ sekolah()->facebook_url }}" target="_blank" class="hover:opacity-80">Facebook</a>@endif
                @if(sekolah() && sekolah()->instagram_url)<a href="{{ sekolah()->instagram_url }}" target="_blank" class="hover:opacity-80">Instagram</a>@endif
                @if(sekolah() && sekolah()->youtube_url)<a href="{{ sekolah()->youtube_url }}" target="_blank" class="hover:opacity-80">YouTube</a>@endif
            </div>
        </div>
    </div>
    <div class="border-t border-white/10">
        <div class="container mx-auto px-4 py-4 text-center text-sm text-white/60">
            &copy; {{ date('Y') }} {{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}. All rights reserved.
        </div>
    </div>
</footer>

</body>
</html>
