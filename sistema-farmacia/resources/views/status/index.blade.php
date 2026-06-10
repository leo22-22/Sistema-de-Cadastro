<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status do Sistema — GovSaúde</title>
    <meta name="description" content="Status atual dos serviços do sistema GovSaúde.">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='7' fill='%234f46e5'/><rect x='13' y='6' width='6' height='20' rx='2' fill='white'/><rect x='6' y='13' width='20' height='6' rx='2' fill='white'/></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --indigo: #4f46e5;
            --violet: #7c3aed;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8faff;
            color: #1e293b;
            min-height: 100vh;
        }
        .top-bar {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            padding: .75rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .top-bar .brand {
            font-size: 1rem; font-weight: 800; color: #fff; text-decoration: none; letter-spacing: -.02em;
        }
        .top-bar .brand span { color: #67e8f9; }
        .top-bar .brand-icon {
            width: 32px; height: 32px; border-radius: 8px;
            background: rgba(255,255,255,.15);
            display: inline-flex; align-items: center; justify-content: center;
            margin-right: .5rem;
        }
        .page-wrap {
            max-width: 700px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }
        .status-header {
            border-radius: 14px;
            padding: 1.5rem 2rem;
            margin-bottom: 1.5rem;
            display: flex; align-items: center; gap: 1rem;
        }
        .status-header.ok     { background: #f0fdf4; border: 1px solid #bbf7d0; }
        .status-header.warn   { background: #fffbeb; border: 1px solid #fde68a; }
        .status-header.error  { background: #fff5f5; border: 1px solid #fecaca; }
        .status-dot {
            width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0;
            animation: pulse 2s ease-in-out infinite;
        }
        .status-dot.ok    { background: #10b981; box-shadow: 0 0 0 4px rgba(16,185,129,.2); }
        .status-dot.warn  { background: #f59e0b; box-shadow: 0 0 0 4px rgba(245,158,11,.2); }
        .status-dot.error { background: #ef4444; box-shadow: 0 0 0 4px rgba(239,68,68,.2); }
        @keyframes pulse {
            0%,100% { box-shadow: 0 0 0 4px rgba(16,185,129,.2); }
            50%      { box-shadow: 0 0 0 8px rgba(16,185,129,.05); }
        }
        .status-header h2 { font-size: 1.15rem; font-weight: 700; margin: 0; }
        .status-header.ok h2   { color: #065f46; }
        .status-header.warn h2 { color: #92400e; }
        .status-header.error h2 { color: #991b1b; }
        .status-header p { margin: 0; font-size: .83rem; }
        .status-header.ok p   { color: #047857; }
        .status-header.warn p { color: #b45309; }
        .status-header.error p { color: #b91c1c; }

        .check-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .check-icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .check-icon.ok    { background: #f0fdf4; }
        .check-icon.warn  { background: #fffbeb; }
        .check-icon.error { background: #fff5f5; }
        .check-icon.ok i    { color: #10b981; font-size: 1.1rem; }
        .check-icon.warn i  { color: #f59e0b; font-size: 1.1rem; }
        .check-icon.error i { color: #ef4444; font-size: 1.1rem; }
        .check-label { font-size: .88rem; font-weight: 600; color: #374151; margin-bottom: .15rem; }
        .check-value { font-size: .8rem; color: #64748b; }
        .check-badge {
            margin-left: auto; font-size: .72rem; font-weight: 600; padding: .22rem .65rem;
            border-radius: 20px; flex-shrink: 0;
        }
        .check-badge.ok    { background: #dcfce7; color: #166534; }
        .check-badge.warn  { background: #fef3c7; color: #92400e; }
        .check-badge.error { background: #fee2e2; color: #991b1b; }

        .disk-bar-wrap { flex: 1; }
        .disk-bar {
            height: 6px; border-radius: 3px;
            background: #e2e8f0; overflow: hidden; margin-top: .4rem;
        }
        .disk-bar-fill {
            height: 100%; border-radius: 3px;
            transition: width .5s ease;
        }
        .disk-bar-fill.ok   { background: #10b981; }
        .disk-bar-fill.warn { background: #f59e0b; }
        .disk-bar-fill.crit { background: #ef4444; }

        .section-label {
            font-size: .68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .1em; color: #94a3b8; margin: 1.5rem 0 .5rem;
        }
        .footer-links {
            text-align: center; font-size: .8rem; color: #94a3b8;
            margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;
        }
        .footer-links a { color: var(--indigo); text-decoration: none; }
        .footer-links a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="top-bar">
    <a href="{{ route('login') }}" class="brand">
        <span class="brand-icon"><i class="bi bi-hospital-fill" style="color:#fff;font-size:.85rem"></i></span>
        Gov<span>Saúde</span>
    </a>
    <span style="font-size:.8rem;color:rgba(255,255,255,.7)">Status do Sistema</span>
</div>

<div class="page-wrap">

    @php
        $allOk = $dbOk && $diskPct < 90;
        $anyError = !$dbOk || $diskPct >= 95;
        $headerClass = $anyError ? 'error' : ($allOk ? 'ok' : 'warn');
        $headerMsg = $anyError ? 'Sistema com falhas detectadas' : ($allOk ? 'Todos os sistemas operacionais' : 'Sistema com atenção necessária');
        $headerSub = $anyError
            ? 'Um ou mais serviços estão com problemas. Contate o suporte.'
            : ($allOk ? 'Todos os serviços estão funcionando normalmente.' : 'Verifique os itens marcados com aviso.');
    @endphp

    <div class="status-header {{ $headerClass }}">
        <div class="status-dot {{ $headerClass }}"></div>
        <div>
            <h2>{{ $headerMsg }}</h2>
            <p>{{ $headerSub }}</p>
        </div>
    </div>

    <div class="section-label">Serviços</div>

    {{-- Database --}}
    <div class="check-card">
        <div class="check-icon {{ $dbOk ? 'ok' : 'error' }}">
            <i class="bi {{ $dbOk ? 'bi-database-fill-check' : 'bi-database-fill-x' }}"></i>
        </div>
        <div>
            <div class="check-label">Banco de Dados</div>
            <div class="check-value">{{ $dbOk ? 'Conexão estabelecida com sucesso' : 'Falha na conexão com o banco' }}</div>
        </div>
        <span class="check-badge {{ $dbOk ? 'ok' : 'error' }}">
            {{ $dbOk ? 'Operacional' : 'Falha' }}
        </span>
    </div>

    {{-- Backup --}}
    @php
        $backupClass = $lastBackup ? ($lastBackup->diffInHours(now()) < 48 ? 'ok' : 'warn') : 'warn';
        $backupText = $lastBackup ? $lastBackup->format('d/m/Y \à\s H:i') . ' (' . $lastBackup->diffForHumans() . ')' : 'Nenhum backup realizado';
    @endphp
    <div class="check-card">
        <div class="check-icon {{ $backupClass }}">
            <i class="bi bi-cloud-check-fill"></i>
        </div>
        <div>
            <div class="check-label">Último Backup</div>
            <div class="check-value">{{ $backupText }}</div>
        </div>
        <span class="check-badge {{ $backupClass }}">
            {{ $lastBackup ? ($backupClass === 'ok' ? 'Recente' : 'Desatualizado') : 'Nunca' }}
        </span>
    </div>

    {{-- Disk space --}}
    @php
        $diskClass = $diskPct < 70 ? 'ok' : ($diskPct < 90 ? 'warn' : 'error');
        $diskBarClass = $diskPct < 70 ? 'ok' : ($diskPct < 90 ? 'warn' : 'crit');
        $freeGB = $diskFree ? round($diskFree / 1024 / 1024 / 1024, 1) : 0;
        $totalGB = $diskTotal ? round($diskTotal / 1024 / 1024 / 1024, 1) : 0;
    @endphp
    <div class="check-card">
        <div class="check-icon {{ $diskClass }}">
            <i class="bi {{ $diskClass === 'ok' ? 'bi-hdd-fill' : ($diskClass === 'warn' ? 'bi-exclamation-triangle-fill' : 'bi-x-circle-fill') }}"></i>
        </div>
        <div class="disk-bar-wrap">
            <div class="check-label">Espaço em Disco</div>
            <div class="check-value">{{ $freeGB }} GB livres de {{ $totalGB }} GB ({{ $diskPct }}% usado)</div>
            <div class="disk-bar">
                <div class="disk-bar-fill {{ $diskBarClass }}" style="width: {{ min($diskPct, 100) }}%"></div>
            </div>
        </div>
        <span class="check-badge {{ $diskClass }}">
            {{ $diskPct }}%
        </span>
    </div>

    <div class="section-label">Informações do Servidor</div>

    {{-- PHP Version --}}
    <div class="check-card">
        <div class="check-icon ok">
            <i class="bi bi-code-square"></i>
        </div>
        <div>
            <div class="check-label">PHP</div>
            <div class="check-value">Versão {{ PHP_VERSION }}</div>
        </div>
        <span class="check-badge ok">Operacional</span>
    </div>

    {{-- Laravel Version --}}
    <div class="check-card">
        <div class="check-icon ok">
            <i class="bi bi-layers-fill"></i>
        </div>
        <div>
            <div class="check-label">Laravel</div>
            <div class="check-value">Versão {{ app()->version() }}</div>
        </div>
        <span class="check-badge ok">Operacional</span>
    </div>

    {{-- Server Time --}}
    <div class="check-card">
        <div class="check-icon ok">
            <i class="bi bi-clock-fill"></i>
        </div>
        <div>
            <div class="check-label">Horário do Servidor</div>
            <div class="check-value">{{ now()->format('d/m/Y H:i:s') }} ({{ config('app.timezone', 'UTC') }})</div>
        </div>
        <span class="check-badge ok">Sincronizado</span>
    </div>

    <div class="footer-links">
        <p>&copy; {{ date('Y') }} GovSaúde &mdash; Todos os direitos reservados</p>
        <p style="margin-top:.4rem">
            <a href="{{ route('login') }}">Fazer login</a>
            &nbsp;&middot;&nbsp;
            <a href="{{ route('legal.termos') }}">Termos de Uso</a>
            &nbsp;&middot;&nbsp;
            <a href="{{ route('legal.privacidade') }}">Privacidade</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
