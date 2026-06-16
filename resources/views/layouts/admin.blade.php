<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/admin.js'])
    @stack('head')
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-nav { scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.2) transparent; }
        .sidebar-nav::-webkit-scrollbar { width: 6px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.35); }
    </style>
</head>
<body class="bg-slate-100 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        {{-- Sidebar Overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-30 w-64 bg-primary text-white transform transition-transform duration-300 flex flex-col lg:translate-x-0 lg:static lg:inset-auto">
            <div class="shrink-0 flex items-center justify-between h-16 px-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold">SMKN 2 Admin</a>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/70 hover:text-white">&times;</button>
            </div>
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto sidebar-nav">
                <x-admin.sidebar-link :href="route('admin.dashboard')" icon="home">Dashboard</x-admin.sidebar-link>
                <div class="pt-4 pb-2 text-xs uppercase tracking-wider text-white/40">Konten</div>
                <x-admin.sidebar-link :href="route('admin.artikels.index')" icon="newspaper">Artikel</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.jurusans.index')" icon="building">Jurusan</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.ketua-jurusans.index')" icon="academic-cap">Ketua Jurusan</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.videos.index')" icon="play-circle">Video</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.galeris.index')" icon="photograph">Galeri</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.gurus.index')" icon="users">Guru & Staff</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.prestasis.index')" icon="trophy">Prestasi</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.pengumumen.index')" icon="speakerphone">Pengumuman</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.ekstrakurikulers.index')" icon="star">Ekstrakurikuler</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.fasilitas.index')" icon="library">Fasilitas</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.sliders.index')" icon="photograph">Slider Hero</x-admin.sidebar-link>
                <div class="pt-4 pb-2 text-xs uppercase tracking-wider text-white/40">Pengaturan</div>
                <x-admin.sidebar-link :href="route('admin.sekolah.edit')" icon="cog">Pengaturan Sekolah</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.link-terkaits.index')" icon="link">Link Terkait</x-admin.sidebar-link>
                <x-admin.sidebar-link :href="route('admin.kontak.index')" icon="mail">Pesan Kontak</x-admin.sidebar-link>
                @hasrole('superadmin')
                <x-admin.sidebar-link :href="route('admin.users.index')" icon="user-group">Manajemen User</x-admin.sidebar-link>
                @endhasrole
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Topbar --}}
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-slate-200">
                <button @click="sidebarOpen = true" class="lg:hidden text-slate-500 hover:text-slate-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center space-x-4 ml-auto">
                    <span class="text-sm text-slate-600">{{ auth()->user()->name }}</span>
                    <span class="px-2 py-1 text-xs rounded bg-primary/10 text-primary">{{ auth()->user()->role }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-slate-500 hover:text-red-600">Logout</button>
                    </form>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center justify-between">
                        <span>{{ session('success') }}</span>
                        <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
