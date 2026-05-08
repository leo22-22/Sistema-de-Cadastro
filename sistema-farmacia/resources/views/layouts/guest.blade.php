<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Farmácia Municipal — Acesso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-primary: #0061ff;
            --brand-dark: #0f172a;
            --brand-blue-mid: #1e40af;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
        }

        /* ── LEFT PANEL ── */
        .panel-left {
            width: 45%;
            background: var(--brand-dark);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 3.5rem;
            position: relative;
            overflow: hidden;
        }

        .panel-left::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0,97,255,.35) 0%, transparent 70%);
            border-radius: 50%;
        }

        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(0,97,255,.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand-icon {
            width: 88px;
            height: 88px;
            background: linear-gradient(135deg, var(--brand-primary) 0%, #3b82f6 100%);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0,97,255,.45);
            position: relative;
            z-index: 1;
        }

        .brand-icon i { font-size: 2.6rem; color: #fff; }

        .panel-left .brand-name {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.02em;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .panel-left .brand-name span { color: var(--brand-primary); }

        .panel-left .brand-tagline {
            color: #94a3b8;
            font-size: .95rem;
            text-align: center;
            margin-top: .5rem;
            position: relative;
            z-index: 1;
        }

        .feature-list {
            margin-top: 3rem;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: .875rem;
            padding: .875rem 1.25rem;
            border-radius: 12px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            margin-bottom: .75rem;
        }

        .feature-item .icon-wrap {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(0,97,255,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-item .icon-wrap i { color: var(--brand-primary); font-size: 1.05rem; }

        .feature-item .feat-text {
            font-size: .85rem;
            color: #cbd5e1;
            font-weight: 500;
        }

        .panel-left .footer-note {
            margin-top: auto;
            padding-top: 2.5rem;
            color: #475569;
            font-size: .78rem;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        /* ── RIGHT PANEL ── */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            padding: 2.5rem;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .login-card .card-heading {
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--brand-dark);
            letter-spacing: -.02em;
        }

        .login-card .card-sub {
            color: #64748b;
            font-size: .9rem;
            margin-top: .25rem;
        }

        .form-label {
            font-size: .83rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .4rem;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: .65rem 1rem;
            font-size: .925rem;
            background: #fff;
            transition: border-color .15s, box-shadow .15s;
        }

        .form-control:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(0,97,255,.12);
        }

        .input-group-text {
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            background: #f1f5f9;
            color: #64748b;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: var(--brand-primary);
        }

        .input-group:focus-within .form-control {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(0,97,255,.12);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--brand-primary) 0%, #3b82f6 100%);
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-weight: 600;
            font-size: .95rem;
            color: #fff;
            width: 100%;
            transition: opacity .15s, transform .1s;
            box-shadow: 0 4px 14px rgba(0,97,255,.3);
        }

        .btn-login:hover { opacity: .93; transform: translateY(-1px); color: #fff; }
        .btn-login:active { transform: translateY(0); }

        .divider { border-color: #e2e8f0; }

        .forgot-link {
            font-size: .82rem;
            color: #64748b;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover { color: var(--brand-primary); }

        .remember-label {
            font-size: .85rem;
            color: #475569;
            cursor: pointer;
            user-select: none;
        }

        .form-check-input:checked {
            background-color: var(--brand-primary);
            border-color: var(--brand-primary);
        }

        .alert-danger {
            border-radius: 10px;
            font-size: .875rem;
            border: 1px solid #fecaca;
            background: #fff5f5;
            color: #dc2626;
        }

        .invalid-feedback, .text-red-600 {
            font-size: .8rem;
            color: #dc2626 !important;
        }

        /* Mobile */
        @media (max-width: 768px) {
            body { flex-direction: column; }
            .panel-left {
                width: 100%;
                padding: 2.5rem 2rem;
                min-height: auto;
            }
            .panel-left .brand-name { font-size: 1.6rem; }
            .feature-list { display: none; }
            .panel-left .footer-note { display: none; }
            .panel-right { padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>
    <!-- LEFT -->
    <div class="panel-left">
        <div class="brand-icon">
            <i class="bi bi-hospital-fill"></i>
        </div>
        <div class="brand-name">FARMÁCIA<span>MUNI</span></div>
        <div class="brand-tagline">Sistema de Gestão Municipal</div>

        <div class="feature-list">
            <div class="feature-item">
                <div class="icon-wrap"><i class="bi bi-folder2-open"></i></div>
                <div class="feat-text">Gestão completa de processos e receitas</div>
            </div>
            <div class="feature-item">
                <div class="icon-wrap"><i class="bi bi-people-fill"></i></div>
                <div class="feat-text">Cadastro de pacientes e representantes</div>
            </div>
            <div class="feature-item">
                <div class="icon-wrap"><i class="bi bi-capsule"></i></div>
                <div class="feat-text">Controle de medicamentos e dispensação</div>
            </div>
            <div class="feature-item">
                <div class="icon-wrap"><i class="bi bi-receipt"></i></div>
                <div class="feat-text">Emissão de recibos e relatórios</div>
            </div>
        </div>

        <div class="footer-note">
            &copy; {{ date('Y') }} Farmácia Municipal &mdash; Todos os direitos reservados
        </div>
    </div>

    <!-- RIGHT -->
    <div class="panel-right">
        <div class="login-card">
            {{ $slot }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
