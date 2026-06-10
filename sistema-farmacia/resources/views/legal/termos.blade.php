<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termos de Uso — GovSaúde</title>
    <meta name="description" content="Termos de Uso do sistema GovSaúde — plataforma de gestão farmacêutica municipal.">
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
            font-size: .92rem;
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
        .top-bar .back-link {
            font-size: .82rem; color: rgba(255,255,255,.85); text-decoration: none;
            display: flex; align-items: center; gap: .35rem;
            transition: color .15s;
        }
        .top-bar .back-link:hover { color: #fff; }
        .layout { display: flex; max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem 4rem; gap: 2rem; }
        .sidebar-nav {
            width: 220px; flex-shrink: 0;
            position: sticky; top: 1.5rem; align-self: flex-start;
        }
        .sidebar-nav .nav-title {
            font-size: .68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .1em; color: #94a3b8; margin-bottom: .5rem;
        }
        .sidebar-nav a {
            display: block; padding: .38rem .75rem;
            font-size: .82rem; color: #64748b; text-decoration: none;
            border-left: 2px solid #e2e8f0; margin-bottom: 2px;
            transition: color .15s, border-color .15s;
        }
        .sidebar-nav a:hover { color: var(--indigo); border-left-color: var(--indigo); }
        .content { flex: 1; min-width: 0; }
        .doc-header {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.5rem;
        }
        .doc-header h1 { font-size: 1.5rem; font-weight: 800; color: #0f172a; margin-bottom: .35rem; }
        .doc-header .meta { font-size: .8rem; color: #94a3b8; }
        .doc-section {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-bottom: 1rem;
        }
        .doc-section h2 {
            font-size: 1rem; font-weight: 700; color: var(--indigo);
            margin-bottom: 1rem; display: flex; align-items: center; gap: .5rem;
        }
        .doc-section p, .doc-section li { color: #374151; line-height: 1.75; margin-bottom: .6rem; }
        .doc-section ul { padding-left: 1.4rem; }
        .doc-section li { margin-bottom: .3rem; }
        @media (max-width: 768px) {
            .layout { flex-direction: column; }
            .sidebar-nav { width: 100%; position: static; }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <a href="{{ route('login') }}" class="brand">Gov<span>Saúde</span></a>
    <a href="{{ route('login') }}" class="back-link"><i class="bi bi-arrow-left"></i>Voltar ao login</a>
</div>

<div class="layout">
    <div class="sidebar-nav">
        <div class="nav-title">Neste documento</div>
        <a href="#objeto">1. Objeto e Escopo</a>
        <a href="#usuarios">2. Responsabilidades do Usuário</a>
        <a href="#obrigacoes">3. Obrigações do Sistema</a>
        <a href="#limitacoes">4. Limitações do Sistema</a>
        <a href="#propriedade">5. Propriedade Intelectual</a>
        <a href="#suspensao">6. Suspensão e Encerramento</a>
        <a href="#legislacao">7. Legislação Aplicável</a>
        <a href="#contato">8. Contato</a>
    </div>

    <div class="content">
        <div class="doc-header">
            <h1><i class="bi bi-file-text" style="color:var(--indigo)"></i> Termos de Uso</h1>
            <div class="meta">
                <strong>GovSaúde — Sistema de Gestão Farmacêutica Municipal</strong><br>
                Versão 1.0 &middot; Última atualização: junho de 2025 &middot;
                <a href="{{ route('legal.privacidade') }}" style="color:var(--indigo)">Ver Política de Privacidade</a>
            </div>
        </div>

        <div class="doc-section" id="objeto">
            <h2><i class="bi bi-info-circle-fill"></i>1. Objeto e Escopo</h2>
            <p>Os presentes Termos de Uso regulam a utilização do sistema <strong>GovSaúde</strong>, plataforma de gestão farmacêutica municipal, voltada ao controle de processos de dispensação, estoque de medicamentos, cadastro de pacientes e geração de relatórios para farmácias públicas municipais.</p>
            <p>O sistema é disponibilizado exclusivamente para municípios e seus respectivos servidores públicos habilitados, que atuem nas áreas de saúde pública, farmácia municipal e componente especializado da assistência farmacêutica (CEAF/APAC).</p>
            <p>Ao acessar e utilizar o GovSaúde, o usuário declara ter lido, compreendido e aceito integralmente os presentes Termos de Uso.</p>
        </div>

        <div class="doc-section" id="usuarios">
            <h2><i class="bi bi-person-check-fill"></i>2. Responsabilidades do Usuário</h2>
            <p>O usuário se compromete a:</p>
            <ul>
                <li>Utilizar o sistema exclusivamente para fins oficiais e no exercício de suas funções públicas;</li>
                <li>Manter sigilo absoluto sobre suas credenciais de acesso (login e senha), não as compartilhando com terceiros;</li>
                <li>Comunicar imediatamente à administração do sistema qualquer suspeita de uso indevido ou violação de acesso;</li>
                <li>Inserir apenas dados verídicos, completos e atualizados, sendo responsável pela precisão das informações cadastradas;</li>
                <li>Não utilizar o sistema para fins pessoais, comerciais ou contrários ao interesse público;</li>
                <li>Cumprir todas as normas vigentes relativas à saúde pública, proteção de dados pessoais (Lei nº 13.709/2018 — LGPD) e legislação farmacêutica;</li>
                <li>Não acessar, modificar ou excluir dados de outros usuários, farmácias ou municípios sem autorização expressa;</li>
                <li>Reportar qualquer falha, inconsistência ou comportamento inesperado do sistema ao responsável técnico.</li>
            </ul>
        </div>

        <div class="doc-section" id="obrigacoes">
            <h2><i class="bi bi-shield-check"></i>3. Obrigações do Sistema</h2>
            <p>O GovSaúde se compromete a:</p>
            <ul>
                <li>Disponibilizar a plataforma com o máximo de estabilidade e continuidade possível, realizando manutenções preferencialmente em horários de baixo uso;</li>
                <li>Adotar medidas técnicas e administrativas de segurança adequadas para proteger os dados pessoais e de saúde armazenados;</li>
                <li>Realizar backups periódicos dos dados, conforme configurado pelo administrador do sistema;</li>
                <li>Notificar os usuários com antecedência razoável sobre manutenções programadas que afetem a disponibilidade;</li>
                <li>Manter registros de auditoria de todas as operações realizadas no sistema;</li>
                <li>Tratar os dados pessoais e de saúde em conformidade com a LGPD e demais normas aplicáveis.</li>
            </ul>
        </div>

        <div class="doc-section" id="limitacoes">
            <h2><i class="bi bi-exclamation-triangle-fill"></i>4. Limitações do Sistema</h2>
            <p>O GovSaúde é disponibilizado como ferramenta de apoio à gestão farmacêutica e <strong>não substitui</strong>:</p>
            <ul>
                <li>O julgamento clínico ou farmacêutico do profissional de saúde responsável;</li>
                <li>A verificação presencial de documentos, receitas e identidade de pacientes;</li>
                <li>A responsabilidade legal e regulatória do município pela dispensação de medicamentos;</li>
                <li>O cumprimento dos protocolos clínicos do Ministério da Saúde (PCDT).</li>
            </ul>
            <p>O sistema não garante disponibilidade ininterrupta (24/7) e pode apresentar interrupções por motivos técnicos, de manutenção ou de força maior. O GovSaúde não se responsabiliza por danos decorrentes de uso indevido ou em desconformidade com estes Termos.</p>
        </div>

        <div class="doc-section" id="propriedade">
            <h2><i class="bi bi-award-fill"></i>5. Propriedade Intelectual</h2>
            <p>Todo o código-fonte, design, interfaces, logotipos, textos e demais elementos que integram o GovSaúde são protegidos por direitos de propriedade intelectual e pertencem aos seus respectivos criadores.</p>
            <p>É vedado ao usuário:</p>
            <ul>
                <li>Reproduzir, copiar, distribuir ou comercializar qualquer parte do sistema sem autorização expressa;</li>
                <li>Realizar engenharia reversa, descompilação ou qualquer tentativa de extrair o código-fonte;</li>
                <li>Remover ou ocultar avisos de propriedade intelectual ou identificação do sistema.</li>
            </ul>
            <p>Os dados inseridos pelos usuários (cadastros, processos, dispensações) permanecem de propriedade do município e podem ser exportados a qualquer tempo pelo administrador.</p>
        </div>

        <div class="doc-section" id="suspensao">
            <h2><i class="bi bi-slash-circle-fill"></i>6. Suspensão e Encerramento</h2>
            <p>O acesso ao sistema poderá ser suspenso ou encerrado nas seguintes situações:</p>
            <ul>
                <li>Uso em desconformidade com estes Termos ou com a legislação vigente;</li>
                <li>Solicitação do administrador do município;</li>
                <li>Encerramento do contrato de prestação de serviços;</li>
                <li>Por determinação judicial ou de autoridade competente.</li>
            </ul>
            <p>Em caso de encerramento, o município terá direito à exportação de todos os seus dados em formato aberto, por período razoável a ser acordado.</p>
        </div>

        <div class="doc-section" id="legislacao">
            <h2><i class="bi bi-bank2"></i>7. Legislação Aplicável</h2>
            <p>Estes Termos de Uso são regidos pelas leis da República Federativa do Brasil, em especial:</p>
            <ul>
                <li>Lei nº 13.709/2018 — Lei Geral de Proteção de Dados Pessoais (LGPD);</li>
                <li>Lei nº 12.965/2014 — Marco Civil da Internet;</li>
                <li>Lei nº 8.080/1990 — Lei Orgânica da Saúde;</li>
                <li>Portaria GM/MS nº 344/1998 e demais regulamentos sanitários aplicáveis;</li>
                <li>Demais normas federais, estaduais e municipais pertinentes à assistência farmacêutica.</li>
            </ul>
            <p>Fica eleito o foro da comarca do município contratante para dirimir quaisquer controvérsias oriundas destes Termos, ressalvadas as competências da Justiça Federal.</p>
        </div>

        <div class="doc-section" id="contato">
            <h2><i class="bi bi-envelope-fill"></i>8. Contato</h2>
            <p>Dúvidas, solicitações ou comunicações relacionadas a estes Termos de Uso devem ser enviadas ao responsável técnico do sistema, por meio do canal oficial disponibilizado pelo seu município.</p>
            <p>Para questões relacionadas à proteção de dados pessoais, consulte nossa
                <a href="{{ route('legal.privacidade') }}" style="color:var(--indigo)">Política de Privacidade (LGPD)</a>.
            </p>
            <p style="color:#94a3b8; font-size:.8rem; margin-top:1.5rem">
                &copy; {{ date('Y') }} GovSaúde &mdash; Todos os direitos reservados.<br>
                <a href="{{ route('login') }}" style="color:var(--indigo)">Voltar ao login</a>
                &nbsp;&middot;&nbsp;
                <a href="{{ route('legal.privacidade') }}" style="color:var(--indigo)">Política de Privacidade</a>
                &nbsp;&middot;&nbsp;
                <a href="{{ route('status.index') }}" style="color:var(--indigo)" target="_blank">Status do Sistema</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
