<x-app-layout>

@push('styles')
<style>
    /* ── Treinamento ── */
    .tr-hero {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 16px;
        padding: 2rem 2.25rem;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.75rem;
        position: relative;
        overflow: hidden;
    }
    .tr-hero::before {
        content: '';
        position: absolute; inset: 0;
        background-image: radial-gradient(rgba(255,255,255,.06) 1px, transparent 1px);
        background-size: 22px 22px;
    }
    .tr-hero-content { position: relative; z-index: 1; }
    .tr-hero h3 { font-size: 1.35rem; font-weight: 800; margin: 0 0 .3rem; }
    .tr-hero p  { font-size: .88rem; opacity: .85; margin: 0; }
    .tr-hero-badge {
        position: relative; z-index: 1;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 14px;
        padding: .9rem 1.5rem;
        text-align: center;
        flex-shrink: 0;
    }
    .tr-hero-badge .pct { font-size: 2.2rem; font-weight: 900; line-height: 1; }
    .tr-hero-badge .lbl { font-size: .75rem; opacity: .8; margin-top: .2rem; }

    /* Global progress bar */
    .tr-progress-wrap { margin-bottom: 1.75rem; }
    .tr-progress-label {
        display: flex; justify-content: space-between;
        font-size: .82rem; color: var(--muted); margin-bottom: .4rem; font-weight: 500;
    }
    .tr-progress-bar {
        height: 8px; background: #e2e8f0; border-radius: 99px; overflow: hidden;
    }
    .tr-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #4f46e5, #06b6d4);
        border-radius: 99px;
        transition: width .6s cubic-bezier(.4,0,.2,1);
    }

    /* Module cards */
    .tr-module {
        border: 1.5px solid var(--border);
        border-radius: 14px;
        background: #fff;
        overflow: hidden;
        transition: box-shadow .2s, border-color .2s;
        margin-bottom: 1rem;
    }
    .tr-module.is-done {
        border-color: #10b981;
    }
    .tr-module:hover { box-shadow: 0 4px 20px rgba(79,70,229,.09); }

    .tr-module-header {
        display: flex; align-items: center; gap: 1rem;
        padding: 1.1rem 1.3rem;
        cursor: pointer;
        user-select: none;
    }
    .tr-module-icon {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .tr-module-icon i { font-size: 1.2rem; }

    .tr-module-meta { flex: 1; min-width: 0; }
    .tr-module-title { font-size: .93rem; font-weight: 700; color: #0f172a; margin: 0; }
    .tr-module-sub   { font-size: .79rem; color: var(--muted); margin: .15rem 0 0; }

    .tr-module-right { display: flex; align-items: center; gap: .9rem; flex-shrink: 0; }
    .tr-mini-bar {
        width: 80px; height: 5px;
        background: #f1f5f9; border-radius: 99px; overflow: hidden;
    }
    .tr-mini-fill {
        height: 100%; border-radius: 99px;
        background: linear-gradient(90deg, #4f46e5, #06b6d4);
        transition: width .4s ease;
    }
    .tr-module.is-done .tr-mini-fill { background: #10b981; }

    .tr-step-count { font-size: .78rem; color: var(--muted); white-space: nowrap; }
    .tr-chevron { color: #94a3b8; transition: transform .25s ease; }
    .tr-module.open .tr-chevron { transform: rotate(180deg); }

    .tr-done-badge {
        display: none;
        background: #dcfce7; color: #15803d;
        font-size: .72rem; font-weight: 700;
        padding: .25rem .6rem; border-radius: 6px;
        white-space: nowrap;
    }
    .tr-module.is-done .tr-done-badge { display: inline-flex; align-items: center; gap: .3rem; }

    /* Steps body */
    .tr-steps {
        display: none;
        padding: 0 1.3rem 1.3rem;
        border-top: 1px solid var(--border);
    }
    .tr-module.open .tr-steps { display: block; }

    .tr-step {
        display: flex; align-items: flex-start; gap: .9rem;
        padding: .75rem 0;
        border-bottom: 1px solid #f8fafc;
        cursor: pointer;
        transition: background .15s;
    }
    .tr-step:last-child { border-bottom: none; }
    .tr-step:hover .tr-step-box { border-color: #4f46e5; }

    .tr-step-box {
        width: 22px; height: 22px;
        border: 2px solid #cbd5e1;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; margin-top: .1rem;
        transition: background .2s, border-color .2s;
        background: #fff;
    }
    .tr-step.checked .tr-step-box {
        background: #4f46e5; border-color: #4f46e5;
    }
    .tr-step.checked .tr-step-box::after {
        content: '✓'; color: #fff; font-size: .75rem; font-weight: 700; line-height: 1;
    }

    .tr-step-content { flex: 1; }
    .tr-step-title {
        font-size: .875rem; font-weight: 500; color: #0f172a;
        transition: color .2s;
    }
    .tr-step.checked .tr-step-title { color: #94a3b8; text-decoration: line-through; }
    .tr-step-tip {
        font-size: .78rem; color: var(--muted); margin-top: .2rem; line-height: 1.5;
    }

    /* Module action button */
    .tr-module-action {
        display: flex; align-items: center; justify-content: space-between;
        padding: .9rem 1.3rem 0;
        margin-bottom: -.1rem;
    }
    .tr-btn-reset {
        font-size: .78rem; color: #94a3b8; background: none; border: none;
        cursor: pointer; padding: 0; text-decoration: underline;
        transition: color .15s;
    }
    .tr-btn-reset:hover { color: #ef4444; }

    /* Completion banner */
    .tr-complete-banner {
        display: none;
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff;
        border-radius: 14px;
        padding: 1.5rem 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .tr-complete-banner.show { display: block; animation: fadeUp .5s ease both; }
    .tr-complete-banner h4 { font-size: 1.2rem; font-weight: 800; margin: 0 0 .4rem; }
    .tr-complete-banner p  { font-size: .88rem; opacity: .9; margin: 0; }

    /* Color themes per module */
    .ic-blue   { background: rgba(79,70,229,.1); }  .ic-blue i   { color: #4f46e5; }
    .ic-cyan   { background: rgba(6,182,212,.1); }   .ic-cyan i   { color: #0891b2; }
    .ic-violet { background: rgba(124,58,237,.1); }  .ic-violet i { color: #7c3aed; }
    .ic-green  { background: rgba(16,185,129,.1); }  .ic-green i  { color: #059669; }
    .ic-amber  { background: rgba(245,158,11,.1); }  .ic-amber i  { color: #d97706; }
    .ic-rose   { background: rgba(244,63,94,.1); }   .ic-rose i   { color: #e11d48; }
    .ic-indigo { background: rgba(99,102,241,.1); }  .ic-indigo i { color: #6366f1; }
</style>
@endpush

<div class="page-header">
    <div>
        <h4><i class="bi bi-mortarboard-fill me-2"></i>Plano de Treinamento</h4>
        <small>Aprenda a usar o GovSaúde passo a passo</small>
    </div>
    <button class="btn btn-outline-secondary btn-sm" id="btnSkip" onclick="trSkip()">
        <i class="bi bi-x-lg me-1"></i>Ignorar treinamento
    </button>
</div>

{{-- Estado: treinamento ignorado --}}
<div id="trSkippedState" style="display:none">
    <div class="card p-4 text-center" style="border:1.5px dashed #cbd5e1">
        <i class="bi bi-mortarboard" style="font-size:2.5rem;color:#94a3b8;display:block;margin-bottom:.75rem"></i>
        <h5 class="fw-700 mb-1" style="color:#64748b">Treinamento ignorado</h5>
        <p class="text-muted mb-3" style="font-size:.875rem">Você pode retomar o treinamento a qualquer momento.</p>
        <button class="btn btn-primary btn-sm" onclick="trRestore()">
            <i class="bi bi-arrow-counterclockwise me-1"></i>Retomar treinamento
        </button>
    </div>
</div>

{{-- Banner de conclusão --}}
<div class="tr-complete-banner" id="trCompleteBanner">
    <i class="bi bi-trophy-fill" style="font-size:2rem;display:block;margin-bottom:.5rem"></i>
    <h4>Treinamento concluído!</h4>
    <p>Parabéns! Você completou todos os módulos e está pronto para usar o GovSaúde.</p>
</div>

{{-- Hero --}}
<div class="tr-hero">
    <div class="tr-hero-content">
        <h3><i class="bi bi-mortarboard-fill me-2"></i>Plano de Treinamento GovSaúde</h3>
        <p>Complete os módulos abaixo na ordem indicada. Marque cada passo ao praticar no sistema.</p>
    </div>
    <div class="tr-hero-badge">
        <div class="pct" id="heroPct">0%</div>
        <div class="lbl">concluído</div>
    </div>
</div>

{{-- Barra de progresso global --}}
<div class="tr-progress-wrap">
    <div class="tr-progress-label">
        <span id="progressLabel">0 de 7 módulos concluídos</span>
        <span id="progressSteps">0 passos</span>
    </div>
    <div class="tr-progress-bar">
        <div class="tr-progress-fill" id="progressFill" style="width:0%"></div>
    </div>
</div>

{{-- Módulos --}}
<div id="trModules">

@php
$modulos = [
    [
        'id'    => 'mod-1',
        'icon'  => 'bi-rocket-takeoff-fill',
        'color' => 'ic-blue',
        'title' => 'Primeiros Passos',
        'sub'   => 'Login, navegação e configuração inicial',
        'passos' => [
            ['t' => 'Acesse o sistema pelo navegador Chrome ou Edge',
             'd' => 'Outros navegadores funcionam, mas Chrome/Edge oferecem melhor experiência.'],
            ['t' => 'Digite seu e-mail e senha fornecidos pelo administrador',
             'd' => 'Caso seja seu primeiro acesso, troque a senha imediatamente após entrar.'],
            ['t' => 'Explore o menu lateral: identifique cada seção',
             'd' => 'Principal → Cadastros → Estoque → Relatórios. Clique em cada item para se familiarizar.'],
            ['t' => 'Clique no ícone de engrenagem (perfil) no rodapé do menu',
             'd' => 'Lá você altera seu nome e senha de acesso.'],
            ['t' => 'Altere sua senha padrão por uma senha pessoal segura',
             'd' => 'Use letras maiúsculas, minúsculas, números e símbolos. Mínimo 8 caracteres.'],
            ['t' => 'Veja o Dashboard e identifique os alertas de vencimento',
             'd' => 'Vermelho = lotes vencendo em 30 dias. Amarelo = 31–90 dias.'],
        ],
    ],
    [
        'id'    => 'mod-2',
        'icon'  => 'bi-people-fill',
        'color' => 'ic-violet',
        'title' => 'Cadastro de Pacientes',
        'sub'   => 'Registrar pacientes e representantes',
        'passos' => [
            ['t' => 'Acesse "Pacientes" no menu lateral',
             'd' => 'Aqui ficam todos os pacientes cadastrados na farmácia.'],
            ['t' => 'Clique em "Novo Paciente" e preencha nome completo e data de nascimento',
             'd' => 'Nome completo sem abreviações, conforme documento oficial.'],
            ['t' => 'Adicione CPF e Cartão Nacional de Saúde (CNS)',
             'd' => 'O CNS tem 15 dígitos. O sistema formata automaticamente ao digitar.'],
            ['t' => 'Salve e clique no nome do paciente para ver o perfil',
             'd' => 'No perfil você vê todos os processos e o histórico de dispensações.'],
            ['t' => 'Cadastre um representante: no perfil do paciente, clique em "Representantes"',
             'd' => 'Representante é quem retira o medicamento no lugar do paciente.'],
            ['t' => 'Preencha nome, CPF e parentesco do representante',
             'd' => 'O representante aparecerá como opção na hora de dispensar.'],
            ['t' => 'Pratique: cadastre um paciente fictício com dados de teste',
             'd' => 'Use um nome óbvio como "PACIENTE TESTE" para identificar facilmente.'],
        ],
    ],
    [
        'id'    => 'mod-3',
        'icon'  => 'bi-heart-pulse-fill',
        'color' => 'ic-rose',
        'title' => 'Médicos Prescritores',
        'sub'   => 'Cadastrar e gerenciar prescritores',
        'passos' => [
            ['t' => 'Acesse "Médicos" no menu lateral',
             'd' => 'Os médicos cadastrados aqui são vinculados aos processos.'],
            ['t' => 'Clique em "Novo Médico" e preencha nome completo',
             'd' => 'Use o nome conforme aparece na receita/prescrição.'],
            ['t' => 'Informe o CRM e o estado (ex: CRM 12345 SP)',
             'd' => 'O CRM é obrigatório para rastreabilidade das prescrições.'],
            ['t' => 'Adicione o estabelecimento de saúde onde atende',
             'd' => 'Ex: "Hospital Municipal", "UBS Centro". Facilita identificação futura.'],
            ['t' => 'Salve e confirme que aparece na lista de médicos',
             'd' => 'Cadastre os médicos que mais prescrevem para ter a lista completa.'],
        ],
    ],
    [
        'id'    => 'mod-4',
        'icon'  => 'bi-folder2-open',
        'color' => 'ic-cyan',
        'title' => 'Criando Processos APAC',
        'sub'   => 'O núcleo do sistema — gestão de processos',
        'passos' => [
            ['t' => 'Acesse "Processos" e clique em "Novo Processo"',
             'd' => 'O número do processo é gerado automaticamente pelo sistema.'],
            ['t' => 'Selecione o paciente (deve estar cadastrado previamente)',
             'd' => 'Digite as primeiras letras do nome para filtrar rapidamente.'],
            ['t' => 'Selecione o tipo: APAC Inicial, Continuidade ou Renovação',
             'd' => 'APAC Inicial: primeiro acesso ao medicamento. Continuidade: já estava recebendo.'],
            ['t' => 'Preencha o CID-10 (código do diagnóstico)',
             'd' => 'Digite o código (ex: G35) ou parte do nome da doença para buscar.'],
            ['t' => 'Selecione o médico prescritor e o tipo de receita',
             'd' => 'Receita Azul, Branca, Amarela, etc. conforme o medicamento.'],
            ['t' => 'Adicione o(s) medicamento(s) do processo com dose e posologia',
             'd' => 'Um processo pode ter mais de um medicamento.'],
            ['t' => 'Defina a validade da APAC (data de vencimento)',
             'd' => 'O sistema alertará automaticamente quando estiver vencendo.'],
            ['t' => 'Salve o processo e altere o status para "Em Andamento"',
             'd' => 'Processos "Em Andamento" aparecem no dashboard como ativos.'],
            ['t' => 'Pratique o botão "Renovar Processo" num processo existente',
             'd' => 'A renovação cria um novo processo copiando os dados do anterior.'],
        ],
    ],
    [
        'id'    => 'mod-5',
        'icon'  => 'bi-receipt',
        'color' => 'ic-green',
        'title' => 'Dispensação de Medicamentos',
        'sub'   => 'Realizar e registrar dispensações',
        'passos' => [
            ['t' => 'Abra um processo com status "Em Andamento"',
             'd' => 'Só é possível dispensar em processos em andamento.'],
            ['t' => 'Clique em "Nova Dispensação" dentro do processo',
             'd' => 'O botão fica na parte superior da tela do processo.'],
            ['t' => 'Selecione o medicamento a ser dispensado',
             'd' => 'Apenas medicamentos do processo aparecem na lista.'],
            ['t' => 'Selecione o lote correspondente do estoque',
             'd' => 'O sistema mostra o saldo disponível de cada lote.'],
            ['t' => 'Informe a quantidade dispensada e o mês de referência',
             'd' => 'Mês de referência é o mês ao qual a dispensação se refere.'],
            ['t' => 'Informe se está retirando o paciente ou um representante',
             'd' => 'Se representante, selecione qual na lista de representantes cadastrados.'],
            ['t' => 'Finalize a dispensação clicando em "Registrar"',
             'd' => 'O estoque é descontado automaticamente do lote selecionado.'],
            ['t' => 'Clique em "Imprimir Recibo" e salve ou imprima o PDF',
             'd' => 'O recibo tem a assinatura do farmacêutico e do paciente/representante.'],
            ['t' => 'Verifique o histórico do paciente no perfil dele',
             'd' => 'Todas as dispensações ficam registradas no histórico do paciente.'],
        ],
    ],
    [
        'id'    => 'mod-6',
        'icon'  => 'bi-box-seam-fill',
        'color' => 'ic-amber',
        'title' => 'Controle de Estoque',
        'sub'   => 'Gerenciar lotes e alertas de vencimento',
        'passos' => [
            ['t' => 'Acesse "Lotes" no menu lateral',
             'd' => 'Cada entrada de medicamento no estoque é um lote separado.'],
            ['t' => 'Clique em "Novo Lote" para cadastrar uma entrada de medicamento',
             'd' => 'Informe: medicamento, número do lote impresso na embalagem, validade e quantidade.'],
            ['t' => 'Preencha a data de validade corretamente (formato DD/MM/AAAA)',
             'd' => 'A validade é usada para os alertas automáticos no dashboard.'],
            ['t' => 'Salve o lote e verifique que aparece na lista com saldo correto',
             'd' => 'O saldo atual diminui automaticamente a cada dispensação.'],
            ['t' => 'Volte ao Dashboard e verifique os alertas de vencimento',
             'd' => 'Se cadastrou um lote com validade em menos de 30 dias, ele deve aparecer em vermelho.'],
            ['t' => 'Cadastre um lote com validade vencida para ver o alerta crítico',
             'd' => 'Lotes vencidos ficam bloqueados para dispensação.'],
            ['t' => 'Ative a notificação por e-mail: o sistema envia alertas toda segunda-feira',
             'd' => 'O e-mail vai para todos os administradores da farmácia cadastrados.'],
        ],
    ],
    [
        'id'    => 'mod-7',
        'icon'  => 'bi-bar-chart-line-fill',
        'color' => 'ic-indigo',
        'title' => 'Relatórios e Auditoria',
        'sub'   => 'Gerar relatórios e consultar o histórico',
        'passos' => [
            ['t' => 'Acesse "Relatórios" no menu lateral',
             'd' => 'Três tipos disponíveis: Dispensações, Estoque e Processos.'],
            ['t' => 'Selecione "Dispensações" e defina um período (data de/até)',
             'd' => 'Filtre por paciente ou medicamento para relatórios específicos.'],
            ['t' => 'Clique em "CSV" para exportar e abrir no Excel',
             'd' => 'O arquivo já vem com acentuação correta para Excel brasileiro.'],
            ['t' => 'Clique em "PDF" para gerar relatório formatado para impressão',
             'd' => 'Ideal para entregar para a Secretaria de Saúde ou auditoria.'],
            ['t' => 'Gere o relatório de Estoque para ver saldos e vencimentos',
             'd' => 'Use este relatório mensalmente para controle de inventário.'],
            ['t' => 'Acesse "Auditoria" e veja o histórico de todas as ações',
             'd' => 'Toda ação (criar, editar, dispensar, estornar) fica registrada com data e usuário.'],
            ['t' => 'Use os filtros de auditoria por usuário e período',
             'd' => 'Útil para investigar inconsistências ou auditorias internas.'],
        ],
    ],
];
@endphp

@foreach($modulos as $i => $mod)
<div class="tr-module" id="{{ $mod['id'] }}" data-total="{{ count($mod['passos']) }}">
    <div class="tr-module-header" onclick="trToggle('{{ $mod['id'] }}')">
        <div class="tr-module-icon {{ $mod['color'] }}">
            <i class="bi {{ $mod['icon'] }}"></i>
        </div>
        <div class="tr-module-meta">
            <div class="tr-module-title">
                <span class="me-2" style="color:#94a3b8;font-size:.8rem;font-weight:600">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                {{ $mod['title'] }}
            </div>
            <div class="tr-module-sub">{{ $mod['sub'] }}</div>
        </div>
        <div class="tr-module-right">
            <span class="tr-done-badge"><i class="bi bi-check-circle-fill"></i>Concluído</span>
            <div class="tr-mini-bar">
                <div class="tr-mini-fill" id="{{ $mod['id'] }}-bar" style="width:0%"></div>
            </div>
            <span class="tr-step-count" id="{{ $mod['id'] }}-count">0/{{ count($mod['passos']) }}</span>
            <i class="bi bi-chevron-down tr-chevron"></i>
        </div>
    </div>

    <div class="tr-steps">
        <div class="tr-module-action">
            <span style="font-size:.82rem;color:var(--muted)">Clique em cada passo ao concluí-lo na prática</span>
            <button class="tr-btn-reset" onclick="trReset('{{ $mod['id'] }}', event)">
                <i class="bi bi-arrow-counterclockwise me-1"></i>Reiniciar módulo
            </button>
        </div>
        @foreach($mod['passos'] as $j => $passo)
        <div class="tr-step" id="{{ $mod['id'] }}-step-{{ $j }}"
             onclick="trToggleStep('{{ $mod['id'] }}', {{ $j }})">
            <div class="tr-step-box"></div>
            <div class="tr-step-content">
                <div class="tr-step-title">{{ $passo['t'] }}</div>
                @if(!empty($passo['d']))
                <div class="tr-step-tip"><i class="bi bi-lightbulb me-1" style="color:#f59e0b"></i>{{ $passo['d'] }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach

</div>{{-- #trModules --}}

@push('scripts')
<script>
(function () {
    var KEY = 'gs_training_v1';

    /* Load state from localStorage */
    function loadState() {
        try { return JSON.parse(localStorage.getItem(KEY)) || {}; }
        catch(e) { return {}; }
    }
    function saveState(s) {
        localStorage.setItem(KEY, JSON.stringify(s));
    }

    var state = loadState();

    /* ── Toggle module open/close ── */
    window.trToggle = function (id) {
        var el = document.getElementById(id);
        el.classList.toggle('open');
    };

    /* ── Toggle individual step ── */
    window.trToggleStep = function (moduleId, stepIndex) {
        if (!state[moduleId]) state[moduleId] = [];
        var idx = state[moduleId].indexOf(stepIndex);
        if (idx === -1) {
            state[moduleId].push(stepIndex);
        } else {
            state[moduleId].splice(idx, 1);
        }
        saveState(state);
        renderModule(moduleId);
        renderGlobal();
    };

    /* ── Reset module ── */
    window.trReset = function (moduleId, evt) {
        evt.stopPropagation();
        if (!confirm('Reiniciar este módulo?')) return;
        state[moduleId] = [];
        saveState(state);
        renderModule(moduleId);
        renderGlobal();
    };

    /* ── Render one module ── */
    function renderModule(moduleId) {
        var el = document.getElementById(moduleId);
        if (!el) return;
        var total = parseInt(el.dataset.total);
        var done  = (state[moduleId] || []).length;
        var pct   = total ? Math.round(done / total * 100) : 0;

        /* mini bar */
        var bar = document.getElementById(moduleId + '-bar');
        if (bar) bar.style.width = pct + '%';

        /* count */
        var cnt = document.getElementById(moduleId + '-count');
        if (cnt) cnt.textContent = done + '/' + total;

        /* step checkboxes */
        for (var i = 0; i < total; i++) {
            var step = document.getElementById(moduleId + '-step-' + i);
            if (!step) continue;
            if ((state[moduleId] || []).indexOf(i) !== -1) {
                step.classList.add('checked');
            } else {
                step.classList.remove('checked');
            }
        }

        /* done state */
        if (done === total && total > 0) {
            el.classList.add('is-done');
        } else {
            el.classList.remove('is-done');
        }
    }

    /* ── Render global progress ── */
    function renderGlobal() {
        var mods = document.querySelectorAll('.tr-module');
        var totalSteps = 0, doneSteps = 0, doneModules = 0;
        mods.forEach(function (el) {
            var id    = el.id;
            var total = parseInt(el.dataset.total);
            var done  = (state[id] || []).length;
            totalSteps  += total;
            doneSteps   += done;
            if (done === total && total > 0) doneModules++;
        });
        var pct = totalSteps ? Math.round(doneSteps / totalSteps * 100) : 0;

        var fill  = document.getElementById('progressFill');
        var label = document.getElementById('progressLabel');
        var steps = document.getElementById('progressSteps');
        var hero  = document.getElementById('heroPct');

        if (fill)  fill.style.width = pct + '%';
        if (label) label.textContent = doneModules + ' de ' + mods.length + ' módulos concluídos';
        if (steps) steps.textContent = doneSteps + ' de ' + totalSteps + ' passos';
        if (hero)  hero.textContent  = pct + '%';

        /* Show completion banner */
        var banner = document.getElementById('trCompleteBanner');
        if (banner) {
            if (doneModules === mods.length && mods.length > 0) {
                banner.classList.add('show');
            } else {
                banner.classList.remove('show');
            }
        }
    }

    var SKIP_KEY = 'gs_training_skipped';

    function applySkipState() {
        var skipped = localStorage.getItem(SKIP_KEY) === '1';
        var content = document.getElementById('trModules');
        var hero    = document.querySelector('.tr-hero');
        var progWrap= document.querySelector('.tr-progress-wrap');
        var banner  = document.getElementById('trCompleteBanner');
        var skipBtn = document.getElementById('btnSkip');
        var skipState = document.getElementById('trSkippedState');

        if (skipped) {
            if (content)  content.style.display  = 'none';
            if (hero)     hero.style.display     = 'none';
            if (progWrap) progWrap.style.display = 'none';
            if (banner)   banner.style.display   = 'none';
            if (skipBtn)  skipBtn.style.display  = 'none';
            if (skipState)skipState.style.display = '';
        } else {
            if (content)  content.style.display  = '';
            if (hero)     hero.style.display     = '';
            if (progWrap) progWrap.style.display = '';
            if (skipBtn)  skipBtn.style.display  = '';
            if (skipState)skipState.style.display = 'none';
        }
    }

    window.trSkip = function () {
        if (!confirm('Ignorar o treinamento? Você pode retomá-lo a qualquer momento.')) return;
        localStorage.setItem(SKIP_KEY, '1');
        applySkipState();
    };

    window.trRestore = function () {
        localStorage.removeItem(SKIP_KEY);
        applySkipState();
    };

    /* ── Init: render all ── */
    document.addEventListener('DOMContentLoaded', function () {
        applySkipState();

        document.querySelectorAll('.tr-module').forEach(function (el) {
            renderModule(el.id);
        });
        renderGlobal();

        /* Auto-open first incomplete module */
        var mods = document.querySelectorAll('.tr-module');
        for (var i = 0; i < mods.length; i++) {
            if (!mods[i].classList.contains('is-done')) {
                mods[i].classList.add('open');
                break;
            }
        }
    });
})();
</script>
@endpush

</x-app-layout>
