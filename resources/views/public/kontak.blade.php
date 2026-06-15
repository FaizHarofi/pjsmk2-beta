@extends('layouts.app')
@section('title', 'Kontak Kami')

@section('content')
<div class="bg-bg-alt py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-slate-800">Hubungi Kami</h1>
        <p class="text-slate-500 mt-2">Sampaikan pesan dan pertanyaan Anda</p>
    </div>
</div>

<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h2 class="text-xl font-bold text-slate-800 mb-4">Kirim Pesan</h2>
                <form method="POST" action="{{ route('kontak.store') }}" class="space-y-4">
                    @csrf
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Nama *</label><input type="text" name="nama" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Email *</label><input type="email" name="email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Subjek</label><input type="text" name="subjek" class="w-full px-3 py-2 border border-slate-300 rounded-lg"></div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1">Pesan *</label><textarea name="pesan" rows="5" required class="w-full px-3 py-2 border border-slate-300 rounded-lg"></textarea></div>
                    <button type="submit" class="px-6 py-2 bg-primary text-white rounded-lg font-semibold">Kirim Pesan</button>
                </form>
            </div>
            <div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-4">
                    <h2 class="text-xl font-bold text-slate-800 mb-3">Informasi Kontak</h2>
                    <p class="text-slate-600">{{ $sekolah->alamat ?? '-' }}</p>
                    <hr class="my-3">
                    <p class="text-sm"><strong>Telepon:</strong> {{ $sekolah->telepon ?? '-' }}</p>
                    <p class="text-sm"><strong>Email:</strong> {{ $sekolah->email ?? '-' }}</p>
                    <p class="text-sm"><strong>Website:</strong> {{ $sekolah->website ?? '-' }}</p>
                </div>
                @if($sekolah && $sekolah->latitude)
                <div class="rounded-2xl overflow-hidden">
                    <iframe src="https://www.google.com/maps?q={{ $sekolah->latitude }},{{ $sekolah->longitude }}&hl=id&z=15&output=embed" class="w-full h-80 border-0"></iframe>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
