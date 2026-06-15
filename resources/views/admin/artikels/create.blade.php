@extends('layouts.admin')
@section('title', 'Tambah Artikel')

@section('content')
<div class="max-w-3xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Artikel</h1>
    <form method="POST" action="{{ route('admin.artikels.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label>
            <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary">
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                <select name="kategori_artikel_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_artikel_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tags</label>
                <input type="text" name="tags" value="{{ old('tags') }}" placeholder="tag1, tag2, tag3" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Ringkasan</label>
            <textarea name="ringkasan" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('ringkasan') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Konten *</label>
            <textarea name="konten" rows="8" required class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('konten') }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label>
            <x-image-cropper name="gambar" folder="artikels" label="Gambar" aspect="16/9" :outputW="1200" :outputH="630" />
        </div>
        <div class="flex items-center gap-4">
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="rounded border-slate-300"> Published
            </label>
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-slate-300"> Featured
            </label>
        </div>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.artikels.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-lt">Simpan</button>
        </div>
    </form>
</div>
@endsection
