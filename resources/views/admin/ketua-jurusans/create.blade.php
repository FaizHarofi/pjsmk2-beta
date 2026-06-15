@extends('layouts.admin')
@section('title', 'Tambah Ketua Jurusan')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah Ketua Jurusan</h1>
    <form method="POST" action="{{ route('admin.ketua-jurusans.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Jurusan *</label>
            <select name="jurusan_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                <option value="">Pilih Jurusan</option>
                @foreach($jurusans as $jurusan)
                <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">NIP</label><input type="text" name="nip" value="{{ old('nip') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Jabatan</label><input type="text" name="jabatan" value="{{ old('jabatan') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Periode</label><input type="text" name="periode" value="{{ old('periode') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Foto</label><x-image-cropper name="foto" folder="ketua-jurusans" label="Gambar" aspect="4/5" :outputW="400" :outputH="500" /></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Sambutan</label><textarea name="sambutan" rows="5" class="w-full px-3 py-2 border border-slate-300 rounded-lg">{{ old('sambutan') }}</textarea></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300"> Aktif</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.ketua-jurusans.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
