@extends('layouts.admin')
@section('title', 'Guru & Staff')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Guru & Staff</h1>
    <a href="{{ route('admin.gurus.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">+ Tambah Guru</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr>
                <th class="px-4 py-3 font-medium text-slate-600">Foto</th>
                <th class="px-4 py-3 font-medium text-slate-600">Nama</th>
                <th class="px-4 py-3 font-medium text-slate-600">Jabatan</th>
                <th class="px-4 py-3 font-medium text-slate-600">Mapel</th>
                <th class="px-4 py-3 font-medium text-slate-600">Status</th>
                <th class="px-4 py-3 font-medium text-slate-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($gurus as $guru)
            <tr>
                <td class="px-4 py-3">
                    @if($guru->foto)<img src="{{ asset('uploads/' . $guru->foto) }}" class="w-10 h-12 rounded object-cover">@else<div class="w-10 h-12 bg-slate-200 rounded"></div>@endif
                </td>
                <td class="px-4 py-3 font-medium text-slate-700">{{ $guru->nama }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $guru->jabatan ?? '-' }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $guru->mapel ?? '-' }}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded {{ $guru->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $guru->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('admin.gurus.edit', $guru) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                    <form method="POST" action="{{ route('admin.gurus.destroy', $guru) }}" onsubmit="return confirm('Hapus guru ini?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada guru</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">{{ $gurus->links() }}</div>
</div>
@endsection
