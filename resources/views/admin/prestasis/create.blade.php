@extends('layouts.admin')
@section('title', 'Tambah Prestasi')
@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Prestasi</h1>
    <form method="POST" action="{{ route('admin.prestasis.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Judul *</label><input type="text" name="judul" value="{{ old('judul') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label><textarea name="deskripsi" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('deskripsi') }}</textarea></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama Siswa</label><input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Kelas</label><input type="text" name="kelas" value="{{ old('kelas') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jurusan</label>
                <select name="jurusan_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    <option value="">-</option>
                    @foreach($jurusans as $j)<option value="{{ $j->id }}" {{ old('jurusan_id') == $j->id ? 'selected' : '' }}>{{ $j->singkatan }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tingkat *</label>
                <select name="tingkat" required class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    <option value="sekolah">Sekolah</option><option value="kota">Kota</option><option value="provinsi">Provinsi</option><option value="nasional">Nasional</option><option value="internasional">Internasional</option>
                </select>
            </div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Tahun</label><input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" min="2000" max="2100" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Gambar</label><x-image-cropper name="gambar" folder="prestasis" label="Gambar" aspect="4/3" :outputW="800" :outputH="600" /></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_published" value="1" checked class="rounded border-slate-300"> Published</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.prestasis.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
