@extends('layouts.admin')
@section('title', 'Edit Album')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Album</h1>
    <form method="POST" action="{{ route('admin.galeris.update', $galeri) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label><input type="text" name="judul" value="{{ old('judul', $galeri->judul) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('deskripsi', $galeri->deskripsi) }}</textarea></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Cover</label>
            @if($galeri->cover)<img src="{{ asset('uploads/' . $galeri->cover) }}" class="w-32 h-20 rounded object-cover mb-2">@endif
            <x-image-cropper name="cover" folder="galeris" label="Cover Album" :current="$galeri->cover" aspect="16/9" :outputW="1920" />
        </div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $galeri->is_published) ? 'checked' : '' }} class="rounded border-slate-300"> Published</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.galeris.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
