<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }} — GovSaúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='7' fill='%234f46e5'/><rect x='13' y='6' width='6' height='20' rx='2' fill='white'/><rect x='6' y='13' width='20' height='6' rx='2' fill='white'/></svg>">
    <style>
        *,*::before,*::after{box-sizing:border-box}
        body{margin:0;font-family:'Inter',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#eef2ff}
        .err-wrap{text-align:center;max-width:480px;padding:2rem}
        .err-code{font-size:7rem;font-weight:900;line-height:1;background:linear-gradient(135deg,#4f46e5,#7c3aed);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:.5rem}
        .err-icon{font-size:3rem;margin-bottom:1rem;opacity:.7}
        .err-title{font-size:1.4rem;font-weight:700;color:#0f172a;margin-bottom:.5rem}
        .err-msg{color:#64748b;font-size:.9rem;margin-bottom:2rem;line-height:1.6}
        .btn-home{background:linear-gradient(135deg,#4f46e5,#7c3aed);border:none;color:#fff;padding:.65rem 1.5rem;border-radius:10px;font-weight:600;font-size:.9rem;text-decoration:none;display:inline-flex;align-items:center;gap:.5rem;transition:opacity .2s}
        .btn-home:hover{opacity:.88;color:#fff}
        .brand{display:flex;align-items:center;gap:.6rem;justify-content:center;margin-bottom:2.5rem;text-decoration:none}
        .brand-icon{width:36px;height:36px;background:linear-gradient(135deg,#4f46e5,#7c3aed);border-radius:9px;display:flex;align-items:center;justify-content:center}
        .brand-icon i{color:#fff;font-size:1rem}
        .brand-name{font-weight:900;font-size:1rem;color:#0f172a;letter-spacing:-.02em}
        .brand-name span{color:#06b6d4}
    </style>
</head>
<body>
<div class="err-wrap">
    <a href="/" class="brand">
        <div class="brand-icon"><i class="bi bi-heart-pulse-fill"></i></div>
        <span class="brand-name">Gov<span>Saúde</span></span>
    </a>
    <div class="err-code">{{ $codigo }}</div>
    <div class="err-icon" style="color:{{ $cor }}"><i class="bi {{ $icone }}"></i></div>
    <h1 class="err-title">{{ $titulo }}</h1>
    <p class="err-msg">{{ $mensagem }}</p>
    @if(auth()->check())
    <a href="{{ route('dashboard') }}" class="btn-home"><i class="bi bi-house-fill"></i>Voltar ao início</a>
    @else
    <a href="{{ route('login') }}" class="btn-home"><i class="bi bi-box-arrow-in-right"></i>Fazer login</a>
    @endif
</div>
</body>
</html>
