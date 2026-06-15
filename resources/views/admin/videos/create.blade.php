@extends('layouts.admin')
@section('title', 'Tambah Video')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Video</h1>
    <form method="POST" action="{{ route('admin.videos.store') }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label><input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
            <select name="kategori_video_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ old('kategori_video_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">YouTube URL *</label><input type="url" name="youtube_url" value="{{ old('youtube_url') }}" required placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('deskripsi') }}</textarea></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label><input type="number" name="urutan" value="{{ old('urutan', 0) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded border-slate-300"> Published</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-slate-300"> Featured</label>
        </div>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
