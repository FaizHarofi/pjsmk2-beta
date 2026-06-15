@extends('layouts.admin')
@section('title', 'Tambah Slider')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Slider</h1>
    <form method="POST" action="{{ route('admin.sliders.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Judul</label><input type="text" name="judul" value="{{ old('judul') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Sub Judul</label><input type="text" name="sub_judul" value="{{ old('sub_judul') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Gambar *</label><x-image-cropper name="gambar" folder="sliders" label="Gambar" aspect="12/5" :outputW="1920" :outputH="800" /></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Link</label><input type="url" name="link" value="{{ old('link') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Teks Tombol</label><input type="text" name="tombol_text" value="{{ old('tombol_text', 'Selengkapnya') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label><input type="number" name="urutan" value="{{ old('urutan', 0) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300"> Aktif</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.sliders.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
