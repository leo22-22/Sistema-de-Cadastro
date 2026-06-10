<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Política de Privacidade (LGPD) — GovSaúde</title>
    <meta name="description" content="Política de Privacidade e proteção de dados do GovSaúde, em conformidade com a Lei nº 13.709/2018 (LGPD).">
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
        .highlight-box {
            background: #eff6ff; border: 1px solid #bfdbfe;
            border-radius: 10px; padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }
        .highlight-box p { color: #1d4ed8; margin: 0; }
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
        <a href="#controlador">1. Controlador dos Dados</a>
        <a href="#dados">2. Dados Coletados</a>
        <a href="#base-legal">3. Base Legal (LGPD)</a>
        <a href="#finalidade">4. Finalidade do Tratamento</a>
        <a href="#direitos">5. Direitos do Titular</a>
        <a href="#retencao">6. Retenção de Dados</a>
        <a href="#seguranca">7. Medidas de Segurança</a>
        <a href="#compartilhamento">8. Compartilhamento</a>
        <a href="#encarregado">9. Encarregado (DPO)</a>
        <a href="#alteracoes">10. Alterações</a>
    </div>

    <div class="content">
        <div class="doc-header">
            <h1><i class="bi bi-shield-lock-fill" style="color:var(--indigo)"></i> Política de Privacidade</h1>
            <div class="meta">
                <strong>GovSaúde — Sistema de Gestão Farmacêutica Municipal</strong><br>
                Em conformidade com a Lei nº 13.709/2018 (LGPD) &middot; Versão 1.0 &middot; Última atualização: junho de 2025<br>
                <a href="{{ route('legal.termos') }}" style="color:var(--indigo)">Ver Termos de Uso</a>
            </div>
        </div>

        <div class="doc-section" id="controlador">
            <h2><i class="bi bi-building-fill"></i>1. Controlador dos Dados</h2>
            <p>O <strong>controlador dos dados pessoais</strong> tratados no sistema GovSaúde é o <strong>Município contratante</strong>, representado pela sua Secretaria Municipal de Saúde, CNPJ e endereço conforme contrato de prestação de serviços.</p>
            <p>O GovSaúde atua como <strong>operador de dados</strong>, processando as informações exclusivamente conforme as instruções e sob a responsabilidade do município contratante, nos termos do art. 39 da LGPD.</p>
            <div class="highlight-box">
                <p><i class="bi bi-info-circle-fill me-2"></i><strong>Dados sensíveis de saúde:</strong> O GovSaúde trata dados sensíveis conforme o art. 11 da LGPD (dado de saúde), com fundamento no interesse público em saúde (art. 7º, III e art. 11, II, "b" da LGPD), bem como na prestação de serviços públicos de saúde.</p>
            </div>
        </div>

        <div class="doc-section" id="dados">
            <h2><i class="bi bi-database-fill"></i>2. Dados Coletados</h2>
            <p>O sistema coleta e trata as seguintes categorias de dados:</p>
            <p><strong>Dados de Pacientes (dados sensíveis de saúde):</strong></p>
            <ul>
                <li>Dados de identificação: nome completo, data de nascimento, CPF, CNS (Cartão Nacional de Saúde), RG;</li>
                <li>Dados de contato: endereço, telefone;</li>
                <li>Dados de saúde: diagnósticos (CID-10), medicamentos dispensados, doses, posologias;</li>
                <li>Histórico de processos APAC e renovações;</li>
                <li>Registros de dispensação e recibos.</li>
            </ul>
            <p><strong>Dados de Representantes:</strong></p>
            <ul>
                <li>Nome, CPF, tipo de relação com o paciente, dados de contato.</li>
            </ul>
            <p><strong>Dados de Médicos Prescritores:</strong></p>
            <ul>
                <li>Nome, CRM, especialidade, UF de atuação.</li>
            </ul>
            <p><strong>Dados de Usuários do Sistema (servidores públicos):</strong></p>
            <ul>
                <li>Nome completo, endereço de e-mail, função/cargo (role), farmácia vinculada;</li>
                <li>Logs de acesso e auditoria de ações realizadas no sistema.</li>
            </ul>
        </div>

        <div class="doc-section" id="base-legal">
            <h2><i class="bi bi-journal-text"></i>3. Base Legal (LGPD)</h2>
            <p>O tratamento de dados pessoais no GovSaúde é fundamentado nas seguintes hipóteses legais da Lei nº 13.709/2018:</p>
            <ul>
                <li><strong>Art. 7º, III:</strong> Execução de políticas públicas previstas em leis e regulamentos (dispensação de medicamentos do SUS, CEAF);</li>
                <li><strong>Art. 7º, VI:</strong> Exercício regular de direitos em processo administrativo farmacêutico;</li>
                <li><strong>Art. 11, II, "b":</strong> Tratamento de dados de saúde para tutela da saúde, exclusivamente por profissionais de saúde ou autoridades sanitárias;</li>
                <li><strong>Art. 11, II, "d":</strong> Realização de estudos por órgão de pesquisa (quando aplicável, com anonimização);</li>
                <li><strong>Art. 23:</strong> Tratamento pelo poder público para o exercício de suas competências legais.</li>
            </ul>
        </div>

        <div class="doc-section" id="finalidade">
            <h2><i class="bi bi-bullseye"></i>4. Finalidade do Tratamento</h2>
            <p>Os dados são tratados exclusivamente para as seguintes finalidades:</p>
            <ul>
                <li>Gestão e controle de processos de dispensação de medicamentos do Componente Especializado da Assistência Farmacêutica (CEAF/APAC);</li>
                <li>Controle de estoque e rastreabilidade de medicamentos;</li>
                <li>Emissão de recibos e comprovantes de dispensação;</li>
                <li>Geração de relatórios gerenciais e estatísticos para a gestão municipal de saúde;</li>
                <li>Cumprimento de obrigações legais e regulatórias junto ao Ministério da Saúde e órgãos estaduais;</li>
                <li>Auditoria e controle interno das atividades da farmácia municipal.</li>
            </ul>
        </div>

        <div class="doc-section" id="direitos">
            <h2><i class="bi bi-person-check-fill"></i>5. Direitos do Titular</h2>
            <p>Nos termos do art. 18 da LGPD, o titular dos dados (paciente ou responsável legal) tem os seguintes direitos:</p>
            <ul>
                <li><strong>Acesso:</strong> solicitar confirmação da existência e acesso aos dados tratados;</li>
                <li><strong>Correção:</strong> solicitar correção de dados incompletos, inexatos ou desatualizados;</li>
                <li><strong>Anonimização, bloqueio ou eliminação:</strong> de dados desnecessários, excessivos ou tratados em desconformidade com a lei;</li>
                <li><strong>Portabilidade:</strong> receber os dados em formato estruturado e interoperável;</li>
                <li><strong>Informação:</strong> ser informado sobre as entidades públicas e privadas com as quais houve compartilhamento;</li>
                <li><strong>Oposição:</strong> opor-se ao tratamento em caso de descumprimento da lei.</li>
            </ul>
            <p>Solicitações de exercício de direitos devem ser encaminhadas ao Encarregado de Dados (DPO) do município, conforme seção 9 desta política.</p>
            <div class="highlight-box">
                <p><i class="bi bi-exclamation-circle-fill me-2"></i>Nos casos em que o tratamento seja necessário para a prestação de serviços de saúde ou cumprimento de obrigação legal, a eliminação imediata dos dados pode não ser possível, devendo ser justificada e comunicada ao titular.</p>
            </div>
        </div>

        <div class="doc-section" id="retencao">
            <h2><i class="bi bi-clock-history"></i>6. Retenção de Dados</h2>
            <p>Os dados são retidos pelos seguintes prazos:</p>
            <ul>
                <li><strong>Dados de pacientes e processos APAC:</strong> mínimo de 5 (cinco) anos após o encerramento do processo, conforme Resolução CFM nº 1.821/2007 e normas do Ministério da Saúde;</li>
                <li><strong>Registros de dispensação:</strong> mínimo de 5 (cinco) anos;</li>
                <li><strong>Logs de auditoria do sistema:</strong> mínimo de 2 (dois) anos;</li>
                <li><strong>Dados de usuários:</strong> enquanto a conta estiver ativa e por até 1 (um) ano após o encerramento.</li>
            </ul>
            <p>Após o prazo de retenção, os dados serão eliminados de forma segura ou anonimizados, conforme a natureza e obrigações legais aplicáveis.</p>
        </div>

        <div class="doc-section" id="seguranca">
            <h2><i class="bi bi-lock-fill"></i>7. Medidas de Segurança</h2>
            <p>O GovSaúde adota as seguintes medidas técnicas e administrativas para proteger os dados pessoais:</p>
            <ul>
                <li><strong>Criptografia:</strong> senhas armazenadas com hash bcrypt (Laravel Hashing); comunicação via HTTPS/TLS;</li>
                <li><strong>Controle de acesso:</strong> autenticação com credenciais individuais; controle por perfis de usuário (superadmin, admin_farmacia, funcionário);</li>
                <li><strong>Log de auditoria:</strong> registro de todas as operações de criação, edição e exclusão de dados, com identificação do usuário, data/hora e ação realizada;</li>
                <li><strong>Backup:</strong> cópias de segurança periódicas com retenção dos últimos 30 backups;</li>
                <li><strong>Ambiente isolado por farmácia:</strong> cada farmácia visualiza apenas seus próprios dados;</li>
                <li><strong>Infraestrutura:</strong> hospedagem em ambiente cloud com isolamento de contêineres (Docker) e banco de dados gerenciado.</li>
            </ul>
        </div>

        <div class="doc-section" id="compartilhamento">
            <h2><i class="bi bi-share-fill"></i>8. Compartilhamento de Dados</h2>
            <p>Os dados tratados no GovSaúde <strong>não são compartilhados com terceiros</strong> para fins comerciais ou publicitários.</p>
            <p>O compartilhamento poderá ocorrer apenas nas seguintes hipóteses:</p>
            <ul>
                <li>Por determinação judicial ou de autoridade competente (ANVISA, Ministério da Saúde, órgãos de controle);</li>
                <li>Para cumprimento de obrigações legais de prestação de contas ao SUS e ao Ministério da Saúde;</li>
                <li>Com prestadores de serviços de infraestrutura tecnológica (hospedagem), sujeitos a acordos de confidencialidade e tratamento de dados.</li>
            </ul>
            <p>A integração futura com a RNDS (Rede Nacional de Dados em Saúde) será feita com consentimento e em conformidade com a Portaria GM/MS nº 1.792/2023, quando implementada.</p>
        </div>

        <div class="doc-section" id="encarregado">
            <h2><i class="bi bi-person-badge-fill"></i>9. Encarregado de Dados (DPO)</h2>
            <p>O <strong>Encarregado pelo Tratamento de Dados Pessoais (DPO)</strong> é o responsável indicado pelo município contratante, conforme o art. 41 da LGPD.</p>
            <p>Para exercer seus direitos como titular de dados ou para comunicar qualquer incidente de segurança, entre em contato pelo canal oficial da Secretaria Municipal de Saúde do seu município.</p>
            <p>Para questões técnicas relacionadas ao sistema GovSaúde, utilize o canal de suporte disponível na plataforma.</p>
        </div>

        <div class="doc-section" id="alteracoes">
            <h2><i class="bi bi-pencil-square"></i>10. Alterações nesta Política</h2>
            <p>Esta Política de Privacidade pode ser atualizada periodicamente para refletir mudanças na legislação, nas práticas de tratamento de dados ou nas funcionalidades do sistema.</p>
            <p>Alterações relevantes serão comunicadas aos administradores do sistema com antecedência razoável. A versão mais recente estará sempre disponível nesta página.</p>
            <p>A data da última atualização é exibida no cabeçalho deste documento.</p>

            <p style="color:#94a3b8; font-size:.8rem; margin-top:1.5rem">
                &copy; {{ date('Y') }} GovSaúde &mdash; Todos os direitos reservados.<br>
                <a href="{{ route('login') }}" style="color:var(--indigo)">Voltar ao login</a>
                &nbsp;&middot;&nbsp;
                <a href="{{ route('legal.termos') }}" style="color:var(--indigo)">Termos de Uso</a>
                &nbsp;&middot;&nbsp;
                <a href="{{ route('status.index') }}" style="color:var(--indigo)" target="_blank">Status do Sistema</a>
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
