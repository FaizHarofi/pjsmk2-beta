@extends('layouts.admin')
@section('title', 'Edit Jurusan')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Jurusan</h1>
    <form method="POST" action="{{ route('admin.jurusans.update', $jurusan) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="nama" value="{{ old('nama', $jurusan->nama) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Singkatan</label><input type="text" name="singkatan" value="{{ old('singkatan', $jurusan->singkatan) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
            @if($jurusan->gambar)<img src="{{ asset('storage/' . $jurusan->gambar) }}" class="w-32 h-20 rounded object-cover mb-2">@endif
            <x-image-cropper name="gambar" folder="jurusans" label="Gambar" :current="$jurusan->gambar" aspect="4/3" :outputW="800" :outputH="600" />
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Icon</label><input type="text" name="icon" value="{{ old('icon', $jurusan->icon) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Warna</label><input type="color" name="warna" value="{{ old('warna', $jurusan->warna ?? '#3B82F6') }}" class="w-full h-10 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label><input type="number" name="urutan" value="{{ old('urutan', $jurusan->urutan) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $jurusan->is_active) ? 'checked' : '' }} class="rounded border-slate-300"> Aktif</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.jurusans.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection