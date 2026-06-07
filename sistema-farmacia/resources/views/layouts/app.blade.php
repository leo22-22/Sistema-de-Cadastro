<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GovSaúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --indigo:       #4f46e5;
            --indigo-light: #6366f1;
            --indigo-glow:  rgba(99,102,241,.15);
            --violet:       #7c3aed;
            --cyan:         #06b6d4;
            --sb-bg:        #0d0d1f;
            --sb-w:         248px;
            --sb-text:      #5a6a8a;
            --sb-text-hi:   #e8eeff;
            --bg:           #eef2ff;
            --surface:      #fff;
            --text:         #0f172a;
            --muted:        #64748b;
            --border:       #e2e8f0;
            --accent:       var(--indigo);
            --accent-dark:  #4338ca;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: .9rem;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sb-w);
            background: var(--sb-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            overflow-y: auto;
            scrollbar-width: none;
        }
        .sidebar::-webkit-scrollbar { display: none; }

        /* Subtle dot grid overlay */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.035) 1px, transparent 1px);
            background-size: 22px 22px;
            pointer-events: none;
            z-index: 0;
        }

        /* Brand */
        .sb-brand {
            position: relative; z-index: 1;
            display: flex;
            align-items: center;
            gap: .8rem;
            padding: 1.2rem 1.1rem 1rem;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.05);
            flex-shrink: 0;
        }
        .sb-brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 0 18px rgba(99,102,241,.5);
        }
        .sb-brand-icon i { color: #fff; font-size: 1.05rem; }
        .sb-brand-name {
            font-size: .9rem; font-weight: 800;
            color: #fff; line-height: 1.15;
            letter-spacing: -.02em;
        }
        .sb-brand-name span { color: #67e8f9; }
        .sb-brand-sub { font-size: .67rem; color: var(--sb-text); }

        /* Section labels */
        .sb-nav { flex: 1; padding: .5rem 0; position: relative; z-index: 1; }

        .sb-section {
            font-size: .6rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #252d40;
            padding: .9rem 1.1rem .25rem;
        }

        /* Nav links */
        .sb-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .48rem 1.1rem;
            color: var(--sb-text);
            text-decoration: none;
            font-size: .835rem;
            font-weight: 500;
            border-left: 2.5px solid transparent;
            border-radius: 0 8px 8px 0;
            margin: 1px .5rem 1px 0;
            transition: background .15s, color .15s, border-color .15s, box-shadow .15s;
        }
        .sb-link i {
            font-size: .95rem; width: 1rem;
            text-align: center; flex-shrink: 0;
            transition: color .15s;
        }
        .sb-link:hover {
            background: rgba(255,255,255,.05);
            color: #c8d6f0;
        }
        .sb-link.active {
            background: var(--indigo-glow);
            color: var(--sb-text-hi);
            border-left-color: var(--indigo-light);
            font-weight: 600;
            box-shadow: inset 0 0 20px rgba(99,102,241,.08),
                        0 0 12px rgba(99,102,241,.12);
        }
        .sb-link.active i { color: #a5b4fc; }

        /* User row */
        .sb-user {
            position: relative; z-index: 1;
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .9rem 1.1rem;
            border-top: 1px solid rgba(255,255,255,.05);
            flex-shrink: 0;
        }
        .sb-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(79,70,229,.3), rgba(124,58,237,.3));
            border: 1.5px solid rgba(99,102,241,.4);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sb-avatar i { color: #a5b4fc; font-size: .85rem; }
        .sb-user-info { flex: 1; min-width: 0; }
        .sb-user-name {
            font-size: .78rem; font-weight: 600; color: #d0dbf5;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sb-user-role { font-size: .66rem; color: var(--sb-text); }
        .sb-user-actions { display: flex; gap: .1rem; }
        .sb-user-actions a,
        .sb-user-actions button {
            background: none; border: none; padding: .3rem;
            color: #2d3a52; cursor: pointer;
            border-radius: 6px; font-size: .85rem; line-height: 1;
            transition: color .15s, background .15s;
            text-decoration: none;
        }
        .sb-user-actions a:hover,
        .sb-user-actions button:hover {
            color: #c8d6f0;
            background: rgba(255,255,255,.07);
        }

        /* ══════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════ */
        .main {
            margin-left: var(--sb-w);
            min-height: 100vh;
            padding: 1.75rem 2rem 3rem;
        }

        /* Page header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }
        .page-header h4 {
            font-size: 1.08rem; font-weight: 700;
            color: var(--text); margin: 0;
        }
        .page-header h4 i { color: var(--indigo); }
        .page-header small { color: var(--muted); font-size: .78rem; }

        /* Cards */
        .card {
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,.04);
            background: var(--surface);
            transition: box-shadow .2s, transform .2s;
        }
        .card:hover { box-shadow: 0 6px 20px rgba(79,70,229,.08); }
        .card-header {
            background: var(--surface) !important;
            border-bottom: 1px solid var(--border);
            border-radius: 12px 12px 0 0 !important;
            padding: .9rem 1.1rem;
        }
        .card-footer {
            background: var(--surface) !important;
            border-top: 1px solid var(--border);
            border-radius: 0 0 12px 12px !important;
        }

        /* Stat cards */
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem 1.4rem;
            display: flex; align-items: center; gap: 1rem;
            transition: box-shadow .2s, transform .2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(79,70,229,.1);
        }
        .stat-icon-wrap {
            width: 50px; height: 50px;
            border-radius: 13px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .stat-icon-wrap i { font-size: 1.35rem; }
        .stat-value {
            font-size: 1.6rem; font-weight: 800;
            color: var(--text); line-height: 1; letter-spacing: -.03em;
        }
        .stat-label { font-size: .8rem; color: var(--muted); margin-top: .15rem; }

        /* Tables */
        .table { font-size: .855rem; }
        .table th {
            font-size: .67rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--muted);
            font-weight: 700;
            background: #f8faff;
            border-bottom: 1px solid var(--border) !important;
        }
        .table td { vertical-align: middle; border-color: #f1f5f9; }
        .table-hover tbody tr:hover td { background: #f5f7ff; }

        /* Buttons */
        .btn {
            font-size: .835rem; font-weight: 500;
            border-radius: 8px;
            padding: .42rem .9rem;
            transition: transform .12s, box-shadow .12s;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }
        .btn-sm { font-size: .775rem; padding: .3rem .7rem; }
        .btn-primary {
            background: linear-gradient(135deg, var(--indigo), var(--violet));
            border: none;
            box-shadow: 0 2px 10px rgba(79,70,229,.28);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #4338ca, #6d28d9);
            box-shadow: 0 4px 16px rgba(79,70,229,.38);
        }
        .btn-outline-primary { color: var(--indigo); border-color: var(--indigo); }
        .btn-outline-primary:hover {
            background: var(--indigo); border-color: var(--indigo);
            box-shadow: 0 3px 12px rgba(79,70,229,.3);
        }

        /* Forms */
        .form-control, .form-select {
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: .855rem;
            color: var(--text);
            transition: border-color .15s, box-shadow .15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--indigo);
            box-shadow: 0 0 0 3.5px rgba(79,70,229,.12);
        }
        .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }
        .invalid-feedback { font-size: .78rem; }

        /* Badges */
        .badge { font-weight: 500; border-radius: 6px; }

        /* Alerts */
        .alert { border-radius: 10px; font-size: .855rem; }

        /* Pagination */
        .pagination { font-size: .835rem; }
        .page-link { border-radius: 7px !important; border-color: var(--border); color: var(--indigo); }
        .page-item.active .page-link {
            background: var(--indigo); border-color: var(--indigo);
        }

        /* ══════════════════════════════════════
           TOASTS
        ══════════════════════════════════════ */
        #toast-stack {
            position: fixed;
            top: 1.25rem; right: 1.25rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: .5rem;
            pointer-events: none;
        }
        .app-toast {
            pointer-events: all;
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .85rem 1rem;
            box-shadow: 0 8px 30px rgba(0,0,0,.12);
            min-width: 290px; max-width: 370px;
            animation: toastIn .25s cubic-bezier(.34,1.56,.64,1) both;
            transition: opacity .3s, transform .3s;
        }
        .app-toast.toast-success { border-left: 3.5px solid #10b981; }
        .app-toast.toast-error   { border-left: 3.5px solid #ef4444; }
        .app-toast .t-icon { font-size: 1.05rem; flex-shrink: 0; padding-top: .05rem; }
        .app-toast.toast-success .t-icon { color: #10b981; }
        .app-toast.toast-error   .t-icon { color: #ef4444; }
        .app-toast .t-body { flex: 1; font-size: .845rem; color: var(--text); line-height: 1.4; font-weight: 500; }
        .app-toast .t-close {
            background: none; border: none; padding: 0;
            color: #9ca3af; cursor: pointer; font-size: 1rem; line-height: 1;
            transition: color .15s;
        }
        .app-toast .t-close:hover { color: var(--text); }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(14px) scale(.97); }
            to   { opacity: 1; transform: translateX(0) scale(1); }
        }

        /* ══════════════════════════════════════
           MOBILE
        ══════════════════════════════════════ */
        .topbar {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; height: 52px;
            background: var(--sb-bg);
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            z-index: 1001;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .topbar-brand {
            font-size: .88rem; font-weight: 800; color: #fff; letter-spacing: -.02em;
        }
        .topbar-brand span { color: #67e8f9; }
        .topbar-toggle {
            background: none; border: none; color: #fff;
            font-size: 1.25rem; cursor: pointer; padding: .25rem; line-height: 1;
        }
        .sb-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.5); z-index: 999;
        }

        @media (max-width: 991px) {
            .topbar { display: flex; }
            body { padding-top: 52px; }
            .sidebar { transform: translateX(-100%); transition: transform .22s ease; }
            .sidebar.open { transform: translateX(0); }
            .sb-overlay.open { display: block; }
            .main { margin-left: 0; padding: 1.25rem 1rem 3rem; }
        }

        /* ══════════════════════════════════════
           VIEW TRANSITIONS — cross-page animations
        ══════════════════════════════════════ */
        @view-transition { navigation: auto; }

        ::view-transition-old(root) {
            animation: 180ms cubic-bezier(.4,0,1,1) both vtOut;
        }
        ::view-transition-new(root) {
            animation: 260ms cubic-bezier(0,0,.2,1) both vtIn;
        }
        @keyframes vtOut {
            to { opacity:0; transform:translateY(-5px) scale(.99); }
        }
        @keyframes vtIn {
            from { opacity:0; transform:translateY(8px) scale(.99); }
        }

        /* ══════════════════════════════════════
           TOP PROGRESS BAR
        ══════════════════════════════════════ */
        #gs-nprogress {
            position: fixed; top: 0; left: 0; right: 0; height: 2.5px;
            z-index: 9998; pointer-events: none;
            background: linear-gradient(90deg, var(--indigo), var(--cyan), var(--violet));
            transform: scaleX(0); transform-origin: left;
            transition: transform .25s ease, opacity .3s;
            opacity: 0;
        }
        #gs-nprogress.active { opacity: 1; }

        /* ══════════════════════════════════════
           RIPPLE
        ══════════════════════════════════════ */
        @keyframes gsRipple {
            to { transform: scale(2.8); opacity: 0; }
        }

        /* ══════════════════════════════════════
           SCROLL-DRIVEN ENTRY (cards, rows)
        ══════════════════════════════════════ */
        @supports (animation-timeline: scroll()) {
            .card, .stat-card {
                animation: none; /* handled by JS class below */
            }
        }
        .gs-reveal {
            opacity: 0; transform: translateY(14px);
            transition: opacity .4s ease, transform .4s ease;
        }
        .gs-reveal.visible {
            opacity: 1; transform: translateY(0);
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Top progress bar --}}
<div id="gs-nprogress"></div>

