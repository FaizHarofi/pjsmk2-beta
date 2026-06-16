<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0C4A6E 0%, #075985 50%, #0e7490 100%); color: #fff; padding: 1.5rem; overflow: hidden; position: relative; }
        body::before { content: ""; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 40px 40px; pointer-events: none; }
        .err-wrap { position: relative; z-index: 10; text-align: center; max-width: 480px; }
        .err-code { font-family: 'Space Grotesk', sans-serif; font-size: clamp(7rem, 20vw, 12rem); font-weight: 800; line-height: 1; background: linear-gradient(135deg, #fcd34d, #f59e0b); -webkit-background-clip: text; background-clip: text; color: transparent; letter-spacing: -0.05em; }
        .err-icon { width: 80px; height: 80px; margin: 0 auto 1.5rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 9999px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); }
        .err-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.75rem; font-weight: 700; margin-bottom: .75rem; }
        .err-msg { color: #bae6fd; font-size: .95rem; line-height: 1.6; margin-bottom: 2rem; }
        .err-actions { display: flex; gap: .75rem; justify-content: center; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .75rem 1.25rem; border-radius: .5rem; font-weight: 600; font-size: .875rem; text-decoration: none; transition: all .15s; }
        .btn-primary { background: #fcd34d; color: #0C4A6E; }
        .btn-primary:hover { background: #f59e0b; transform: translateY(-1px); }
        .btn-ghost { background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.2); }
        .btn-ghost:hover { background: rgba(255,255,255,0.2); }
        .err-detail { margin-top: 1.5rem; font-size: .75rem; color: rgba(255,255,255,0.5); font-family: monospace; }
    </style>
</head>
<body>
    <div class="err-wrap">
        <div class="err-icon">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5"/>
            </svg>
        </div>
        <div class="err-code">404</div>
        <h1 class="err-title">Halaman Tidak Ditemukan</h1>
        <p class="err-msg">Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan. Periksa kembali URL Anda atau kembali ke beranda.</p>
        <div class="err-actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="javascript:history.back()" class="btn btn-ghost">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
        @if(isset($exception) && config('app.debug'))
        <div class="err-detail">{{ $exception->getMessage() }}</div>
        @endif
    </div>
</body>
</html>
