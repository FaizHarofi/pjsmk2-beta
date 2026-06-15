@extends('layouts.admin')
@section('title', 'Pengaturan Sekolah')
@section('content')
<h1 class="text-2xl font-bold text-slate-800 mb-6">Pengaturan Sekolah</h1>
<form method="POST" action="{{ route('admin.sekolah.update') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-6">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama Sekolah *</label><input type="text" name="nama" value="{{ old('nama', $sekolah->nama) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">NPSN</label><input type="text" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
    </div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label><textarea name="alamat" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('alamat', $sekolah->alamat) }}</textarea></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Telepon</label><input type="text" name="telepon" value="{{ old('telepon', $sekolah->telepon) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email', $sekolah->email) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Website</label><input type="url" name="website" value="{{ old('website', $sekolah->website) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
    </div>
    <h3 class="font-semibold text-slate-700 pt-4 border-t border-slate-200">Visi & Misi</h3>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Visi</label><textarea name="visi" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('visi', $sekolah->visi) }}</textarea></div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Misi</label><textarea name="misi" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('misi', $sekolah->misi) }}</textarea></div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Sejarah</label><textarea name="sejarah" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('sejarah', $sekolah->sejarah) }}</textarea></div>
    <h3 class="font-semibold text-slate-700 pt-4 border-t border-slate-200">Kepala Sekolah</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama</label><input type="text" name="nama_kepsek" value="{{ old('nama_kepsek', $sekolah->nama_kepsek) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Foto</label>
            @if($sekolah->foto_kepsek)<img src="{{ asset('storage/' . $sekolah->foto_kepsek) }}" class="w-20 h-24 rounded object-cover mb-2">@endif
            <x-image-cropper name="foto_kepsek" folder="sekolah/kepsek" label="Foto Kepala Sekolah" :current="$sekolah->foto_kepsek" aspect="4/5" :outputW="400" :outputH="500" />
        </div>
    </div>
    <div><label class="block text-sm font-medium text-slate-700 mb-1">Kata Sambutan</label><textarea name="kata_sambutan" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('kata_sambutan', $sekolah->kata_sambutan) }}</textarea></div>
    <h3 class="font-semibold text-slate-700 pt-4 border-t border-slate-200">Media Sosial</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Facebook</label><input type="url" name="facebook_url" value="{{ old('facebook_url', $sekolah->facebook_url) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Instagram</label><input type="url" name="instagram_url" value="{{ old('instagram_url', $sekolah->instagram_url) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">YouTube</label><input type="url" name="youtube_url" value="{{ old('youtube_url', $sekolah->youtube_url) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">TikTok</label><input type="url" name="tiktok_url" value="{{ old('tiktok_url', $sekolah->tiktok_url) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
    </div>
    <h3 class="font-semibold text-slate-700 pt-4 border-t border-slate-200">Peta</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Latitude</label><input type="number" step="0.0000001" name="latitude" value="{{ old('latitude', $sekolah->latitude) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Longitude</label><input type="number" step="0.0000001" name="longitude" value="{{ old('longitude', $sekolah->longitude) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
    </div>
    <h3 class="font-semibold text-slate-700 pt-4 border-t border-slate-200">Media</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Logo</label>
            @if($sekolah->logo)<img src="{{ asset('storage/' . $sekolah->logo) }}" class="w-20 h-20 rounded mb-2">@endif
            <x-image-cropper name="logo" folder="sekolah/logo" label="Logo Sekolah" :current="$sekolah->logo" aspect="1/1" :outputW="200" :outputH="200" />
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Favicon</label>
            @if($sekolah->favicon)<img src="{{ asset('storage/' . $sekolah->favicon) }}" class="w-12 h-12 rounded mb-2">@endif
            <x-image-cropper name="favicon" folder="sekolah/favicon" label="Favicon" :current="$sekolah->favicon" aspect="1/1" :outputW="64" :outputH="64" />
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Hero Image</label>
            @if($sekolah->hero_image)<img src="{{ asset('storage/' . $sekolah->hero_image) }}" class="w-32 h-20 rounded object-cover mb-2">@endif
            <x-image-cropper name="hero_image" folder="sekolah/hero" label="Hero Image" :current="$sekolah->hero_image" aspect="12/5" :outputW="1920" :outputH="800" />
        </div>
    </div>
    <div class="pt-4">
        <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg text-sm">Simpan Pengaturan</button>
    </div>
</form>
@endsection
