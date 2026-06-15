@extends('layouts.admin')
@section('title', 'Detail Pesan')
@section('content')
<div class="max-w-2xl">
    <a href="{{ route('admin.kontak.index') }}" class="text-sm text-slate-500 hover:text-slate-700">← Kembali</a>
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mt-4">
        <h1 class="text-xl font-bold text-slate-800">{{ $kontak->subjek ?? '(Tanpa Subjek)' }}</h1>
        <div class="text-sm text-slate-500 mt-2">
            Dari: <strong>{{ $kontak->nama }}</strong> &lt;{{ $kontak->email }}&gt;
        </div>
        <div class="text-xs text-slate-400 mt-1">{{ $kontak->created_at->format('d M Y H:i') }}</div>
        <hr class="my-4">
        <div class="prose max-w-none text-slate-700">
            {!! nl2br(e($kontak->pesan)) !!}
        </div>
        <div class="mt-6 flex gap-2">
            <form method="POST" action="{{ route('admin.kontak.destroy', $kontak) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm">Hapus</button></form>
            <form method="POST" action="{{ route('admin.kontak.read', $kontak) }}">@csrf<button type="submit" class="px-4 py-2 bg-slate-100 rounded-lg text-sm">{{ $kontak->is_read ? 'Tandai Belum Dibaca' : 'Tandai Sudah Dibaca' }}</button></form>
        </div>
    </div>
</div>
@endsection