{{-- Mobile topbar --}}
<div class="topbar">
    <button class="topbar-toggle" onclick="sbToggle()"><i class="bi bi-list"></i></button>
    <span class="topbar-brand">Gov<span>Saúde</span></span>
    <div style="width:28px"></div>
</div>

{{-- Overlay --}}
<div class="sb-overlay" id="sbOverlay" onclick="sbToggle()"></div>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <a href="{{ route('dashboard') }}" class="sb-brand">
        <div class="sb-brand-icon"><i class="bi bi-hospital-fill"></i></div>
        <div>
            <div class="sb-brand-name">Gov<span>Saúde</span></div>
            <div class="sb-brand-sub">Gestão Municipal</div>
        </div>
    </a>

    <nav class="sb-nav">
        @if(auth()->user()->isSuperadmin())
        {{-- ── MENU SUPERADMIN ── --}}
        <div class="sb-section">Visão Geral</div>
        <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>Dashboard
        </a>

        <div class="sb-section">Gestão</div>
        <a href="{{ route('farmacias.index') }}" class="sb-link {{ request()->routeIs('farmacias.*') ? 'active' : '' }}">
            <i class="bi bi-hospital"></i>Farmácias
        </a>
        <a href="{{ route('usuarios.index') }}" class="sb-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>Usuários
        </a>

        <div class="sb-section">Catálogo</div>
        <a href="{{ route('medicamentos.index') }}" class="sb-link {{ request()->routeIs('medicamentos.*') ? 'active' : '' }}">
            <i class="bi bi-capsule"></i>Medicamentos
        </a>
        <a href="{{ route('tipos-receita.index') }}" class="sb-link {{ request()->routeIs('tipos-receita.*') ? 'active' : '' }}">
            <i class="bi bi-file-medical"></i>Tipos de Receita
        </a>
        <a href="{{ route('tipos-relacao-remessa.index') }}" class="sb-link {{ request()->routeIs('tipos-relacao-remessa.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>Tipos de Remessa
        </a>

        <div class="sb-section">Relatórios</div>
        <a href="{{ route('relatorios.index') }}" class="sb-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i>Relatórios
        </a>
        <a href="{{ route('auditoria.index') }}" class="sb-link {{ request()->routeIs('auditoria.*') ? 'active' : '' }}">
            <i class="bi bi-shield-check"></i>Auditoria
        </a>
        @php $naoLidas = \App\Models\ContactRequest::where('lido', false)->count(); @endphp
        <a href="{{ route('contato.index') }}" class="sb-link {{ request()->routeIs('contato.*') ? 'active' : '' }}">
            <i class="bi bi-envelope-open"></i>Solicitações
            @if($naoLidas)<span class="badge bg-danger ms-auto" style="font-size:.58rem">{{ $naoLidas }}</span>@endif
        </a>

        @else
        {{-- ── MENU FARMÁCIA (admin + funcionário) ── --}}
        <div class="sb-section">Principal</div>
        <a href="{{ route('dashboard') }}" class="sb-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>Dashboard
        </a>
        <a href="{{ route('processos.index') }}" class="sb-link {{ request()->routeIs('processos.*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open"></i>Processos
        </a>
        <a href="{{ route('recibos.index') }}" class="sb-link {{ request()->routeIs('recibos.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i>Dispensações
        </a>

        <div class="sb-section">Cadastros</div>
        <a href="{{ route('pacientes.index') }}" class="sb-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i>Pacientes
        </a>
        <a href="{{ route('representantes.index') }}" class="sb-link {{ request()->routeIs('representantes.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i>Representantes
        </a>
        <a href="{{ route('medicos-prescritores.index') }}" class="sb-link {{ request()->routeIs('medicos-prescritores.*') ? 'active' : '' }}">
            <i class="bi bi-heart-pulse"></i>Médicos
        </a>

        <div class="sb-section">Estoque</div>
        <a href="{{ route('lotes.index') }}" class="sb-link {{ request()->routeIs('lotes.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>Lotes
        </a>

        <div class="sb-section">Relatórios</div>
        <a href="{{ route('relatorios.index') }}" class="sb-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i>Relatórios
        </a>
        <a href="{{ route('auditoria.index') }}" class="sb-link {{ request()->routeIs('auditoria.*') ? 'active' : '' }}">
            <i class="bi bi-shield-check"></i>Auditoria
        </a>

        @if(auth()->user()->isAdminFarmacia())
        <div class="sb-section">Administração</div>
        <a href="{{ route('usuarios.index') }}" class="sb-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>Usuários
        </a>
        @endif
        @endif
    </nav>

    <div class="sb-user">
        <div class="sb-avatar"><i class="bi bi-person-fill"></i></div>
        <div class="sb-user-info">
            <div class="sb-user-name">{{ auth()->user()->name }}</div>
            <div class="sb-user-role">
                {{ match(auth()->user()->role) {
                    'superadmin'     => 'Superadmin',
                    'admin_farmacia' => 'Admin Farmácia',
                    default          => 'Funcionário',
                } }}
            </div>
        </div>
        <div class="sb-user-actions">
            <a href="{{ route('profile.edit') }}" title="Perfil"><i class="bi bi-gear"></i></a>
            <form method="POST" action="{{ route('logout') }}" style="display:contents">
                @csrf
                <button type="submit" title="Sair"><i class="bi bi-box-arrow-right"></i></button>
            </form>
        </div>
    </div>
