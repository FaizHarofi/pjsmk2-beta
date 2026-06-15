@extends('layouts.admin')
@section('title', 'Video')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Video</h1>
    <a href="{{ route('admin.videos.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">+ Tambah Video</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3 font-medium text-slate-600">Thumbnail</th>
                <th class="px-4 py-3 font-medium text-slate-600">Judul</th>
                <th class="px-4 py-3 font-medium text-slate-600">Kategori</th>
                <th class="px-4 py-3 font-medium text-slate-600">Views</th>
                <th class="px-4 py-3 font-medium text-slate-600">Status</th>
                <th class="px-4 py-3 font-medium text-slate-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($videos as $video)
            <tr>
                <td class="px-4 py-3">
                    @if($video->thumbnail)
                    <img src="{{ $video->thumbnail }}" class="w-20 h-12 object-cover rounded">
                    @else
                    <div class="w-20 h-12 bg-slate-200 rounded"></div>
                    @endif
                </td>
                <td class="px-4 py-3 font-medium text-slate-700">{{ Str::limit($video->judul, 40) }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $video->kategori->nama ?? '-' }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $video->views }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 text-xs rounded {{ $video->is_published ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $video->is_published ? 'Published' : 'Draft' }}</span>
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('admin.videos.edit', $video) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                    <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" onsubmit="return confirm('Hapus video ini?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada video</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">{{ $videos->links() }}</div>
</div>
@endsection
