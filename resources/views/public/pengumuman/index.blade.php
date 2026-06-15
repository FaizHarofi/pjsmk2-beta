@extends('layouts.app')
@section('title', 'Pengumuman')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Pengumuman</h1>
        <p class="text-slate-500 mt-2">Pengumuman resmi dari sekolah</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4 max-w-3xl space-y-4">
        @forelse($pengumumen as $p)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 {{ $p->is_urgent ? 'border-l-4 border-l-red-500' : '' }}">
            <div class="flex items-center gap-2 mb-2">
                @if($p->is_urgent)<span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">URGENT</span>@endif
                <span class="text-xs text-slate-400">{{ $p->published_at?->format('d M Y') }}</span>
            </div>
            <h3 class="text-lg font-bold text-slate-800">{{ $p->judul }}</h3>
            <div class="prose max-w-none text-slate-600 mt-2">{!! $p->konten !!}</div>
        </div>
        @empty
        <p class="text-slate-400 text-center py-12">Belum ada pengumuman.</p>
        @endforelse
        <div>{{ $pengumumen->links() }}</div>
    </div>
</section>
@endsection
