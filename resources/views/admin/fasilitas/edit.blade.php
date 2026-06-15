@extends('layouts.admin')
@section('title', 'Edit Fasilitas')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Fasilitas</h1>
    <form method="POST" action="{{ route('admin.fasilitas.update', $fasilitas) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="nama" value="{{ old('nama', $fasilitas->nama) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('deskripsi', $fasilitas->deskripsi) }}</textarea></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Icon</label><input type="text" name="icon" value="{{ old('icon', $fasilitas->icon) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label><input type="number" name="urutan" value="{{ old('urutan', $fasilitas->urutan) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
            @if($fasilitas->gambar)<img src="{{ asset('storage/' . $fasilitas->gambar) }}" class="w-32 h-20 rounded object-cover mb-2">@endif
            <x-image-cropper name="gambar" folder="fasilitas" label="Gambar" :current="$fasilitas->gambar" aspect="3/2" :outputW="1200" :outputH="800" />
        </div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $fasilitas->is_active) ? 'checked' : '' }} class="rounded border-slate-300"> Aktif</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.fasilitas.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
