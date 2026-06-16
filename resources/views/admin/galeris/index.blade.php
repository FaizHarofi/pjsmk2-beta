@extends('layouts.admin')
@section('title', 'Galeri')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Galeri / Album</h1>
    <a href="{{ route('admin.galeris.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">+ Tambah Album</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($albums as $album)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="h-40 bg-slate-100 relative">
            @if($album->cover)
            <img src="{{ asset('uploads/' . $album->cover) }}" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center text-4xl text-slate-300">🖼️</div>
            @endif
            <span class="absolute top-2 right-2 px-2 py-1 text-xs rounded {{ $album->is_published ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $album->is_published ? 'Published' : 'Draft' }}</span>
        </div>
        <div class="p-4">
            <h3 class="font-semibold text-slate-800">{{ $album->judul }}</h3>
            <p class="text-sm text-slate-500 mt-1">{{ $album->fotos_count }} foto</p>
            <div class="flex gap-2 mt-3">
                <a href="{{ route('admin.galeris.show', $album) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Kelola</a>
                <a href="{{ route('admin.galeris.edit', $album) }}" class="text-xs px-2 py-1 bg-slate-100 text-slate-700 rounded">Edit</a>
                <form method="POST" action="{{ route('admin.galeris.destroy', $album) }}" onsubmit="return confirm('Hapus album ini?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center text-slate-400 py-8">Belum ada album</div>
    @endforelse
</div>

<div class="mt-6">{{ $albums->links() }}</div>
@endsection
