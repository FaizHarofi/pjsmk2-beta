@extends('layouts.admin')
@section('title', 'Edit Link')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Link Terkait</h1>
    <form method="POST" action="{{ route('admin.link-terkaits.update', $linkTerkait) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="nama" value="{{ old('nama', $linkTerkait->nama) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">URL *</label><input type="url" name="url" value="{{ old('url', $linkTerkait->url) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
            @if($linkTerkait->logo)<img src="{{ asset('uploads/' . $linkTerkait->logo) }}" class="w-20 h-20 rounded mb-2">@endif
            <x-image-cropper name="logo" folder="links" label="Gambar" :current="$linkTerkait->logo" aspect="1/1" :outputW="300" :outputH="300" />
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label><input type="number" name="urutan" value="{{ old('urutan', $linkTerkait->urutan) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $linkTerkait->is_active) ? 'checked' : '' }} class="rounded border-slate-300"> Aktif</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.link-terkaits.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
