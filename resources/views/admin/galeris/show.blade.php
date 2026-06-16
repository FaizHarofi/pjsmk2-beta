@extends('layouts.admin')
@section('title', 'Kelola Album')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.galeris.index') }}" class="text-sm text-slate-500 hover:text-slate-700">← Kembali</a>
    <h1 class="text-2xl font-bold text-slate-800">{{ $galeri->judul }}</h1>
    <p class="text-slate-500">{{ $galeri->fotos->count() }} foto</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
    <h2 class="font-semibold text-slate-800 mb-3">Upload Foto</h2>
    <form method="POST" action="{{ route('admin.galeris.upload', $galeri) }}" enctype="multipart/form-data" class="space-y-3">
        @csrf
        <input type="file" name="fotos[]" accept="image/*" multiple required class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Upload</button>
    </form>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse($galeri->fotos as $foto)
    <div class="relative group">
        <img src="{{ asset('uploads/' . $foto->file_path) }}" class="w-full h-40 object-cover rounded">
        <form method="POST" action="{{ route('admin.galeris.delete-foto', $foto) }}" onsubmit="return confirm('Hapus foto ini?')" class="absolute top-2 right-2">
            @csrf @method('DELETE')
            <button type="submit" class="px-2 py-1 bg-red-600 text-white text-xs rounded opacity-0 group-hover:opacity-100">Hapus</button>
        </form>
    </div>
    @empty
    <div class="col-span-4 text-center text-slate-400 py-8">Belum ada foto</div>
    @endforelse
</div>
@endsection
