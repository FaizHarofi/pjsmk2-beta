@extends('layouts.admin')
@section('title', 'Edit Video')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Video</h1>
    <form method="POST" action="{{ route('admin.videos.update', $video) }}" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label><input type="text" name="judul" value="{{ old('judul', $video->judul) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
            <select name="kategori_video_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $k)
                <option value="{{ $k->id }}" {{ old('kategori_video_id', $video->kategori_video_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                @endforeach
            </select>
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">YouTube URL *</label><input type="url" name="youtube_url" value="{{ old('youtube_url', $video->youtube_url) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        @if($video->youtube_embed)
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Preview</label>
            <iframe src="{{ $video->youtube_embed }}" class="w-full aspect-video rounded"></iframe>
        </div>
        @endif
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('deskripsi', $video->deskripsi) }}</textarea></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label><input type="number" name="urutan" value="{{ old('urutan', $video->urutan) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $video->is_published) ? 'checked' : '' }} class="rounded border-slate-300"> Published</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $video->is_featured) ? 'checked' : '' }} class="rounded border-slate-300"> Featured</label>
        </div>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
