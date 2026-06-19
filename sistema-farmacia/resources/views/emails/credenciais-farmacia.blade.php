<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Credenciais GovSaúde</title>
<style>
  body { margin:0; padding:0; background:#f1f5f9; font-family:'Segoe UI',Arial,sans-serif; }
  .wrap { max-width:560px; margin:32px auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
  .header { background:linear-gradient(135deg,#4f46e5,#7c3aed); padding:36px 40px; text-align:center; }
  .header-icon { width:60px; height:60px; background:rgba(255,255,255,.15); border-radius:14px; display:inline-flex; align-items:center; justify-content:center; margin-bottom:12px; }
  .header-icon svg { width:30px; height:30px; fill:#fff; }
  .brand { font-size:1.5rem; font-weight:900; color:#fff; letter-spacing:-.03em; margin:0; }
  .brand span { color:#67e8f9; }
  .body { padding:36px 40px; }
  h1 { font-size:1.1rem; font-weight:700; color:#0f172a; margin:0 0 8px; }
  p { color:#475569; font-size:.9rem; line-height:1.6; margin:0 0 20px; }
  .cred-box { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:20px 24px; margin:20px 0; }
  .cred-row { display:flex; align-items:center; gap:12px; margin-bottom:12px; }
  .cred-row:last-child { margin-bottom:0; }
  .cred-label { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#94a3b8; width:70px; flex-shrink:0; }
  .cred-value { font-size:.9rem; font-weight:600; color:#1e293b; font-family:'Courier New',monospace; background:#fff; border:1px solid #e2e8f0; border-radius:6px; padding:6px 12px; flex:1; word-break:break-all; }
  .btn { display:block; text-align:center; background:linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff !important; text-decoration:none; padding:14px 28px; border-radius:10px; font-weight:700; font-size:.95rem; margin:24px 0; }
  .alert { background:#fef9c3; border:1px solid #fde68a; border-radius:8px; padding:12px 16px; font-size:.82rem; color:#78350f; line-height:1.5; }
  .alert strong { color:#92400e; }
  .footer { background:#f8fafc; border-top:1px solid #f1f5f9; padding:20px 40px; text-align:center; }
  .footer p { font-size:.75rem; color:#94a3b8; margin:0; line-height:1.6; }
</style>
</head>
<body>
<div class="wrap">
  <div class="header">
    <div class="header-icon">
      <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/></svg>
    </div>
    <p class="brand">Gov<span>Saúde</span></p>
  </div>

  <div class="body">
    <h1>Olá, {{ $nomeAdmin }}!</h1>
    <p>
      A farmácia <strong>{{ $farmacia->nome }}</strong>
      @if($farmacia->cidade) ({{ $farmacia->cidade }}/{{ $farmacia->estado }}) @endif
      foi cadastrada no <strong>GovSaúde</strong>. Suas credenciais de acesso estão abaixo.
    </p>

    <div class="cred-box">
      <div class="cred-row">
        <span class="cred-label">Sistema</span>
        <span class="cred-value">{{ $urlSistema }}</span>
      </div>
      <div class="cred-row">
        <span class="cred-label">E-mail</span>
        <span class="cred-value">{{ $emailAdmin }}</span>
      </div>
      <div class="cred-row">
        <span class="cred-label">Senha</span>
        <span class="cred-value">{{ $senha }}</span>
      </div>
    </div>

    <a href="{{ $urlSistema }}" class="btn">Acessar o GovSaúde →</a>

    <div class="alert">
      <strong>⚠ Troque sua senha no primeiro acesso.</strong><br>
      Após entrar, vá em <em>Perfil → Alterar Senha</em> e defina uma senha pessoal.
      Não compartilhe estas credenciais.
    </div>

    <p style="margin-top:20px;font-size:.82rem;color:#94a3b8;">
      Se você não esperava este e-mail, ignore-o. Caso tenha dúvidas, entre em contato com o suporte GovSaúde.
    </p>
  </div>

  <div class="footer">
    <p>GovSaúde — Sistema de Gestão Farmacêutica Municipal<br>
    Este é um e-mail automático, não responda.</p>
  </div>
</div>
</body>
</html>
