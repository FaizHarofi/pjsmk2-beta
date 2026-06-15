@extends('layouts.admin')
@section('title', 'Tambah Album')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Album</h1>
    <form method="POST" action="{{ route('admin.galeris.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label><input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('deskripsi') }}</textarea></div>
        <x-image-cropper name="cover" folder="galeris" label="Cover Album" aspect="16/9" :outputW="1920" />
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded border-slate-300"> Published</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.galeris.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
