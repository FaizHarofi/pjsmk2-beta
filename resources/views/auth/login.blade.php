<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ (sekolah() && sekolah()->favicon) ? asset('storage/' . sekolah()->favicon) : asset('assets/img/favicon.ico') }}">

        <title>Login — {{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

        <style>
            [x-cloak]{display:none!important}
            body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc}
            .fd{font-family:'Space Grotesk',sans-serif}
            .brand-bg{background:linear-gradient(160deg,#0C4A6E 0%,#0369a1 60%,#0e7490 100%)}
            .input-base{width:100%;background:#f8fafc;border:1px solid #e2e8f0;border-radius:.5rem;padding:.625rem .75rem .625rem 2.5rem;font-size:.875rem;color:#0f172a;transition:all .15s}
            .input-base::placeholder{color:#94a3b8}
            .input-base:focus{outline:none;background:#fff;border-color:#0C4A6E;box-shadow:0 0 0 3px rgba(12,74,110,.15)}
            .input-base.is-error{background:#fef2f2;border-color:#f87171}
            .btn-primary{width:100%;background:#0C4A6E;color:#fff;font-weight:600;padding:.625rem 1rem;border-radius:.5rem;transition:all .15s}
            .btn-primary:hover:not(:disabled){background:#075985}
            .btn-primary:disabled{opacity:.7;cursor:wait}
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased min-h-screen">

        <div class="min-h-screen flex flex-col lg:flex-row">

            {{-- LEFT: BRAND --}}
            <aside class="hidden lg:flex lg:w-[40%] brand-bg text-white p-12 flex-col justify-between relative">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 relative z-10">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center overflow-hidden shadow-lg p-1.5">
                        @if(sekolah() && sekolah()->logo)
                            <img src="{{ asset('storage/' . sekolah()->logo) }}" class="w-full h-full object-contain" alt="Logo">
                        @else
                            <img src="{{ asset('assets/img/logo.png') }}" class="w-full h-full object-contain" alt="SMKN 2 Pekanbaru">
                        @endif
                    </div>
                    <div>
                        <div class="fd font-bold text-base leading-tight">{{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</div>
                        <div class="text-[11px] text-sky-200 uppercase tracking-widest">Admin Panel</div>
                    </div>
                </a>

                <div class="relative z-10 max-w-sm">
                    <h1 class="fd text-4xl font-bold leading-tight tracking-tight">
                        Selamat Datang di<br>
                        <span style="color:#fcd34d">Panel Admin</span> Sekolah.
                    </h1>
                    <p class="text-sky-100 text-sm mt-4 leading-relaxed">
                        Kelola seluruh konten website {{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }} dalam satu tempat yang terpadu.
                    </p>
                </div>

                <div class="relative z-10 text-xs text-sky-200/70">
                    &copy; {{ date('Y') }} {{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}
                </div>
            </aside>

            {{-- RIGHT: FORM --}}
            <main class="flex-1 flex items-center justify-center px-6 py-10 sm:px-10 bg-white">
                <div class="w-full max-w-sm">

                    {{-- Mobile brand --}}
                    <div class="lg:hidden flex items-center gap-3 mb-8 justify-center">
                        <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center overflow-hidden border border-slate-200 p-1">
                            <img src="{{ asset('assets/img/logo.png') }}" class="w-full h-full object-contain" alt="Logo">
                        </div>
                        <div class="fd font-bold text-[#0C4A6E]">{{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</div>
                    </div>

                    <div class="mb-7">
                        <h2 class="fd text-2xl font-bold text-slate-900">Masuk ke Akun Anda</h2>
                        <p class="text-slate-500 text-sm mt-1">Gunakan email dan password admin.</p>
                    </div>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" x-data="{ loading: false, showPwd: false }" @submit="loading = true" class="space-y-4">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                    class="input-base @error('email') is-error @enderror"
                                    placeholder="nama@smkn2pekanbaru.sch.id">
                            </div>
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-xs text-[#0C4A6E] hover:underline">Lupa?</a>
                                @endif
                            </div>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </span>
                                <input id="password" :type="showPwd ? 'text' : 'password'" name="password" required autocomplete="current-password"
                                    class="input-base pr-10 @error('password') is-error @enderror"
                                    placeholder="Masukkan password">
                                <button type="button" @click="showPwd = !showPwd" tabindex="-1" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                    <svg x-show="!showPwd" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="showPwd" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#0C4A6E] focus:ring-[#0C4A6E]">
                            <label for="remember_me" class="ms-2 text-sm text-slate-600 cursor-pointer">Ingat saya</label>
                        </div>

                        <button type="submit" :disabled="loading" class="btn-primary">
                            <span x-show="!loading">Masuk</span>
                            <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                Memproses...
                            </span>
                        </button>
                    </form>

                    <p class="text-center text-sm text-slate-500 mt-6">
                        <a href="{{ route('home') }}" class="text-[#0C4A6E] font-semibold hover:underline">← Kembali ke Beranda</a>
                    </p>
                </div>
            </main>
        </div>
    </body>
</html>
