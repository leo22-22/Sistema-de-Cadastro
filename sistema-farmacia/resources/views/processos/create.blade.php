<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-folder-plus me-2"></i>Novo Processo</h4>
    <a href="{{ route('processos.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('processos.store') }}" method="POST" id="formProcesso">
@csrf
<div class="row g-4">

    {{-- COLUNA PRINCIPAL --}}
    <div class="col-lg-8">

        {{-- Tipo e Paciente --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Identificação do Processo</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tipo de Processo *</label>
                    <select name="tipo_processo" class="form-select @error('tipo_processo') is-invalid @enderror" required>
                        @foreach($tiposProcesso as $val => $label)
                        <option value="{{ $val }}" {{ old('tipo_processo','abertura') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tipo_processo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Paciente *</label>
                    <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required id="sel-paciente">
                        <option value="">Selecione o paciente...</option>
                        @foreach($pacientes as $p)
                        <option value="{{ $p->id }}" data-nome="{{ $p->nome }}" data-mae="{{ $p->nome_mae }}" data-dn="{{ $p->data_nascimento?->format('d/m/Y') }}" data-peso="{{ $p->peso }}" data-altura="{{ $p->altura }}"
                            {{ old('paciente_id', request('paciente_id')) == $p->id ? 'selected' : '' }}>
                            {{ $p->nome }}{{ $p->cpf ? ' — ' . $p->cpf : '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Painel de info do paciente --}}
                <div class="col-12" id="painel-paciente" style="display:none">
                    <div class="alert alert-info py-2 mb-0 small">
                        <strong id="info-nome"></strong> — Mãe: <span id="info-mae">—</span> — DN: <span id="info-dn">—</span>
                        — Peso: <span id="info-peso">—</span> kg — Altura: <span id="info-altura">—</span> cm
                    </div>
                </div>
            </div>
        </div>

        {{-- CID-10 / Doença --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Diagnóstico (CID-10) *</h6>
            <div class="row g-3">
                <div class="col-12">
                    <input type="text" id="busca-cid" class="form-control mb-2"
                           placeholder="Buscar por código ou nome da doença (ex: J45, Asma)...">
                    <select name="cid10_id" id="sel-cid" class="form-select @error('cid10_id') is-invalid @enderror" size="5" required>
                        <option value="">Selecione o CID-10...</option>
                        @foreach($cids as $cid)
                        <option value="{{ $cid->id }}" data-busca="{{ strtolower($cid->codigo . ' ' . $cid->nome) }}"
                            {{ old('cid10_id') == $cid->id ? 'selected' : '' }}>
                            {{ $cid->codigo }} — {{ $cid->nome }}
                        </option>
                        @endforeach
                    </select>
                    @error('cid10_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Médico Prescritor --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Médico Prescritor</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Médico</label>
                    <div class="input-group">
                        <select name="medico_prescritor_id" class="form-select" id="sel-medico">
                            <option value="">— Selecione ou cadastre —</option>
                            @foreach($medicos as $m)
                            <option value="{{ $m->id }}" {{ old('medico_prescritor_id') == $m->id ? 'selected' : '' }}
                                data-crm="{{ $m->crm }}" data-cns="{{ $m->cns }}" data-cnes="{{ $m->cnes }}"
                                data-estab="{{ $m->estabelecimento }}" data-esp="{{ $m->especialidade }}"
                                data-tel="{{ $m->telefone }}" data-cidade="{{ $m->cidade }}">
                                {{ $m->nome }}{{ $m->crm ? ' — CRM ' . $m->crm : '' }}
                            </option>
                            @endforeach
                        </select>
                        <a href="{{ route('medicos-prescritores.create') }}" target="_blank"
                           class="btn btn-outline-secondary" title="Cadastrar novo médico">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>
                </div>
                <div id="info-medico" class="col-12" style="display:none">
                    <div class="bg-light rounded p-2 small">
                        <span class="me-3"><strong>CRM:</strong> <span id="m-crm">—</span></span>
                        <span class="me-3"><strong>CNS:</strong> <span id="m-cns">—</span></span>
                        <span class="me-3"><strong>CNES:</strong> <span id="m-cnes">—</span></span>
                        <span class="me-3"><strong>Especialidade:</strong> <span id="m-esp">—</span></span>
                        <br class="mt-1">
                        <span class="me-3"><strong>Estabelecimento:</strong> <span id="m-estab">—</span></span>
                        <span class="me-3"><strong>Tel:</strong> <span id="m-tel">—</span></span>
                        <span><strong>Cidade:</strong> <span id="m-cidade">—</span></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Receita --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados da Receita</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo de Receita</label>
                    <select name="tipo_receita_id" class="form-select">
                        <option value="">— Selecione —</option>
                        @foreach($tiposReceita as $tr)
                        <option value="{{ $tr->id }}" {{ old('tipo_receita_id') == $tr->id ? 'selected' : '' }}>
                            {{ $tr->nome }}{{ $tr->requer_retencao ? ' ✓ retenção' : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo de Remessa</label>
                    <select name="tipo_relacao_remessa_id" class="form-select">
                        <option value="">— Selecione —</option>
                        @foreach($tiposRemessa as $tr)
                        <option value="{{ $tr->id }}" {{ old('tipo_relacao_remessa_id') == $tr->id ? 'selected' : '' }}>{{ $tr->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nº da Receita</label>
                    <input type="text" name="numero_receita" class="form-control" value="{{ old('numero_receita') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data da Receita</label>
                    <input type="date" name="data_receita" class="form-control" value="{{ old('data_receita') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Validade da Receita</label>
                    <input type="date" name="data_validade_receita" class="form-control @error('data_validade_receita') is-invalid @enderror"
                           value="{{ old('data_validade_receita') }}">
                    @error('data_validade_receita')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Documentos entregues --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Documentos Entregues</h6>
            <div class="row g-2">
                <div class="col-sm-6 col-md-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="lme_entregue" id="lme_entregue" value="1"
                               {{ old('lme_entregue') ? 'checked' : '' }}>
                        <label class="form-check-label" for="lme_entregue"><i class="bi bi-file-medical text-primary me-1"></i>LME</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="receita_entregue" id="receita_entregue" value="1"
                               {{ old('receita_entregue') ? 'checked' : '' }}>
                        <label class="form-check-label" for="receita_entregue"><i class="bi bi-file-text text-success me-1"></i>Receita</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="exame_entregue" id="exame_entregue" value="1"
                               {{ old('exame_entregue') ? 'checked' : '' }}>
                        <label class="form-check-label" for="exame_entregue"><i class="bi bi-clipboard-pulse text-warning me-1"></i>Exames</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="documentos_entregues" id="documentos_entregues" value="1"
                               {{ old('documentos_entregues') ? 'checked' : '' }}>
                        <label class="form-check-label" for="documentos_entregues"><i class="bi bi-person-vcard text-secondary me-1"></i>Docs Pessoais</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Observações --}}
        <div class="card p-4">
            <h6 class="section-title">Observações</h6>
            <textarea name="observacoes" class="form-control" rows="3">{{ old('observacoes') }}</textarea>
        </div>
    </div>

    {{-- COLUNA DIREITA: Medicamentos --}}
    <div class="col-lg-4">
        <div class="card p-4 sticky-top" style="top:80px">
            <h6 class="section-title">
                Medicamentos * <span class="text-danger">(mín. 1)</span>
            </h6>

            @error('medicamentos')
            <div class="alert alert-danger p-2 small">{{ $message }}</div>
            @enderror

            <div id="medicamentos-list"></div>

            <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2" id="btn-add-med">
                <i class="bi bi-plus-lg me-1"></i>Adicionar Medicamento
            </button>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Abrir Processo</button>
    <a href="{{ route('processos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>
.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:.75rem; }
#sel-cid { border-radius:8px; font-size:.875rem; }
.med-card { background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:10px; padding:12px; margin-bottom:8px; }
</style>
@endpush

@php
$medicamentosJson = $medicamentos->map(function ($m) {
    return [
        'id'            => $m->id,
        'nome'          => $m->nome,
        'dosagem'       => $m->dosagem,
        'forma'         => $m->forma_label,
        'periodicidade' => $m->periodicidade,
        'qtd_diaria'    => $m->quantidade_diaria,
    ];
})->values();
@endphp

@push('scripts')
<script>
const medicamentosData = @json($medicamentosJson);

let medIndex = 0;

function criarMedItem(idx, data = null) {
    const div = document.createElement('div');
    div.className = 'med-card';
    div.dataset.index = idx;

    let opts = '<option value="">Selecione o medicamento...</option>';
    medicamentosData.forEach(m => {
        opts += `<option value="${m.id}" data-dosagem="${m.dosagem||''}" data-forma="${m.forma||''}" data-per="${m.periodicidade||'mensal'}" data-qtd="${m.qtd_diaria||''}">${m.nome}${m.dosagem ? ' — ' + m.dosagem : ''}${m.forma ? ' (' + m.forma + ')' : ''}</option>`;
    });

    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-primary" style="font-size:.7rem">Medicamento ${idx+1}</span>
            <button type="button" class="btn btn-sm btn-outline-danger btn-rem"><i class="bi bi-x"></i></button>
        </div>
        <select name="medicamentos[${idx}][id]" class="form-select form-select-sm mb-2 sel-med" required>${opts}</select>
        <div class="row g-1 mb-1">
            <div class="col-6">
                <label class="form-label form-label-sm mb-0 text-muted">Periodicidade</label>
                <select name="medicamentos[${idx}][periodicidade]" class="form-select form-select-sm">
                    <option value="mensal">Mensal</option>
                    <option value="bimestral">Bimestral</option>
                    <option value="trimestral">Trimestral</option>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label form-label-sm mb-0 text-muted">Qtd/dia</label>
                <input type="number" name="medicamentos[${idx}][quantidade_diaria]" class="form-control form-control-sm" step="0.1" min="0.1" placeholder="—">
            </div>
            <div class="col-3">
                <label class="form-label form-label-sm mb-0 text-muted">Qtd/mês</label>
                <input type="number" name="medicamentos[${idx}][quantidade_mensal]" class="form-control form-control-sm" min="1" placeholder="—">
            </div>
        </div>
        <input type="text" name="medicamentos[${idx}][posologia]" class="form-control form-control-sm mb-1" placeholder="Posologia (ex: 1 comp. ao dia)">
        <input type="text" name="medicamentos[${idx}][observacoes]" class="form-control form-control-sm" placeholder="Observação">
    `;

    // Auto-fill periodicidade e qtd_diaria ao selecionar medicamento
    div.querySelector('.sel-med').addEventListener('change', function() {
        const opt = this.selectedOptions[0];
        const per   = div.querySelector(`select[name="medicamentos[${idx}][periodicidade]"]`);
        const qtdD  = div.querySelector(`input[name="medicamentos[${idx}][quantidade_diaria]"]`);
        if (opt.dataset.per) per.value = opt.dataset.per;
        if (opt.dataset.qtd) qtdD.value = opt.dataset.qtd;
    });

    div.querySelector('.btn-rem').addEventListener('click', () => {
        div.remove();
        atualizarBadges();
    });

    return div;
}

function atualizarBadges() {
    document.querySelectorAll('.med-card').forEach((el, i) => {
        el.querySelector('.badge').textContent = `Medicamento ${i + 1}`;
    });
}

document.getElementById('btn-add-med').addEventListener('click', () => {
    document.getElementById('medicamentos-list').appendChild(criarMedItem(medIndex++));
});

// Inicia com 1 medicamento
document.getElementById('medicamentos-list').appendChild(criarMedItem(medIndex++));

// Info do paciente
document.getElementById('sel-paciente').addEventListener('change', function() {
    const opt = this.selectedOptions[0];
    if (!opt.value) { document.getElementById('painel-paciente').style.display='none'; return; }
    document.getElementById('info-nome').textContent   = opt.dataset.nome || '';
    document.getElementById('info-mae').textContent    = opt.dataset.mae  || '—';
    document.getElementById('info-dn').textContent     = opt.dataset.dn   || '—';
    document.getElementById('info-peso').textContent   = opt.dataset.peso || '—';
    document.getElementById('info-altura').textContent = opt.dataset.altura|| '—';
    document.getElementById('painel-paciente').style.display = '';
});
// Trigger if pre-selected
if (document.getElementById('sel-paciente').value)
    document.getElementById('sel-paciente').dispatchEvent(new Event('change'));

// Info do médico
document.getElementById('sel-medico').addEventListener('change', function() {
    const opt = this.selectedOptions[0];
    if (!opt.value) { document.getElementById('info-medico').style.display='none'; return; }
    ['crm','cns','cnes','esp','estab','tel','cidade'].forEach(k => {
        document.getElementById('m-'+k).textContent = opt.dataset[k] || '—';
    });
    document.getElementById('info-medico').style.display = '';
});

// Filtro CID-10
document.getElementById('busca-cid').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#sel-cid option[data-busca]').forEach(opt => {
        opt.hidden = q && !opt.dataset.busca.includes(q);
    });
});
</script>
@endpush
</x-app-layout>
