<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Akses Ditolak</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #7c2d12 0%, #991b1b 50%, #b91c1c 100%); color: #fff; padding: 1.5rem; overflow: hidden; position: relative; }
        body::before { content: ""; position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 40px 40px; pointer-events: none; }
        .err-wrap { position: relative; z-index: 10; text-align: center; max-width: 480px; }
        .err-code { font-family: 'Space Grotesk', sans-serif; font-size: clamp(7rem, 20vw, 12rem); font-weight: 800; line-height: 1; background: linear-gradient(135deg, #fde68a, #f59e0b); -webkit-background-clip: text; background-clip: text; color: transparent; letter-spacing: -0.05em; }
        .err-icon { width: 80px; height: 80px; margin: 0 auto 1.5rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 9999px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); }
        .err-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.75rem; font-weight: 700; margin-bottom: .75rem; }
        .err-msg { color: #fecaca; font-size: .95rem; line-height: 1.6; margin-bottom: 2rem; }
        .err-actions { display: flex; gap: .75rem; justify-content: center; flex-wrap: wrap; }
        .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .75rem 1.25rem; border-radius: .5rem; font-weight: 600; font-size: .875rem; text-decoration: none; transition: all .15s; }
        .btn-primary { background: #fcd34d; color: #7c2d12; }
        .btn-primary:hover { background: #f59e0b; transform: translateY(-1px); }
    </style>
</head>
<body>
    <div class="err-wrap">
        <div class="err-icon">
            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
        </div>
        <div class="err-code">403</div>
        <h1 class="err-title">Akses Ditolak</h1>
        <p class="err-msg">Anda tidak memiliki izin untuk mengakses halaman ini. Silakan login dengan akun yang sesuai.</p>
        <div class="err-actions">
            <a href="{{ route('home') }}" class="btn btn-primary">Beranda</a>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    </div>
</body>
</html>
