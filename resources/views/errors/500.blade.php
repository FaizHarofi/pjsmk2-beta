<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 — Server Error</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%); color: #fff; padding: 1.5rem; }
        .err-wrap { position: relative; z-index: 10; text-align: center; max-width: 480px; }
        .err-code { font-family: 'Space Grotesk', sans-serif; font-size: clamp(7rem, 20vw, 12rem); font-weight: 800; line-height: 1; background: linear-gradient(135deg, #fbbf24, #ef4444); -webkit-background-clip: text; background-clip: text; color: transparent; }
        .err-title { font-family: 'Space Grotesk', sans-serif; font-size: 1.75rem; font-weight: 700; margin: 1rem 0 .75rem; }
        .err-msg { color: #cbd5e1; font-size: .95rem; line-height: 1.6; margin-bottom: 2rem; }
        .err-actions a { display: inline-flex; padding: .75rem 1.25rem; background: #fbbf24; color: #1e293b; border-radius: .5rem; font-weight: 600; text-decoration: none; margin: 0 .25rem; }
    </style>
</head>
<body>
    <div class="err-wrap">
        <div class="err-code">500</div>
        <h1 class="err-title">Server Error</h1>
        <p class="err-msg">Terjadi kesalahan pada server. Silakan coba lagi nanti.</p>
        <div class="err-actions">
            <a href="{{ url('/') }}">Beranda</a>
        </div>
    </div>
</body>
</html>
