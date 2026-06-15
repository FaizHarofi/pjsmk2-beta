@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
    <p class="text-slate-500">Selamat datang di panel admin SMKN 2 Pekanbaru</p>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Total Artikel</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalArtikel }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-xl">📰</div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Artikel Draft</p>
                <p class="text-3xl font-bold text-amber-600">{{ $draftArtikel }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center text-xl">📝</div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Total Video</p>
                <p class="text-3xl font-bold text-red-600">{{ $totalVideo }}</p>
            </div>
            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-xl">🎥</div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Pesan Baru</p>
                <p class="text-3xl font-bold text-green-600">{{ $pesanBaru }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-xl">📬</div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Total Guru</p>
                <p class="text-3xl font-bold text-purple-600">{{ $totalGuru }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-xl">👥</div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Total Jurusan</p>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalJurusan }}</p>
            </div>
            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center text-xl">🏫</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Recent Articles --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-4 border-b border-slate-200">
            <h2 class="font-semibold text-slate-800">Artikel Terbaru</h2>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentArtikels as $artikel)
            <div class="p-4 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-700">{{ Str::limit($artikel->judul, 40) }}</p>
                    <p class="text-xs text-slate-400">{{ $artikel->kategori->nama ?? 'Tanpa Kategori' }} · {{ $artikel->created_at->diffForHumans() }}</p>
                </div>
                <span class="px-2 py-1 text-xs rounded {{ $artikel->is_published ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $artikel->is_published ? 'Published' : 'Draft' }}
                </span>
            </div>
            @empty
            <div class="p-4 text-sm text-slate-400">Belum ada artikel</div>
            @endforelse
        </div>
    </div>

    {{-- Recent Messages --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200">
        <div class="p-4 border-b border-slate-200">
            <h2 class="font-semibold text-slate-800">Pesan Kontak Terbaru</h2>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentPesan as $pesan)
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-slate-700">{{ $pesan->nama }}</p>
                    <span class="px-2 py-1 text-xs rounded {{ $pesan->is_read ? 'bg-slate-100 text-slate-500' : 'bg-blue-100 text-blue-700' }}">
                        {{ $pesan->is_read ? 'Read' : 'New' }}
                    </span>
                </div>
                <p class="text-xs text-slate-400">{{ $pesan->subjek }} · {{ $pesan->created_at->diffForHumans() }}</p>
            </div>
            @empty
            <div class="p-4 text-sm text-slate-400">Belum ada pesan</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
