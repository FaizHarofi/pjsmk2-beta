@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="max-w-xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Edit User</h1>
    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 space-y-4">
        @csrf @method('PUT')
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Email *</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div><label class="block text-sm font-medium text-slate-700 mb-1">Password (kosongkan jika tidak diubah)</label><input type="password" name="password" minlength="8" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Role *</label>
            <select name="role" required class="w-full px-3 py-2 border border-slate-300 rounded-lg">
                @foreach($roles as $role)<option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>@endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Avatar</label>
            @if($user->avatar)<img src="{{ asset('storage/' . $user->avatar) }}" class="w-16 h-16 rounded-full mb-2">@endif
            <input type="file" name="avatar" accept="image/*" class="w-full px-3 py-2 border border-slate-300 rounded-lg">
        </div>
        <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded border-slate-300"> Aktif</label>
        <div class="flex gap-3 pt-4">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">Simpan</button>
        </div>
    </form>
</div>
@endsection