</aside>

{{-- Main content --}}
<main class="main">
    <div id="toast-stack"></div>
    {{ $slot }}
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function sbToggle() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sbOverlay').classList.toggle('open');
}

/* ── Toasts ── */
(function () {
    var msgs = [
        @if(session('success')) { type:'success', icon:'bi-check-circle-fill', text: @json(session('success')) }, @endif
        @if(session('error'))   { type:'error',   icon:'bi-exclamation-circle-fill', text: @json(session('error')) }, @endif
    ];
    msgs.forEach(function(m) {
        var el = document.createElement('div');
        el.className = 'app-toast toast-' + m.type;
        el.innerHTML = '<i class="bi ' + m.icon + ' t-icon"></i>'
            + '<div class="t-body">' + m.text + '</div>'
            + '<button class="t-close" onclick="this.closest(\'.app-toast\').remove()">&times;</button>';
        document.getElementById('toast-stack').appendChild(el);
        setTimeout(function() { el.style.opacity='0'; el.style.transform='translateX(12px)'; }, 4500);
        setTimeout(function() { el.remove(); }, 4850);
    });
})();

/* ── Progress bar (NProgress-style) ── */
(function () {
    var bar = document.getElementById('gs-nprogress');
    var timer;
    function start() {
        clearTimeout(timer);
        bar.classList.add('active');
        bar.style.transform = 'scaleX(.7)';
        bar.style.transition = 'transform .25s ease';
    }
    function done() {
        bar.style.transform = 'scaleX(1)';
        timer = setTimeout(function () {
            bar.style.transition = 'opacity .3s';
            bar.classList.remove('active');
            bar.style.transform = 'scaleX(0)';
            setTimeout(function () { bar.style.transition = ''; }, 350);
        }, 200);
    }
    document.addEventListener('click', function (e) {
        var a = e.target.closest('a[href]');
        if (!a) return;
        var href = a.getAttribute('href');
        if (!href || href.startsWith('#') || href.startsWith('javascript') || a.target) return;
        start();
    });
    document.addEventListener('submit', function () { start(); });
    window.addEventListener('pageshow', function () { done(); });
    window.addEventListener('load', function () { done(); });
})();

