<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Farmácia Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sb-w: 240px;
            --sb-bg: #161d2e;
            --sb-hover: rgba(255,255,255,.055);
            --sb-active-bg: rgba(59,130,246,.13);
            --sb-active-bar: #3b82f6;
            --sb-text: #8899b4;
            --sb-text-hi: #f0f4ff;
            --accent: #3b82f6;
            --accent-dark: #2563eb;
            --bg: #f1f5f9;
            --surface: #fff;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: .9rem;
        }

        /* ─── SIDEBAR ─── */
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

        /* Brand */
        .sb-brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: 1.1rem 1.1rem .9rem;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }
        .sb-brand-icon {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sb-brand-icon i { color: #fff; font-size: 1rem; }
        .sb-brand-name { font-size: .875rem; font-weight: 700; color: #fff; line-height: 1.15; }
        .sb-brand-sub  { font-size: .68rem; color: var(--sb-text); }

        /* Nav */
        .sb-nav { flex: 1; padding: .625rem 0; }

        .sb-section {
            font-size: .62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .09em;
            color: #3d4f6a;
            padding: .8rem 1.1rem .3rem;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .45rem 1.1rem;
            color: var(--sb-text);
            text-decoration: none;
            font-size: .835rem;
            font-weight: 500;
            border-left: 2.5px solid transparent;
            transition: background .1s, color .1s, border-color .1s;
            margin: 0 0 1px;
        }
        .sb-link i { font-size: .95rem; width: 1rem; text-align: center; flex-shrink: 0; }
        .sb-link:hover { background: var(--sb-hover); color: #c8d6f0; }
        .sb-link.active {
            background: var(--sb-active-bg);
            color: var(--sb-text-hi);
            border-left-color: var(--sb-active-bar);
            font-weight: 600;
        }

        /* User row */
        .sb-user {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .85rem 1.1rem;
            border-top: 1px solid rgba(255,255,255,.06);
            flex-shrink: 0;
        }
        .sb-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: rgba(59,130,246,.18);
            border: 1.5px solid rgba(59,130,246,.35);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sb-avatar i { color: var(--accent); font-size: .8rem; }
        .sb-user-info { flex: 1; min-width: 0; }
        .sb-user-name {
            font-size: .78rem; font-weight: 600; color: #d4dff5;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sb-user-role { font-size: .67rem; color: var(--sb-text); }
        .sb-user-actions { display: flex; gap: .15rem; }
        .sb-user-actions a,
        .sb-user-actions button {
            background: none; border: none; padding: .3rem;
            color: #3d4f6a; cursor: pointer;
            border-radius: 6px; font-size: .85rem; line-height: 1;
            transition: color .1s, background .1s;
            text-decoration: none;
        }
        .sb-user-actions a:hover,
        .sb-user-actions button:hover { color: #c8d6f0; background: rgba(255,255,255,.07); }

        /* ─── MAIN ─── */
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
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }
        .page-header h4 i { color: var(--accent); }
        .page-header small { color: var(--muted); font-size: .78rem; }

        /* Cards */
        .card {
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,.04);
            background: var(--surface);
        }
        .card-header {
            background: var(--surface) !important;
            border-bottom: 1px solid var(--border);
            border-radius: 10px 10px 0 0 !important;
            padding: .85rem 1.1rem;
        }
        .card-footer {
            background: var(--surface) !important;
            border-top: 1px solid var(--border);
            border-radius: 0 0 10px 10px !important;
        }

        /* Tables */
        .table { font-size: .855rem; }
        .table th {
            font-size: .69rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--muted);
            font-weight: 600;
            background: #f9fafb;
            border-bottom: 1px solid var(--border) !important;
        }
        .table td { vertical-align: middle; border-color: #f3f4f6; }
        .table-hover tbody tr:hover td { background: #f8fafc; }

        /* Buttons */
        .btn {
            font-size: .835rem; font-weight: 500;
            border-radius: 7px;
            padding: .42rem .9rem;
        }
        .btn-sm { font-size: .775rem; padding: .3rem .7rem; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: var(--accent-dark); border-color: var(--accent-dark); }
        .btn-outline-primary { color: var(--accent); border-color: var(--accent); }
        .btn-outline-primary:hover { background: var(--accent); border-color: var(--accent); }

        /* Forms */
        .form-control, .form-select {
            border: 1px solid var(--border);
            border-radius: 7px;
            font-size: .855rem;
            color: var(--text);
            transition: border-color .15s, box-shadow .15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,.11);
        }
        .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }
        .invalid-feedback { font-size: .78rem; }

        /* Badges */
        .badge { font-weight: 500; border-radius: 5px; }

        /* Alerts */
        .alert { border-radius: 8px; font-size: .855rem; }

        /* Pagination */
        .pagination { font-size: .835rem; }
        .page-link { border-radius: 6px !important; border-color: var(--border); color: var(--accent); }
        .page-item.active .page-link { background: var(--accent); border-color: var(--accent); }

        /* ─── TOASTS ─── */
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
            border-radius: 10px;
            padding: .8rem 1rem;
            box-shadow: 0 4px 20px rgba(0,0,0,.1);
            min-width: 280px; max-width: 360px;
            animation: toastIn .2s ease both;
            transition: opacity .3s;
        }
        .app-toast.toast-success { border-left: 3px solid #10b981; }
        .app-toast.toast-error   { border-left: 3px solid #ef4444; }
        .app-toast .t-icon { font-size: 1rem; flex-shrink: 0; padding-top: .05rem; }
        .app-toast.toast-success .t-icon { color: #10b981; }
        .app-toast.toast-error   .t-icon { color: #ef4444; }
        .app-toast .t-body { flex: 1; font-size: .845rem; color: var(--text); line-height: 1.4; }
        .app-toast .t-close {
            background: none; border: none; padding: 0;
            color: #9ca3af; cursor: pointer; font-size: 1rem; line-height: 1;
        }
        .app-toast .t-close:hover { color: var(--text); }
        @keyframes toastIn {
            from { opacity: 0; transform: translateX(10px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ─── MOBILE ─── */
        .topbar {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; height: 52px;
            background: var(--sb-bg);
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
            z-index: 1001;
        }
        .topbar-brand { font-size: .875rem; font-weight: 700; color: #fff; }
        .topbar-toggle { background: none; border: none; color: #fff; font-size: 1.25rem; cursor: pointer; padding: .25rem; line-height: 1; }
        .sb-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 999; }

        @media (max-width: 991px) {
            .topbar { display: flex; }
            body { padding-top: 52px; }
            .sidebar { transform: translateX(-100%); transition: transform .22s ease; }
            .sidebar.open { transform: translateX(0); }
            .sb-overlay.open { display: block; }
            .main { margin-left: 0; padding: 1.25rem 1rem 3rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- Mobile topbar --}}
<div class="topbar">
    <button class="topbar-toggle" onclick="sbToggle()"><i class="bi bi-list"></i></button>
    <span class="topbar-brand"><i class="bi bi-hospital-fill me-1"></i>FarmáciaMuni</span>
    <div style="width:28px"></div>
</div>

{{-- Overlay --}}
<div class="sb-overlay" id="sbOverlay" onclick="sbToggle()"></div>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
    <a href="{{ route('dashboard') }}" class="sb-brand">
        <div class="sb-brand-icon"><i class="bi bi-hospital-fill"></i></div>
        <div>
            <div class="sb-brand-name">FarmáciaMuni</div>
            <div class="sb-brand-sub">Gestão Municipal</div>
        </div>
    </a>

    <nav class="sb-nav">
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

        @if(auth()->user()->isSuperadmin())
        <div class="sb-section">Administração</div>
        <a href="{{ route('medicamentos.index') }}" class="sb-link {{ request()->routeIs('medicamentos.*') ? 'active' : '' }}">
            <i class="bi bi-capsule"></i>Medicamentos
        </a>
        <a href="{{ route('tipos-receita.index') }}" class="sb-link {{ request()->routeIs('tipos-receita.*') ? 'active' : '' }}">
            <i class="bi bi-file-medical"></i>Tipos de Receita
        </a>
        <a href="{{ route('tipos-relacao-remessa.index') }}" class="sb-link {{ request()->routeIs('tipos-relacao-remessa.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>Tipos de Remessa
        </a>
        <a href="{{ route('usuarios.index') }}" class="sb-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>Usuários
        </a>
        @endif
    </nav>

    <div class="sb-user">
        <div class="sb-avatar"><i class="bi bi-person-fill"></i></div>
        <div class="sb-user-info">
            <div class="sb-user-name">{{ auth()->user()->name }}</div>
            <div class="sb-user-role">{{ auth()->user()->isSuperadmin() ? 'Superadmin' : 'Funcionário' }}</div>
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

// Toasts
(function () {
    const msgs = [
        @if(session('success')) { type:'success', icon:'bi-check-circle-fill', text: @json(session('success')) }, @endif
        @if(session('error'))   { type:'error',   icon:'bi-exclamation-circle-fill', text: @json(session('error')) },   @endif
    ];
    msgs.forEach(function(m) {
        var el = document.createElement('div');
        el.className = 'app-toast toast-' + m.type;
        el.innerHTML = '<i class="bi ' + m.icon + ' t-icon"></i>'
            + '<div class="t-body">' + m.text + '</div>'
            + '<button class="t-close" onclick="this.closest(\'.app-toast\').remove()">&times;</button>';
        document.getElementById('toast-stack').appendChild(el);
        setTimeout(function() { el.style.opacity = '0'; }, 4500);
        setTimeout(function() { el.remove(); }, 4800);
    });
})();
</script>
@stack('scripts')
</body>
</html>
