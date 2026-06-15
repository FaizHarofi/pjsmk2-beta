@extends('layouts.admin')
@section('title', 'Slider Hero')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Slider Hero</h1>
    <a href="{{ route('admin.sliders.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">+ Tambah</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @forelse($sliders as $slider)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="h-40 bg-slate-100 relative">
            @if($slider->gambar)
            <img src="{{ asset('storage/' . $slider->gambar) }}" class="w-full h-full object-cover">
            @endif
            <span class="absolute top-2 right-2 px-2 py-1 text-xs rounded {{ $slider->is_active ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}</span>
        </div>
        <div class="p-4">
            <h3 class="font-semibold text-slate-800">{{ $slider->judul ?? '(Tanpa Judul)' }}</h3>
            <p class="text-sm text-slate-500 mt-1">{{ Str::limit($slider->sub_judul, 60) }}</p>
            <div class="flex gap-2 mt-3">
                <a href="{{ route('admin.sliders.edit', $slider) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-2 text-center text-slate-400 py-8">Belum ada slider</div>
    @endforelse
</div>
<div class="mt-6">{{ $sliders->links() }}</div>
@endsection
