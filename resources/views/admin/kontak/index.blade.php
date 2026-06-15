@extends('layouts.admin')
@section('title', 'Pesan Kontak')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Pesan Kontak</h1>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3 font-medium text-slate-600">Status</th><th class="px-4 py-3 font-medium text-slate-600">Nama</th><th class="px-4 py-3 font-medium text-slate-600">Email</th><th class="px-4 py-3 font-medium text-slate-600">Subjek</th><th class="px-4 py-3 font-medium text-slate-600">Waktu</th><th class="px-4 py-3 font-medium text-slate-600">Aksi</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($pesans as $p)
            <tr class="{{ !$p->is_read ? 'font-semibold' : '' }}">
                <td class="px-4 py-3">{!! $p->is_read ? '<span class="px-2 py-1 text-xs bg-slate-100 text-slate-500 rounded">Read</span>' : '<span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">New</span>' !!}</td>
                <td class="px-4 py-3 text-slate-700">{{ $p->nama }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $p->email }}</td>
                <td class="px-4 py-3 text-slate-700">{{ $p->subjek }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $p->created_at->diffForHumans() }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('admin.kontak.show', $p) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Lihat</a>
                    <form method="POST" action="{{ route('admin.kontak.destroy', $p) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada pesan</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">{{ $pesans->links() }}</div>
</div>
@endsection
