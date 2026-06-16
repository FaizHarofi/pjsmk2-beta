<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ (sekolah() && sekolah()->favicon) ? asset('uploads/' . sekolah()->favicon) : asset('assets/img/favicon.ico') }}">
        <title>Login — {{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">

        <style>
            [x-cloak]{display:none!important}
            body{font-family:'Plus Jakarta Sans',sans-serif;margin:0}
            .fd{font-family:'Space Grotesk',sans-serif}
            .bg-page{min-height:100vh;background:linear-gradient(135deg,#0C4A6E 0%,#075985 50%,#0e7490 100%);position:relative;overflow:hidden}
            .bg-page::before{content:"";position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,0.04) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.04) 1px,transparent 1px);background-size:40px 40px;pointer-events:none}
            .card-auth{background:#fff;border-radius:1rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.4);padding:2.5rem 2rem;max-width:420px;width:100%;position:relative;z-index:10}
            .input-group-auth{position:relative;display:flex;align-items:center;background:#f8fafc;border:1px solid #e2e8f0;border-radius:.5rem;transition:all .15s}
            .input-group-auth:focus-within{background:#fff;border-color:#0C4A6E;box-shadow:0 0 0 3px rgba(12,74,110,0.15)}
            .input-group-auth.is-error{background:#fef2f2;border-color:#f87171}
            .input-group-auth .icon{position:absolute;left:.85rem;color:#94a3b8;pointer-events:none;display:flex}
            .input-group-auth input{flex:1;border:none;background:transparent;padding:.625rem .75rem .625rem 2.5rem;font-size:.875rem;color:#0f172a;outline:none;width:100%}
            .input-group-auth input::placeholder{color:#94a3b8}
            .btn-primary{width:100%;background:#0C4A6E;color:#fff;font-weight:600;padding:.75rem 1rem;border-radius:.5rem;border:none;cursor:pointer;transition:all .15s;font-size:.875rem}
            .btn-primary:hover:not(:disabled){background:#075985;transform:translateY(-1px);box-shadow:0 10px 20px -5px rgba(12,74,110,0.4)}
            .btn-primary:disabled{opacity:.7;cursor:wait}
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">

        <div class="bg-page flex items-center justify-center p-4 min-h-screen">
            <div class="card-auth" x-data="{ loading: false, showPwd: false }" @submit="loading = true">
                <div class="text-center mb-5">
                    <div class="inline-flex w-20 h-20 bg-white rounded-2xl items-center justify-center mb-3 shadow-lg p-2">
                        <img src="{{ asset('assets/img/logo.png') }}" class="w-full h-full object-contain" alt="Logo SMKN 2 Pekanbaru">
                    </div>
                    <h1 class="fd text-xl font-bold text-slate-900 leading-tight">{{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}</h1>
                    <p class="text-sm text-slate-500 mt-1">Sign in to the Portal</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-3">
                    @csrf

                    <div>
                        <div class="input-group-auth @error('email') is-error @enderror">
                            <span class="icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Email">
                        </div>
                        @error('email') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="input-group-auth @error('password') is-error @enderror">
                            <span class="icon">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input :type="showPwd ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Password">
                            <button type="button" @click="showPwd = !showPwd" tabindex="-1" class="pr-3 text-slate-400 hover:text-slate-600">
                                <svg x-show="!showPwd" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg x-show="showPwd" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        @error('password') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center pt-1">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-[#0C4A6E] focus:ring-[#0C4A6E]">
                        <label for="remember_me" class="ms-2 text-sm text-slate-600 cursor-pointer">Remember me</label>
                    </div>

                    <button type="submit" :disabled="loading" class="btn-primary mt-4">
                        <span x-show="!loading">Sign in</span>
                        <span x-show="loading" x-cloak class="flex items-center justify-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Signing in...
                        </span>
                    </button>
                </form>

                <div class="flex items-center justify-between mt-5 text-sm">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-slate-500 hover:text-slate-700">Forgot password?</a>
                    @endif
                    <a href="{{ route('home') }}" class="text-slate-500 hover:text-slate-700">Return Home</a>
                </div>

                <p class="text-center text-xs text-slate-400 mt-5 pt-4 border-t border-slate-100">
                    &copy; {{ date('Y') }} {{ sekolah()->nama ?? 'SMKN 2 Pekanbaru' }}
                </p>
            </div>
        </div>
    </body>
</html>
