@extends('layouts.admin')
@section('title', 'Jurusan')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Jurusan</h1>
    <a href="{{ route('admin.jurusans.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">+ Tambah Jurusan</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3 font-medium text-slate-600">Nama</th>
                <th class="px-4 py-3 font-medium text-slate-600">Singkatan</th>
                <th class="px-4 py-3 font-medium text-slate-600">Status</th>
                <th class="px-4 py-3 font-medium text-slate-600">Urutan</th>
                <th class="px-4 py-3 font-medium text-slate-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($jurusans as $j)
            <tr>
                <td class="px-4 py-3 font-medium text-slate-700">{{ $j->nama }}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 bg-slate-100 rounded text-xs">{{ $j->singkatan }}</span></td>
                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded {{ $j->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $j->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-4 py-3 text-slate-500">{{ $j->urutan }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('admin.jurusans.edit', $j) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                    <form method="POST" action="{{ route('admin.jurusans.destroy', $j) }}" onsubmit="return confirm('Hapus jurusan ini?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada jurusan</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">{{ $jurusans->links() }}</div>
</div>
@endsection