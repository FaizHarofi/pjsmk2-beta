@extends('layouts.admin')
@section('title', 'Manajemen User')
@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Manajemen User</h1>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-sm">+ Tambah User</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left">
            <tr><th class="px-4 py-3 font-medium text-slate-600">Nama</th><th class="px-4 py-3 font-medium text-slate-600">Email</th><th class="px-4 py-3 font-medium text-slate-600">Role</th><th class="px-4 py-3 font-medium text-slate-600">Status</th><th class="px-4 py-3 font-medium text-slate-600">Aksi</th></tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @foreach($users as $user)
            <tr>
                <td class="px-4 py-3 font-medium text-slate-700">{{ $user->name }}</td>
                <td class="px-4 py-3 text-slate-500">{{ $user->email }}</td>
                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded bg-primary/10 text-primary">{{ $user->roles->first()?->name ?? '-' }}</span></td>
                <td class="px-4 py-3"><span class="px-2 py-1 text-xs rounded {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded">Hapus</button></form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-200">{{ $users->links() }}</div>
</div>
@endsection
