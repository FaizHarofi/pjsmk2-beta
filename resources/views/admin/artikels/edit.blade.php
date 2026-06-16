@extends('layouts.admin')
@section('title', 'Edit Artikel')

@section('content')
<div class="max-w-3xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Artikel</h1>
    <form method="POST" action="{{ route('admin.artikels.update', $artikel) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label>
            <input type="text" name="judul" value="{{ old('judul', $artikel->judul) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="kategori_artikel_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_artikel_id', $artikel->kategori_artikel_id) == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tags</label>
                <input type="text" name="tags" value="{{ old('tags', $artikel->tags->pluck('nama')->implode(', ')) }}" placeholder="tag1, tag2, tag3" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Ringkasan</label>
            <textarea name="ringkasan" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('ringkasan', $artikel->ringkasan) }}</textarea>
        </div>
        <x-rich-text name="konten" :value="old('konten', $artikel->konten)" />
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
            @if($artikel->gambar)
            <img src="{{ asset('uploads/' . $artikel->gambar) }}" class="w-32 h-20 rounded object-cover mb-2">
            @endif
            <x-image-cropper name="gambar" folder="artikels" label="Gambar" :current="$artikel->gambar" aspect="16/9" :outputW="1200" :outputH="630" />
        </div>
        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $artikel->is_published) ? 'checked' : '' }} class="rounded border-slate-300"> Published
            </label>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $artikel->is_featured) ? 'checked' : '' }} class="rounded border-slate-300"> Featured
            </label>
        </div>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.artikels.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">Simpan</button>
        </div>
    </form>
</div>
@endsection
