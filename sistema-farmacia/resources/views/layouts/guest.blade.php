<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GovSaúde — Gestão Farmacêutica Municipal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --indigo: #4f46e5;
            --indigo-light: #6366f1;
            --violet: #7c3aed;
            --cyan: #06b6d4;
            --emerald: #10b981;
            --dark: #080815;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* ────────────────────────────────────────
           LEFT PANEL — Aurora animado
        ──────────────────────────────────────── */
        .panel-left {
            width: 52%;
            background: var(--dark);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3.5rem;
            overflow: hidden;
        }

        /* Grade de pontos */
        .panel-left::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 28px 28px;
            z-index: 0;
        }

        /* Aurora blobs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: .55;
            z-index: 0;
        }
        .orb-1 {
            width: 420px; height: 420px;
            background: radial-gradient(circle, var(--indigo), transparent 70%);
            top: -100px; left: -100px;
            animation: float1 9s ease-in-out infinite alternate;
        }
        .orb-2 {
            width: 360px; height: 360px;
            background: radial-gradient(circle, var(--violet), transparent 70%);
            bottom: -80px; right: -80px;
            animation: float2 12s ease-in-out infinite alternate;
        }
        .orb-3 {
            width: 250px; height: 250px;
            background: radial-gradient(circle, var(--cyan), transparent 70%);
            top: 45%; left: 55%;
            opacity: .35;
            animation: float3 7s ease-in-out infinite alternate;
        }

        @keyframes float1 {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(60px, 80px) scale(1.12); }
        }
        @keyframes float2 {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(-50px, -60px) scale(1.08); }
        }
        @keyframes float3 {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(-40px, 40px) scale(1.2); }
        }

        /* Conteúdo do painel esquerdo */
        .left-content { position: relative; z-index: 1; width: 100%; max-width: 420px; }

        /* Logo */
        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            animation: fadeUp .7s ease both;
        }
        .brand-icon-wrap {
            width: 64px; height: 64px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--indigo) 0%, var(--violet) 100%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 0 30px rgba(99,102,241,.6), 0 0 60px rgba(99,102,241,.2);
            animation: pulse-glow 3s ease-in-out infinite;
        }
        .brand-icon-wrap i { font-size: 1.8rem; color: #fff; }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 30px rgba(99,102,241,.6), 0 0 60px rgba(99,102,241,.2); }
            50%       { box-shadow: 0 0 50px rgba(124,58,237,.8), 0 0 90px rgba(99,102,241,.35); }
        }

        .brand-text .name {
            font-size: 1.75rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -.03em;
            line-height: 1;
        }
        .brand-text .name span { color: var(--cyan); }
        .brand-text .tagline {
            font-size: .82rem;
            color: #4a5568;
            margin-top: .2rem;
            font-weight: 400;
            letter-spacing: .02em;
        }

        /* Feature list */
        .feat-list { margin-top: 2.5rem; display: flex; flex-direction: column; gap: .75rem; }

        .feat-item {
            display: flex;
            align-items: center;
            gap: .875rem;
            padding: .875rem 1.1rem;
            border-radius: 14px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            backdrop-filter: blur(6px);
            opacity: 0;
            animation: fadeUp .5s ease forwards;
        }
        .feat-item:nth-child(1) { animation-delay: .15s; }
        .feat-item:nth-child(2) { animation-delay: .25s; }
        .feat-item:nth-child(3) { animation-delay: .35s; }
        .feat-item:nth-child(4) { animation-delay: .45s; }
        .feat-item:nth-child(5) { animation-delay: .55s; }

        .feat-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, rgba(79,70,229,.35), rgba(124,58,237,.35));
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .feat-icon i { color: #a5b4fc; font-size: 1rem; }
        .feat-text { font-size: .84rem; color: #94a3b8; font-weight: 500; line-height: 1.4; }

        .left-footer {
            position: relative; z-index: 1;
            margin-top: 2.5rem;
            font-size: .75rem;
            color: #2d3748;
        }

        /* ────────────────────────────────────────
           RIGHT PANEL — Formulários
        ──────────────────────────────────────── */
        .panel-right {
            flex: 1;
            background: #f8faff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
            overflow-y: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            animation: fadeUp .5s .1s ease both;
        }

        /* Tabs */
        .auth-tabs {
            display: flex;
            border-bottom: 2px solid #e8eaf6;
            margin-bottom: 2rem;
        }
        .auth-tab {
            flex: 1; padding: .7rem 0;
            text-align: center;
            font-size: .875rem; font-weight: 600;
            color: #94a3b8;
            cursor: pointer; border: none; background: none;
            border-bottom: 2.5px solid transparent;
            margin-bottom: -2px;
            transition: color .2s, border-color .2s;
        }
        .auth-tab.active { color: var(--indigo); border-bottom-color: var(--indigo); }
        .auth-tab i { margin-right: .3rem; }

        /* Heading */
        .auth-heading { font-size: 1.55rem; font-weight: 800; color: #0f172a; letter-spacing: -.03em; }
        .auth-sub { font-size: .88rem; color: #64748b; margin-top: .2rem; margin-bottom: 1.75rem; }

        /* Form */
        .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }

        .input-wrap {
            position: relative;
        }
        .input-wrap .input-icon {
            position: absolute;
            left: .9rem; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: .95rem;
            pointer-events: none;
        }
        .input-wrap input, .input-wrap select, .input-wrap textarea {
            width: 100%;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: .7rem 1rem .7rem 2.4rem;
            font-size: .9rem;
            color: #1e293b;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            font-family: 'Inter', sans-serif;
        }
        .input-wrap textarea { padding-left: 1rem; resize: vertical; }
        .input-wrap input:focus, .input-wrap select:focus, .input-wrap textarea:focus {
            border-color: var(--indigo);
            box-shadow: 0 0 0 3.5px rgba(79,70,229,.12);
        }
        .input-wrap .eye-btn {
            position: absolute;
            right: .8rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #94a3b8;
            cursor: pointer; font-size: .95rem; padding: .2rem;
        }
        .input-wrap .eye-btn:hover { color: var(--indigo); }

        /* Checkbox / Links */
        .form-check-input:checked { background-color: var(--indigo); border-color: var(--indigo); }
        .remember-label { font-size: .84rem; color: #475569; cursor: pointer; user-select: none; }
        .forgot-link { font-size: .82rem; color: #94a3b8; text-decoration: none; font-weight: 500; }
        .forgot-link:hover { color: var(--indigo); }

        /* Botão primário */
        .btn-primary-full {
            width: 100%;
            padding: .8rem;
            border: none; border-radius: 12px;
            font-size: .95rem; font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--indigo) 0%, var(--violet) 100%);
            box-shadow: 0 4px 20px rgba(79,70,229,.35);
            cursor: pointer;
            transition: transform .15s, box-shadow .15s, opacity .15s;
            position: relative;
            overflow: hidden;
        }
        .btn-primary-full::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.18) 50%, transparent 60%);
            transform: translateX(-100%);
            transition: transform .4s ease;
        }
        .btn-primary-full:hover::after { transform: translateX(100%); }
        .btn-primary-full:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(79,70,229,.45); }
        .btn-primary-full:active { transform: translateY(0); }

        /* Botão verde (contato) */
        .btn-green-full {
            width: 100%;
            padding: .8rem;
            border: none; border-radius: 12px;
            font-size: .95rem; font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            box-shadow: 0 4px 20px rgba(16,185,129,.35);
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            position: relative; overflow: hidden;
        }
        .btn-green-full::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,.18) 50%, transparent 60%);
            transform: translateX(-100%);
            transition: transform .4s ease;
        }
        .btn-green-full:hover::after { transform: translateX(100%); }
        .btn-green-full:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(16,185,129,.45); }

        /* Alerts */
        .alert-err {
            border-radius: 12px; font-size: .875rem;
            border: 1px solid #fecaca; background: #fff5f5; color: #dc2626;
            padding: .75rem 1rem;
            display: flex; align-items: center; gap: .6rem;
        }

        /* Success card */
        .success-wrap { text-align: center; padding: 1.5rem 0; }
        .success-wrap .check-ring {
            width: 72px; height: 72px; border-radius: 50%;
            background: linear-gradient(135deg, #059669, #10b981);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 0 0 10px rgba(16,185,129,.12);
            animation: pop .4s cubic-bezier(.34,1.56,.64,1) both;
        }
        .success-wrap .check-ring i { color: #fff; font-size: 2rem; }
        @keyframes pop {
            from { transform: scale(0); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }
        .success-wrap h4 { font-size: 1.3rem; font-weight: 800; color: #065f46; margin-bottom: .5rem; }
        .success-wrap p { font-size: .9rem; color: #047857; line-height: 1.6; }

        /* Animações gerais */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Mobile */
        @media (max-width: 860px) {
            body { flex-direction: column; overflow: auto; }
            .panel-left { width: 100%; padding: 2.5rem 1.5rem; min-height: auto; }
            .feat-list { display: none; }
            .left-footer { display: none; }
            .panel-right { min-height: auto; padding: 2rem 1.25rem; }
        }
    </style>
</head>
<body>

<!-- ── LEFT ── -->
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

        <div class="feat-list">
            <div class="feat-item">
                <div class="feat-icon"><i class="bi bi-folder2-open"></i></div>
                <div class="feat-text">Gestão completa de processos, APAC e receitas</div>
            </div>
            <div class="feat-item">
                <div class="feat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="feat-text">Cadastro de pacientes, representantes e prescritores</div>
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
                <div class="feat-text">Auditoria completa de todas as ações do sistema</div>
            </div>
        </div>

        <div class="left-footer">&copy; {{ date('Y') }} GovSaúde &mdash; Todos os direitos reservados</div>
    </div>
</div>

<!-- ── RIGHT ── -->
<div class="panel-right">
    <div class="auth-card">

        <div class="auth-tabs">
            <button class="auth-tab {{ session('contato_enviado') ? '' : 'active' }}"
                    id="tab-login" onclick="showTab('login')">
                <i class="bi bi-box-arrow-in-right"></i>Entrar
            </button>
            <button class="auth-tab {{ session('contato_enviado') ? 'active' : '' }}"
                    id="tab-contato" onclick="showTab('contato')">
                <i class="bi bi-stars"></i>Quero o GovSaúde
            </button>
        </div>

        <!-- LOGIN -->
        <div id="panel-login" style="{{ session('contato_enviado') ? 'display:none' : '' }}">
            {{ $slot }}
        </div>

        <!-- CONTATO -->
        <div id="panel-contato" style="{{ session('contato_enviado') ? '' : 'display:none' }}">

            @if(session('contato_enviado'))
            <div class="success-wrap">
                <div class="check-ring"><i class="bi bi-check-lg"></i></div>
                <h4>Solicitação recebida!</h4>
                <p>Entraremos em contato em <strong>menos de uma hora</strong>.<br>Fique atento ao seu e-mail e WhatsApp.</p>
                <button class="btn-primary-full mt-3" onclick="showTab('login')">
                    <i class="bi bi-arrow-left me-2"></i>Voltar ao login
                </button>
            </div>

            @else
            <div class="auth-heading">Quero o GovSaúde</div>
            <div class="auth-sub">Preencha e entraremos em contato em menos de 1 hora</div>

            @if($errors->any())
            <div class="alert-err mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('contato.store') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nome completo</label>
                    <div class="input-wrap">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="nome" placeholder="Seu nome" value="{{ old('nome') }}" required>
                    </div>
                </div>
                <div class="row g-2 mb-3">
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
                            <input type="text" name="telefone" placeholder="(00) 00000-0000" value="{{ old('telefone') }}" id="telefone-contato" required>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-3">
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
                            <input type="text" name="estado" placeholder="SP" maxlength="2" value="{{ old('estado') }}" id="uf-contato" style="text-transform:uppercase" required>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Mensagem (opcional)</label>
                    <div class="input-wrap">
                        <textarea name="mensagem" rows="3" placeholder="Conte um pouco sobre a necessidade do município...">{{ old('mensagem') }}</textarea>
                    </div>
                </div>
                <button type="submit" class="btn-green-full">
                    <i class="bi bi-send me-2"></i>Enviar solicitação
                </button>
            </form>
            @endif
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function showTab(tab) {
    document.getElementById('panel-login').style.display   = tab === 'login'   ? '' : 'none';
    document.getElementById('panel-contato').style.display = tab === 'contato' ? '' : 'none';
    document.getElementById('tab-login').classList.toggle('active',   tab === 'login');
    document.getElementById('tab-contato').classList.toggle('active', tab === 'contato');
}

(function () {
    var tel = document.getElementById('telefone-contato');
    if (tel) {
        tel.addEventListener('input', function () {
            var d = tel.value.replace(/\D/g,'').slice(0,11);
            if (d.length <= 10) {
                var p = '(00) 0000-0000';
                var r = '', di = 0;
                for (var i = 0; i < p.length && di < d.length; i++)
                    r += p[i] === '0' ? d[di++] : p[i];
                tel.value = r;
            } else {
                var p = '(00) 00000-0000';
                var r = '', di = 0;
                for (var i = 0; i < p.length && di < d.length; i++)
                    r += p[i] === '0' ? d[di++] : p[i];
                tel.value = r;
            }
        });
    }
    var uf = document.getElementById('uf-contato');
    if (uf) {
        uf.addEventListener('input', function () {
            uf.value = uf.value.toUpperCase().replace(/[^A-Z]/g,'').slice(0,2);
        });
    }
})();
</script>
</body>
</html>