/* ── Animated counters (data-count="N") ── */
(function () {
    function animateCounter(el) {
        var target = parseInt(el.dataset.count, 10);
        if (isNaN(target)) return;
        var duration = 750, start = null;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / duration, 1);
            var ease = 1 - Math.pow(1 - p, 3);
            el.textContent = Math.floor(ease * target);
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target;
        }
        requestAnimationFrame(step);
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-count]').forEach(animateCounter);
    });
})();

/* ── Ripple on .btn ── */
(function () {
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn');
        if (!btn) return;
        var r = document.createElement('span');
        var d = Math.max(btn.offsetWidth, btn.offsetHeight) * 2;
        var rect = btn.getBoundingClientRect();
        r.style.cssText = 'position:absolute;border-radius:50%;pointer-events:none;'
            + 'width:' + d + 'px;height:' + d + 'px;'
            + 'left:' + (e.clientX - rect.left - d / 2) + 'px;'
            + 'top:'  + (e.clientY - rect.top  - d / 2) + 'px;'
            + 'background:rgba(255,255,255,.2);transform:scale(0);animation:gsRipple .55s ease;';
        var prev = btn.style.position;
        btn.style.position = 'relative';
        btn.style.overflow = 'hidden';
        btn.appendChild(r);
        setTimeout(function () { r.remove(); if (!prev) btn.style.position = ''; }, 600);
    });
})();

