@extends('layouts.admin')
@section('title', 'Artikel')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Artikel</h1>
    <a href="{{ route('admin.artikels.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">+ Tambah Artikel</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200">
    <div class="p-4 border-b border-slate-200 flex flex-wrap gap-3">
        <input type="text" name="search" placeholder="Cari artikel..." value="{{ request('search') }}" class="px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary">
        <select name="kategori" class="px-3 py-2 border border-slate-300 rounded-lg text-sm">
            <option value="">Semua Kategori</option>
            @foreach($kategoris as $k)
            <option value="{{ $k->id }}" {{ request('kategori') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
        <select name="status" class="px-3 py-2 border border-slate-300 rounded-lg text-sm">
            <option value="">Semua Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <button onclick="event.target.closest('form') ? event.target.closest('form').submit() : window.location = window.location.pathname" class="px-3 py-2 bg-slate-100 rounded-lg text-sm hover:bg-slate-200">Filter</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium text-slate-600">Judul</th>
                    <th class="px-4 py-3 font-medium text-slate-600">Kategori</th>
                    <th class="px-4 py-3 font-medium text-slate-600">Penulis</th>
                    <th class="px-4 py-3 font-medium text-slate-600">Status</th>
                    <th class="px-4 py-3 font-medium text-slate-600">Tanggal</th>
                    <th class="px-4 py-3 font-medium text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($artikels as $artikel)
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($artikel->gambar)
                            <img src="{{ asset('storage/' . $artikel->gambar) }}" class="w-10 h-10 rounded object-cover">
                            @endif
                            <span class="font-medium text-slate-700">{{ Str::limit($artikel->judul, 50) }}</span>
                            @if($artikel->is_featured)<span class="px-1.5 py-0.5 text-xs bg-amber-100 text-amber-700 rounded">Featured</span>@endif
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $artikel->kategori->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $artikel->user->name }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded {{ $artikel->is_published ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $artikel->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $artikel->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <form method="POST" action="{{ route('admin.artikels.toggle-publish', $artikel) }}">
                                @csrf
                                <button type="submit" class="text-xs px-2 py-1 rounded {{ $artikel->is_published ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">{{ $artikel->is_published ? 'Unpublish' : 'Publish' }}</button>
                            </form>
                            <a href="{{ route('admin.artikels.edit', $artikel) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                            <form method="POST" action="{{ route('admin.artikels.destroy', $artikel) }}" onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada artikel</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-slate-200">{{ $artikels->links() }}</div>
</div>
@endsection
