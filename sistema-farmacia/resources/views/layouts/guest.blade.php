<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GovSaúde — Gestão Farmacêutica Municipal</title>
    <meta name="description" content="GovSaúde: sistema completo de gestão farmacêutica municipal. Acesse para gerenciar processos APAC, dispensação e estoque.">
    <meta name="keywords" content="farmácia municipal, GovSaúde, gestão farmacêutica, CEAF, saúde pública">
    <meta name="author" content="GovSaúde">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#4f46e5">
    <meta property="og:type" content="website">
    <meta property="og:title" content="GovSaúde — Gestão Farmacêutica Municipal">
    <meta property="og:description" content="Sistema completo para gestão de farmácias municipais.">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='7' fill='%234f46e5'/><rect x='13' y='6' width='6' height='20' rx='2' fill='white'/><rect x='6' y='13' width='20' height='6' rx='2' fill='white'/></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --indigo:  #4f46e5;
            --violet:  #7c3aed;
            --cyan:    #06b6d4;
            --emerald: #10b981;
            --dark:    #07071a;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        /* View Transitions */
        @view-transition { navigation: auto; }
        ::view-transition-old(root) { animation: 200ms ease out vtOut; }
        ::view-transition-new(root) { animation: 260ms ease in vtIn;  }
        @keyframes vtOut { to   { opacity:0; transform:translateY(-6px) scale(.99); } }
        @keyframes vtIn  { from { opacity:0; transform:translateY(8px)  scale(.99); } }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
            background: var(--dark);
        }

        /* ── LEFT AURORA PANEL ─────────────────── */
        .panel-left {
            width: 52%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3.5rem;
            overflow: hidden;
            background: var(--dark);
        }

        /* Noise grain texture */
        .panel-left::after {
            content: '';
            position: absolute; inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
            background-size: 180px;
            pointer-events: none; z-index: 1; opacity: .4;
        }

        /* Dot grid */
        .panel-left::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.05) 1px, transparent 1px);
            background-size: 26px 26px;
            z-index: 0;
        }

        /* Aurora orbs */
        .orb {
            position: absolute; border-radius: 50%;
            filter: blur(90px); z-index: 0;
        }
        .orb-1 {
            width: 480px; height: 480px; opacity: .5;
            background: radial-gradient(circle, var(--indigo), transparent 65%);
            top: -120px; left: -120px;
            animation: orb1 11s ease-in-out infinite alternate;
        }
        .orb-2 {
            width: 380px; height: 380px; opacity: .45;
            background: radial-gradient(circle, var(--violet), transparent 65%);
            bottom: -80px; right: -60px;
            animation: orb2 14s ease-in-out infinite alternate;
        }
        .orb-3 {
            width: 260px; height: 260px; opacity: .3;
            background: radial-gradient(circle, var(--cyan), transparent 65%);
            top: 50%; left: 58%;
            animation: orb3 8s ease-in-out infinite alternate;
        }
        @keyframes orb1 {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(70px,90px) scale(1.15); }
        }
        @keyframes orb2 {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(-55px,-65px) scale(1.1); }
        }
        @keyframes orb3 {
            from { transform: translate(0,0) scale(1); }
            to   { transform: translate(-40px,45px) scale(1.25); }
        }

        /* Left content */
        .left-content { position: relative; z-index: 2; width: 100%; max-width: 430px; }

        /* Brand */
        .brand-mark {
            display: inline-flex; align-items: center; gap: 1rem;
            margin-bottom: 2.5rem;
            animation: fadeUp .6s ease both;
        }
        .brand-icon-wrap {
            width: 66px; height: 66px; border-radius: 20px;
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 0 1px rgba(99,102,241,.3), 0 0 40px rgba(99,102,241,.5);
            animation: brandGlow 3s ease-in-out infinite;
        }
        .brand-icon-wrap i { font-size: 1.9rem; color: #fff; }
        @keyframes brandGlow {
            0%,100% { box-shadow: 0 0 0 1px rgba(99,102,241,.3), 0 0 40px rgba(99,102,241,.5); }
            50%      { box-shadow: 0 0 0 1px rgba(124,58,237,.4), 0 0 60px rgba(124,58,237,.6); }
        }
        .brand-text .name {
            font-size: 1.85rem; font-weight: 900; color: #fff;
            letter-spacing: -.04em; line-height: 1;
        }
        .brand-text .name span { color: #67e8f9; }
        .brand-text .tagline { font-size: .8rem; color: #344058; margin-top: .25rem; }

        /* Headline */
        .left-headline {
            font-size: 1.05rem; font-weight: 300; color: #5a6a8a;
            line-height: 1.7; margin-bottom: 2rem;
            animation: fadeUp .6s .1s ease both; opacity: 0;
        }
        .left-headline strong { color: #8ea8d8; font-weight: 600; }

        /* Feature items */
        .feat-list { display: flex; flex-direction: column; gap: .7rem; }
        .feat-item {
            display: flex; align-items: center; gap: .9rem;
            padding: .8rem 1.1rem;
            border-radius: 14px;
            background: rgba(255,255,255,.03);
            border: 1px solid rgba(255,255,255,.06);
            backdrop-filter: blur(8px);
            opacity: 0;
            animation: fadeUp .5s ease forwards;
            transition: background .2s, border-color .2s;
        }
        .feat-item:hover {
            background: rgba(99,102,241,.08);
            border-color: rgba(99,102,241,.2);
        }
        .feat-item:nth-child(1){ animation-delay:.2s; }
        .feat-item:nth-child(2){ animation-delay:.3s; }
        .feat-item:nth-child(3){ animation-delay:.4s; }
        .feat-item:nth-child(4){ animation-delay:.5s; }
        .feat-item:nth-child(5){ animation-delay:.6s; }

        .feat-icon {
            width: 40px; height: 40px; border-radius: 11px; flex-shrink: 0;
            background: linear-gradient(135deg, rgba(79,70,229,.3), rgba(124,58,237,.3));
            display: flex; align-items: center; justify-content: center;
        }
        .feat-icon i { color: #a5b4fc; font-size: 1.05rem; }
        .feat-text { font-size: .84rem; color: #8898b4; font-weight: 500; }

        .left-footer {
            position: relative; z-index: 2;
            margin-top: 2.5rem; font-size: .72rem; color: #1e2a3a;
            animation: fadeUp .5s .7s ease both; opacity: 0;
        }

        /* ── RIGHT PANEL ─────────────────────── */
        .panel-right {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 2.5rem 2rem;
            background: #f7f9ff;
            overflow-y: auto;
            position: relative;
        }

        /* Subtle background pattern */
        .panel-right::before {
            content: '';
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(79,70,229,.04) 1px, transparent 1px);
            background-size: 24px 24px;
            pointer-events: none;
        }

        .auth-card {
            width: 100%; max-width: 450px;
            position: relative; z-index: 1;
            animation: fadeUp .5s .05s ease both; opacity: 0;
        }

        /* Animated tab indicator */
        .auth-tabs {
            display: flex;
            position: relative;
            border-bottom: 2px solid #e4e8f4;
            margin-bottom: 2rem;
        }
        .auth-tab {
            flex: 1; padding: .72rem 0;
            text-align: center; font-size: .875rem; font-weight: 600;
            color: #94a3b8; cursor: pointer;
            border: none; background: none;
            border-bottom: 2.5px solid transparent;
            margin-bottom: -2px;
            transition: color .22s;
        }
        .auth-tab.active { color: var(--indigo); border-bottom-color: var(--indigo); }
        .auth-tab i { margin-right: .3rem; }

        /* Heading */
        .auth-heading { font-size: 1.6rem; font-weight: 800; color: #0f172a; letter-spacing: -.04em; }
        .auth-sub { font-size: .88rem; color: #64748b; margin-top: .2rem; margin-bottom: 1.8rem; }

        /* Form elements */
        .form-label { font-size: .8rem; font-weight: 700; color: #374151; margin-bottom: .4rem; letter-spacing: .01em; }

        .input-wrap { position: relative; }
        .input-wrap .input-icon {
            position: absolute; left: .95rem; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: .95rem; pointer-events: none;
            transition: color .2s;
        }
        .input-wrap:focus-within .input-icon { color: var(--indigo); }

        .input-wrap input,
        .input-wrap select,
        .input-wrap textarea {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: .72rem 1rem .72rem 2.5rem;
            font-size: .9rem; color: #1e293b;
            background: #fff; outline: none;
            font-family: 'Inter', sans-serif;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        .input-wrap textarea { padding-left: 1rem; resize: vertical; }
        .input-wrap input:focus,
        .input-wrap select:focus,
        .input-wrap textarea:focus {
            border-color: var(--indigo);
            box-shadow: 0 0 0 4px rgba(79,70,229,.1);
            background: #fafbff;
        }
        .input-wrap .eye-btn {
            position: absolute; right: .85rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #94a3b8; cursor: pointer;
            font-size: .95rem; padding: .2rem; transition: color .2s;
        }
        .input-wrap .eye-btn:hover { color: var(--indigo); }

        /* Spinner */
        .gs-spinner {
            display: inline-block;
            width: 14px; height: 14px;
            border: 2px solid rgba(255,255,255,.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .6s linear infinite;
            vertical-align: middle; margin-right: .3rem;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Buttons */
        .btn-primary-full {
            width: 100%; padding: .82rem;
            border: none; border-radius: 12px;
            font-size: .95rem; font-weight: 700; color: #fff;
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            box-shadow: 0 4px 20px rgba(79,70,229,.3);
            cursor: pointer; position: relative; overflow: hidden;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-primary-full::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.2) 50%, transparent 60%);
            transform: translateX(-100%); transition: transform .5s ease;
        }
        .btn-primary-full:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(79,70,229,.4); }
        .btn-primary-full:hover::after { transform: translateX(100%); }
        .btn-primary-full:active { transform: translateY(0); }
        .btn-primary-full:disabled { opacity: .75; transform: none; cursor: not-allowed; }

        .btn-green-full {
            width: 100%; padding: .82rem;
            border: none; border-radius: 12px;
            font-size: .95rem; font-weight: 700; color: #fff;
            background: linear-gradient(135deg, #059669, #10b981);
            box-shadow: 0 4px 20px rgba(16,185,129,.3);
            cursor: pointer; position: relative; overflow: hidden;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-green-full::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.2) 50%, transparent 60%);
            transform: translateX(-100%); transition: transform .5s ease;
        }
        .btn-green-full:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(16,185,129,.4); }
        .btn-green-full:hover::after { transform: translateX(100%); }
        .btn-green-full:disabled { opacity: .75; cursor: not-allowed; }

        /* Alerts GovSaude */
        .alert-gs {
            display: flex; align-items: flex-start; gap: .65rem;
            border-radius: 12px; padding: .75rem 1rem;
            font-size: .875rem; font-weight: 500; line-height: 1.45;
        }
        .alert-gs-err  { background: #fff5f5; border: 1px solid #fecaca; color: #b91c1c; }
        .alert-gs-info { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }
        .alert-gs-ok   { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }

        .form-check-input:checked { background-color: var(--indigo); border-color: var(--indigo); }
        .forgot-link { font-size: .82rem; color: #94a3b8; text-decoration: none; font-weight: 500; }
        .forgot-link:hover { color: var(--indigo); }

        /* Success state */
        .success-wrap { text-align: center; padding: 1.5rem 0; }
        .check-ring {
            width: 76px; height: 76px; border-radius: 50%;
            background: linear-gradient(135deg, #059669, #10b981);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 0 0 12px rgba(16,185,129,.1);
            animation: pop .45s cubic-bezier(.34,1.56,.64,1) both;
        }
        .check-ring i { color: #fff; font-size: 2.1rem; }
        @keyframes pop { from { transform:scale(0); opacity:0; } to { transform:scale(1); opacity:1; } }
        .success-wrap h4 { font-size: 1.35rem; font-weight: 800; color: #065f46; margin-bottom: .5rem; }
        .success-wrap p { font-size: .9rem; color: #047857; line-height: 1.65; }

        /* Animations */
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(16px); }
            to   { opacity:1; transform:translateY(0); }
        }
        @keyframes shakeErr {
            0%,100% { transform:translateX(0); }
            15%      { transform:translateX(-6px); }
            30%      { transform:translateX(6px); }
            45%      { transform:translateX(-4px); }
            60%      { transform:translateX(4px); }
            75%      { transform:translateX(-2px); }
        }
        @keyframes shakeIn {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* Mobile */
        @media (max-width: 860px) {
            body { flex-direction: column; overflow: auto; }
            .panel-left { width: 100%; padding: 2.5rem 1.5rem; }
            .feat-list, .left-footer { display: none; }
            .left-headline { display: none; }
            .panel-right { padding: 1.75rem 1.25rem; }
        }

        /* ══ SPLASH / PAGE LOADER ══════════════ */
        #gs-loader {
            position: fixed; inset: 0; z-index: 99999;
            background: #07071a; overflow: hidden;
            transition: opacity .35s ease;
        }
        #gs-loader.gs-out { opacity:0; pointer-events:none; }

        .gs-panel {
            position:absolute; top:0; bottom:0; width:50%;
            background:#07071a;
            display:flex; align-items:center;
            overflow:hidden; will-change:transform;
        }
        .gs-panel::before {
            content:''; position:absolute; inset:0;
            background-image:radial-gradient(rgba(255,255,255,.04) 1px,transparent 1px);
            background-size:24px 24px; pointer-events:none;
        }
        .gs-pl { left:0; justify-content:flex-end; padding-right:2.5rem; transform:translateX(-100%); }
        .gs-pr { right:0; justify-content:flex-start; padding-left:2.5rem; transform:translateX(100%); }

        .gs-porb {
            position:absolute; width:300px; height:300px;
            border-radius:50%; filter:blur(90px); opacity:.45;
            top:50%; transform:translateY(-50%); pointer-events:none;
        }
        .gs-porb-l { background:radial-gradient(#4f46e5,transparent 65%); left:-70px; }
        .gs-porb-r { background:radial-gradient(#06b6d4,transparent 65%); right:-70px; }

        .gs-word {
            font-family:'Inter',sans-serif;
            font-size:clamp(2.8rem,7vw,5.5rem);
            font-weight:900; letter-spacing:-.05em; line-height:1;
            position:relative; z-index:1; opacity:0;
        }
        .gs-gov  { color:#fff; }
        .gs-saud { color:#67e8f9; }

        .gs-cmk {
            position:absolute; left:50%; top:50%;
            transform:translate(-50%,-50%);
            display:flex; flex-direction:column; align-items:center; gap:.7rem;
            z-index:3; opacity:0; pointer-events:none;
        }
        .gs-cmk-icon {
            width:72px; height:72px; border-radius:20px;
            background:linear-gradient(135deg,#4f46e5,#7c3aed);
            display:flex; align-items:center; justify-content:center;
            box-shadow:0 0 0 2px rgba(99,102,241,.4),0 0 50px rgba(99,102,241,.7);
        }
        .gs-cmk-icon i { color:#fff; font-size:2.1rem; }
        .gs-cmk-name { font-family:'Inter',sans-serif; font-size:1.6rem; font-weight:900; color:#fff; letter-spacing:-.04em; }
        .gs-cmk-name span { color:#67e8f9; }

        .gs-seam {
            position:absolute; left:calc(50% - .5px); top:0; bottom:0; width:1px;
            background:linear-gradient(to bottom,transparent,rgba(99,102,241,.7) 35%,rgba(6,182,212,.7) 65%,transparent);
            z-index:2; opacity:0; pointer-events:none;
        }

        #gs-loader.gs-first .gs-pl   { animation:plFull  2.1s cubic-bezier(.4,0,.2,1) forwards; }
        #gs-loader.gs-first .gs-pr   { animation:prFull  2.1s cubic-bezier(.4,0,.2,1) forwards; }
        #gs-loader.gs-first .gs-gov  { animation:wordLeft  2.1s ease forwards; }
        #gs-loader.gs-first .gs-saud { animation:wordRight 2.1s ease forwards; }
        #gs-loader.gs-first .gs-cmk  { animation:cmkLife  2.1s ease forwards; }
        #gs-loader.gs-first .gs-seam { animation:seamLife 2.1s ease forwards; }

        @keyframes plFull {
            0%   { transform:translateX(-100%); animation-timing-function:cubic-bezier(0,0,.2,1); }
            28%  { transform:translateX(0);     animation-timing-function:linear; }
            68%  { transform:translateX(0);     animation-timing-function:cubic-bezier(.4,0,1,1); }
            100% { transform:translateX(-100%); }
        }
        @keyframes prFull {
            0%   { transform:translateX(100%);  animation-timing-function:cubic-bezier(0,0,.2,1); }
            28%  { transform:translateX(0);     animation-timing-function:linear; }
            68%  { transform:translateX(0);     animation-timing-function:cubic-bezier(.4,0,1,1); }
            100% { transform:translateX(100%);  }
        }
        @keyframes wordLeft {
            0%,22%   { opacity:0; transform:translateX(30px) scale(.85); }
            34%      { opacity:1; transform:translateX(0) scale(1); }
            64%      { opacity:1; transform:translateX(0) scale(1); }
            76%,100% { opacity:0; transform:translateX(-12px) scale(.92); }
        }
        @keyframes wordRight {
            0%,22%   { opacity:0; transform:translateX(-30px) scale(.85); }
            34%      { opacity:1; transform:translateX(0) scale(1); }
            64%      { opacity:1; transform:translateX(0) scale(1); }
            76%,100% { opacity:0; transform:translateX(12px) scale(.92); }
        }
        @keyframes cmkLife {
            0%,32%   { opacity:0; transform:translate(-50%,-50%) scale(.75); }
            44%      { opacity:1; transform:translate(-50%,-50%) scale(1); }
            60%      { opacity:1; transform:translate(-50%,-50%) scale(1); }
            72%,100% { opacity:0; transform:translate(-50%,-50%) scale(1.08); }
        }
        @keyframes seamLife {
            0%,25%   { opacity:0; }
            32%      { opacity:1; }
            66%      { opacity:1; }
            73%,100% { opacity:0; }
        }

        #gs-loader.gs-nav {
            background:rgba(7,7,26,.9); backdrop-filter:blur(8px);
            display:flex; align-items:center; justify-content:center;
            animation:navFade .65s ease forwards;
        }
        #gs-loader.gs-nav .gs-panel,
        #gs-loader.gs-nav .gs-seam  { display:none; }
        #gs-loader.gs-nav .gs-cmk   {
            position:static; transform:none;
            animation:navBrand .65s ease forwards;
        }
        @keyframes navFade {
            0%   { opacity:0; }
            18%  { opacity:1; }
            82%  { opacity:1; }
            100% { opacity:0; pointer-events:none; }
        }
        @keyframes navBrand {
            0%   { opacity:0; transform:scale(.88); }
            22%  { opacity:1; transform:scale(1); }
            78%  { opacity:1; transform:scale(1); }
            100% { opacity:0; transform:scale(1.05); }
        }
    </style>
</head>
<body>

<!-- Splash / Page Loader -->
<div id="gs-loader" aria-hidden="true">
    <div class="gs-panel gs-pl">
        <div class="gs-porb gs-porb-l"></div>
        <span class="gs-word gs-gov">GOV</span>
    </div>
    <div class="gs-panel gs-pr">
        <div class="gs-porb gs-porb-r"></div>
        <span class="gs-word gs-saud">SAÚDE</span>
    </div>
    <div class="gs-seam"></div>
    <div class="gs-cmk">
        <div class="gs-cmk-icon"><i class="bi bi-hospital-fill"></i></div>
        <div class="gs-cmk-name">Gov<span>Saúde</span></div>
    </div>
</div>

<!-- ─── LEFT ──────────────────────────────── -->
<div class="panel-left">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="left-content">
        <div class="brand-mark">
            <div class="brand-icon-wrap"><i class="bi bi-hospital-fill"></i></div>
            <div class="brand-text">
                <div class="name">Gov<span>Saúde</span></div>
                <div class="tagline">Gestão Farmacêutica Municipal</div>
            </div>
        </div>

        <p class="left-headline">
            Plataforma completa para <strong>farmácias municipais</strong>.<br>
            Do processo ao recibo, do estoque ao relatório.
        </p>

        <div class="feat-list">
            <div class="feat-item">
                <div class="feat-icon"><i class="bi bi-folder2-open"></i></div>
                <div class="feat-text">Gestão de processos APAC e receitas</div>
            </div>
            <div class="feat-item">
                <div class="feat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="feat-text">Cadastro de pacientes, representantes e médicos</div>
            </div>
            <div class="feat-item">
                <div class="feat-icon"><i class="bi bi-box-seam"></i></div>
                <div class="feat-text">Controle de estoque com alertas de vencimento</div>
            </div>
            <div class="feat-item">
                <div class="feat-icon"><i class="bi bi-bar-chart-line"></i></div>
                <div class="feat-text">Relatórios exportáveis em PDF e Excel</div>
            </div>
            <div class="feat-item">
                <div class="feat-icon"><i class="bi bi-shield-check"></i></div>
                <div class="feat-text">Log de auditoria de todas as ações</div>
            </div>
        </div>

        <div class="left-footer">&copy; {{ date('Y') }} GovSaúde &mdash; Todos os direitos reservados</div>
    </div>
</div>

<!-- ─── RIGHT ─────────────────────────────── -->
<div class="panel-right">
    <div class="auth-card">

        <!-- Tabs -->
        <div class="auth-tabs">
            <button class="auth-tab {{ session('contato_enviado') ? '' : 'active' }}"
                    id="tab-login" onclick="gsTab('login')">
                <i class="bi bi-box-arrow-in-right"></i>Entrar
            </button>
            <button class="auth-tab {{ session('contato_enviado') ? 'active' : '' }}"
                    id="tab-contato" onclick="gsTab('contato')">
                <i class="bi bi-stars"></i>Quero o GovSaúde
            </button>
        </div>

        <!-- LOGIN SLOT -->
        <div id="panel-login" {{ session('contato_enviado') ? 'style=display:none' : '' }}>
            {{ $slot }}
        </div>

        <!-- CONTATO -->
        <div id="panel-contato" {{ session('contato_enviado') ? '' : 'style=display:none' }}>

            @if(session('contato_enviado'))
            <div class="success-wrap">
                <div class="check-ring"><i class="bi bi-check-lg"></i></div>
                <h4>Solicitação recebida!</h4>
                <p>Entraremos em contato em <strong>menos de uma hora</strong>.<br>
                   Fique atento ao seu e-mail e WhatsApp.</p>
                <button class="btn-primary-full mt-4" onclick="gsTab('login')">
                    <i class="bi bi-arrow-left me-2"></i>Voltar ao login
                </button>
            </div>

            @else

            <div style="animation:fadeUp .4s ease both">
                <div class="auth-heading">Quero o GovSaúde</div>
                <div class="auth-sub">Preencha e entraremos em contato em menos de 1 hora</div>
            </div>

            @if($errors->any())
            <div class="alert-gs alert-gs-err mb-3" style="animation:shakeErr .45s ease both">
                <i class="bi bi-exclamation-triangle-fill"></i>{{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('contato.store') }}" novalidate id="contatoForm">
                @csrf

                <div class="mb-3" style="animation:fadeUp .45s .05s ease both;opacity:0">
                    <label class="form-label">Nome completo</label>
                    <div class="input-wrap">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="nome" placeholder="Seu nome completo" value="{{ old('nome') }}" required>
                    </div>
                </div>

                <div class="row g-2 mb-3" style="animation:fadeUp .45s .1s ease both;opacity:0">
                    <div class="col-7">
                        <label class="form-label">E-mail</label>
                        <div class="input-wrap">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email" placeholder="seu@email.com" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="col-5">
                        <label class="form-label">WhatsApp</label>
                        <div class="input-wrap">
                            <i class="bi bi-telephone input-icon"></i>
                            <input type="text" name="telefone" placeholder="(00) 00000-0000" value="{{ old('telefone') }}" id="tel-ct" required>
                        </div>
                    </div>
                </div>

                <div class="row g-2 mb-3" style="animation:fadeUp .45s .15s ease both;opacity:0">
                    <div class="col-8">
                        <label class="form-label">Município</label>
                        <div class="input-wrap">
                            <i class="bi bi-geo-alt input-icon"></i>
                            <input type="text" name="municipio" placeholder="Nome da cidade" value="{{ old('municipio') }}" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">UF</label>
                        <div class="input-wrap">
                            <i class="bi bi-map input-icon"></i>
                            <input type="text" name="estado" placeholder="SP" maxlength="2" value="{{ old('estado') }}" id="uf-ct" style="text-transform:uppercase" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4" style="animation:fadeUp .45s .2s ease both;opacity:0">
                    <label class="form-label">Mensagem <span style="color:#94a3b8;font-weight:400">(opcional)</span></label>
                    <div class="input-wrap">
                        <textarea name="mensagem" rows="3" placeholder="Conte sobre a necessidade do município...">{{ old('mensagem') }}</textarea>
                    </div>
                </div>

                <div style="animation:fadeUp .45s .25s ease both;opacity:0">
                    <button type="submit" class="btn-green-full" id="ctBtn">
                        <span id="ctBtnText"><i class="bi bi-send me-2"></i>Enviar solicitação</span>
                        <span id="ctSpinner" style="display:none">
                            <span class="gs-spinner"></span> Enviando...
                        </span>
                    </button>
                </div>
            </form>
            @endif

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* Splash loader */
(function () {
    var loader = document.getElementById('gs-loader');
    if (!loader) return;
    var KEY = 'gs_intro_v1';
    var isFirst = !sessionStorage.getItem(KEY);
    if (isFirst) {
        sessionStorage.setItem(KEY, '1');
        loader.classList.add('gs-first');
        document.documentElement.style.overflow = 'hidden';
        setTimeout(function () {
            loader.classList.add('gs-out');
            document.documentElement.style.overflow = '';
            setTimeout(function () { loader.remove(); }, 380);
        }, 2250);
    } else {
        loader.classList.add('gs-nav');
        setTimeout(function () {
            loader.classList.add('gs-out');
            setTimeout(function () { loader.remove(); }, 380);
        }, 650);
    }
})();

/* Tab switching */
function gsTab(tab) {
    var l = document.getElementById('panel-login');
    var c = document.getElementById('panel-contato');
    var tl = document.getElementById('tab-login');
    var tc = document.getElementById('tab-contato');
    if (tab === 'login') {
        l.style.display = ''; c.style.display = 'none';
        tl.classList.add('active'); tc.classList.remove('active');
    } else {
        l.style.display = 'none'; c.style.display = '';
        tc.classList.add('active'); tl.classList.remove('active');
    }
}

/* Phone mask */
(function () {
    var tel = document.getElementById('tel-ct');
    if (tel) {
        tel.addEventListener('input', function () {
            var d = tel.value.replace(/\D/g,'').slice(0,11);
            var p = d.length <= 10 ? '(00) 0000-0000' : '(00) 00000-0000';
            var r = '', di = 0;
            for (var i = 0; i < p.length && di < d.length; i++)
                r += p[i] === '0' ? d[di++] : p[i];
            tel.value = r;
        });
    }
    var uf = document.getElementById('uf-ct');
    if (uf) {
        uf.addEventListener('input', function () {
            uf.value = uf.value.toUpperCase().replace(/[^A-Z]/g,'').slice(0,2);
        });
    }
})();

/* Loading states */
(function () {
    var cf = document.getElementById('contatoForm');
    if (cf) {
        cf.addEventListener('submit', function () {
            document.getElementById('ctBtnText').style.display = 'none';
            document.getElementById('ctSpinner').style.display = '';
            document.getElementById('ctBtn').disabled = true;
        });
    }
})();

/* Ripple on buttons */
document.addEventListener('click', function (e) {
    var btn = e.target.closest('.btn-primary-full, .btn-green-full');
    if (!btn || btn.disabled) return;
    var r = document.createElement('span');
    var d = Math.max(btn.offsetWidth, btn.offsetHeight) * 2;
    var rect = btn.getBoundingClientRect();
    r.style.cssText = 'position:absolute;border-radius:50%;width:'+d+'px;height:'+d+'px;'
        +'left:'+(e.clientX-rect.left-d/2)+'px;top:'+(e.clientY-rect.top-d/2)+'px;'
        +'background:rgba(255,255,255,.25);transform:scale(0);animation:gsRipple .55s ease;pointer-events:none;';
    btn.appendChild(r);
    setTimeout(function(){ r.remove(); }, 600);
});
</script>
<style>
@keyframes gsRipple { to { transform:scale(1); opacity:0; } }
</style>
</body>
</html>
