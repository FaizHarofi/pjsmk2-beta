@extends('layouts.admin')
@section('title', 'Prestasi')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Prestasi</h1>
    <a href="{{ route('admin.prestasis.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">+ Tambah</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3 font-medium text-slate-600">Judul</th><th class="px-4 py-3 font-medium text-slate-600">Siswa</th><th class="px-4 py-3 font-medium text-slate-600">Tingkat</th><th class="px-4 py-3 font-medium text-slate-600">Tahun</th><th class="px-4 py-3 font-medium text-slate-600">Aksi</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($prestasis as $p)
            @php $colors = ['sekolah' => 'bg-slate-100 text-slate-700', 'kota' => 'bg-blue-100 text-blue-700', 'provinsi' => 'bg-yellow-100 text-yellow-700', 'nasional' => 'bg-orange-100 text-orange-700', 'internasional' => 'bg-green-100 text-green-700']; @endphp
            <tr>
                <td class="px-4 py-3 font-medium text-slate-700">{{ Str::limit($p->judul, 40) }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $p->nama_siswa ?? '-' }}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded {{ $colors[$p->tingkat] ?? 'bg-slate-100 text-slate-700' }}">{{ ucfirst($p->tingkat) }}</span></td>
                <td class="px-4 py-3 text-slate-500">{{ $p->tahun ?? '-' }}</td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('admin.prestasis.edit', $p) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                    <form method="POST" action="{{ route('admin.prestasis.destroy', $p) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-4 py-8 text-center text-slate-400">Belum ada prestasi</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">{{ $prestasis->links() }}</div>
</div>
@endsection
