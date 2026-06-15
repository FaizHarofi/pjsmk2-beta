@extends('layouts.admin')
@section('title', 'Tambah User')
@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Tambah User</h1>
    <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Email *</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Password *</label><input type="password" name="password" required minlength="8" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Role *</label>
            <select name="role" required class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                @foreach($roles as $role)<option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>@endforeach
            </select>
        </div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Avatar</label><input type="file" name="avatar" accept="image/*" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-300"> Aktif</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