/* ── Card spotlight (mouse-follow glow) ── */
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.stat-card').forEach(function (card) {
            card.addEventListener('mousemove', function (e) {
                var rect = card.getBoundingClientRect();
                var x = e.clientX - rect.left;
                var y = e.clientY - rect.top;
                card.style.background = 'radial-gradient(circle at ' + x + 'px ' + y + 'px, rgba(99,102,241,.06) 0%, #fff 65%)';
            });
            card.addEventListener('mouseleave', function () {
                card.style.background = '';
            });
        });
    });
})();

/* ── Scroll-driven reveal ── */
(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var els = document.querySelectorAll('.card, .stat-card, .alert');
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    en.target.classList.add('visible');
                    obs.unobserve(en.target);
                }
            });
        }, { threshold: 0.08 });
        els.forEach(function (el) {
            el.classList.add('gs-reveal');
            obs.observe(el);
        });
    });
})();
</script>
@stack('scripts')
<script>
/* Input masks */
(function () {
    function fmt(v, pattern) {
        var d = v.replace(/\D/g, ''), r = '', di = 0;
        for (var i = 0; i < pattern.length && di < d.length; i++) {
            r += pattern[i] === '0' ? d[di++] : pattern[i];
        }
        return r;
    }
    function fmtTelefone(v) {
        var d = v.replace(/\D/g, '').slice(0, 11);
        return d.length <= 10 ? fmt(d, '(00) 0000-0000') : fmt(d, '(00) 00000-0000');
    }
    var patterns = {
        cpf:      function(v){ return fmt(v, '000.000.000-00'); },
        cnpj:     function(v){ return fmt(v, '00.000.000/0000-00'); },
        cns:      function(v){ return fmt(v, '000 0000 0000 0000'); },
        cnes:     function(v){ return v.replace(/\D/g,'').slice(0,7); },
        cep:      function(v){ return fmt(v, '00000-000'); },
        telefone: fmtTelefone,
    };
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-mask]').forEach(function (el) {
            var fn = patterns[el.dataset.mask];
            if (!fn) return;
            if (el.value) el.value = fn(el.value);
            el.addEventListener('input', function () { el.value = fn(el.value); });
        });
    });
})();
</script>
</body>
</html>
