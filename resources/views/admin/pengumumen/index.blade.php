@extends('layouts.admin')
@section('title', 'Pengumuman')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Pengumuman</h1>
    <a href="{{ route('admin.pengumumen.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">+ Tambah</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3 font-medium text-slate-600">Judul</th><th class="px-4 py-3 font-medium text-slate-600">Status</th><th class="px-4 py-3 font-medium text-slate-600">Urgent</th><th class="px-4 py-3 font-medium text-slate-600">Expired</th><th class="px-4 py-3 font-medium text-slate-600">Aksi</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($pengumumen as $p)
            <tr>
                <td class="px-4 py-3 font-medium text-slate-700">{{ Str::limit($p->judul, 50) }}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded {{ $p->is_published ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">{{ $p->is_published ? 'Published' : 'Draft' }}</span></td>
                <td class="px-4 py-3">{!! $p->is_urgent ? '<span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Urgent</span>' : '-' !!}</td>
                <td class="px-4 py-3 text-slate-500">{{ $p->expired_at?->format('d M Y') ?? '-' }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('admin.pengumumen.edit', $p) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                    <form method="POST" action="{{ route('admin.pengumumen.destroy', $p) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada pengumuman</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">{{ $pengumumen->links() }}</div>
</div>
@endsection
