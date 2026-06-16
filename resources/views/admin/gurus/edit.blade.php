@extends('layouts.admin')
@section('title', 'Edit Guru')

@section('content')
<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit Guru</h1>
    <form method="POST" action="{{ route('admin.gurus.update', $guru) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="nama" value="{{ old('nama', $guru->nama) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">NIP</label><input type="text" name="nip" value="{{ old('nip', $guru->nip) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Jabatan</label><input type="text" name="jabatan" value="{{ old('jabatan', $guru->jabatan) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Mata Pelajaran</label><input type="text" name="mapel" value="{{ old('mapel', $guru->mapel) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Jurusan</label>
                <select name="jurusan_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                    <option value="">-</option>
                    @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $guru->jurusan_id) == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email', $guru->email) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Foto</label>
            @if($guru->foto)<img src="{{ asset('uploads/' . $guru->foto) }}" class="w-20 h-24 rounded object-cover mb-2">@endif
            <x-image-cropper name="foto" folder="gurus" label="Gambar" :current="$guru->foto" aspect="4/5" :outputW="400" :outputH="500" />
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-slate-700 mb-1">Urutan</label><input type="number" name="urutan" value="{{ old('urutan', $guru->urutan) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
            <label class="flex items-center gap-2 text-sm self-end pb-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $guru->is_active) ? 'checked' : '' }} class="rounded border-slate-300"> Aktif</label>
        </div>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.gurus.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
