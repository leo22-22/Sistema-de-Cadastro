<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-pencil me-2"></i>Editar Processo {{ $processo->numero }}</h4>
    <a href="{{ route('processos.show', $processo) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('processos.update', $processo) }}" method="POST" id="formProcesso">
@csrf @method('PATCH')
<div class="row g-4">

    {{-- Coluna principal --}}
    <div class="col-lg-8">

        {{-- Tipo e Paciente --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Identificação</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Tipo de Processo *</label>
                    <select name="tipo_processo" class="form-select @error('tipo_processo') is-invalid @enderror" required>
                        @foreach($tiposProcesso as $val => $label)
                        <option value="{{ $val }}" {{ old('tipo_processo', $processo->tipo_processo) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('tipo_processo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Paciente *</label>
                    <select name="paciente_id" class="form-select @error('paciente_id') is-invalid @enderror" required id="select-paciente">
                        <option value="">Selecionar paciente...</option>
                        @foreach($pacientes as $p)
                        <option value="{{ $p->id }}"
                            data-nome="{{ $p->nome }}"
                            data-mae="{{ $p->nome_mae }}"
                            data-dn="{{ $p->data_nascimento?->format('d/m/Y') }}"
                            data-idade="{{ $p->idade }}"
                            data-peso="{{ $p->peso }}"
                            data-altura="{{ $p->altura }}"
                            {{ old('paciente_id', $processo->paciente_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->nome }}{{ $p->cpf ? ' — ' . $p->cpf : '' }}
                        </option>
                        @endforeach
                    </select>
                    @error('paciente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Info do paciente --}}
            <div id="info-paciente" class="mt-3 p-3 bg-light rounded small {{ old('paciente_id', $processo->paciente_id) ? '' : 'd-none' }}">
                <div class="row g-1">
                    <div class="col-md-6"><span class="text-muted">Nome da Mãe:</span> <span id="pac-mae">{{ $processo->paciente->nome_mae ?? '—' }}</span></div>
                    <div class="col-md-3"><span class="text-muted">DN:</span> <span id="pac-dn">{{ $processo->paciente->data_nascimento?->format('d/m/Y') ?? '—' }}</span>
                        <span class="text-muted" id="pac-idade">{{ $processo->paciente->idade ? '(' . $processo->paciente->idade . ' anos)' : '' }}</span></div>
                    <div class="col-md-3"><span class="text-muted">Peso:</span> <span id="pac-peso">{{ $processo->paciente->peso ?? '—' }}</span> kg
                        | <span class="text-muted">Altura:</span> <span id="pac-altura">{{ $processo->paciente->altura ?? '—' }}</span> cm</div>
                </div>
            </div>
        </div>

        {{-- CID-10 e Médico --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Patologia e Prescritor</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">CID-10 *</label>
                    <input type="text" id="cid-search" class="form-control form-control-sm mb-1"
                           placeholder="Filtrar por código ou nome..."
                           value="{{ $processo->cid10 ? $processo->cid10->codigo . ' — ' . $processo->cid10->nome : '' }}">
                    <select name="cid10_id" id="select-cid" class="form-select @error('cid10_id') is-invalid @enderror" required size="4">
                        @foreach($cids as $cid)
                        <option value="{{ $cid->id }}" data-text="{{ $cid->codigo }} {{ $cid->nome }}"
                            {{ old('cid10_id', $processo->cid10_id) == $cid->id ? 'selected' : '' }}>
                            {{ $cid->codigo }} — {{ $cid->nome }}
                        </option>
                        @endforeach
                    </select>
                    @error('cid10_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Médico Prescritor</label>
                    <select name="medico_prescritor_id" class="form-select @error('medico_prescritor_id') is-invalid @enderror" id="select-medico">
                        <option value="">— Nenhum —</option>
                        @foreach($medicos as $m)
                        <option value="{{ $m->id }}"
                            data-crm="{{ $m->crm }}" data-cns="{{ $m->cns }}"
                            data-cnes="{{ $m->cnes }}" data-estab="{{ $m->estabelecimento }}"
                            data-esp="{{ $m->especialidade }}"
                            {{ old('medico_prescritor_id', $processo->medico_prescritor_id) == $m->id ? 'selected' : '' }}>
                            {{ $m->nome }}{{ $m->crm ? ' (CRM: ' . $m->crm . ')' : '' }}
                        </option>
                        @endforeach
                    </select>
                    <div id="info-medico" class="mt-2 small text-muted {{ old('medico_prescritor_id', $processo->medico_prescritor_id) ? '' : 'd-none' }}">
                        <span id="med-crm">{{ $processo->medicoPrescritor?->crm ? 'CRM: ' . $processo->medicoPrescritor->crm : '' }}</span>
                        <span id="med-cnes">{{ $processo->medicoPrescritor?->cnes ? ' | CNES: ' . $processo->medicoPrescritor->cnes : '' }}</span><br>
                        <span id="med-estab">{{ $processo->medicoPrescritor?->estabelecimento ?? '' }}</span>
                        <span id="med-esp">{{ $processo->medicoPrescritor?->especialidade ? ' — ' . $processo->medicoPrescritor->especialidade : '' }}</span>
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
                        <option value="">— Nenhum —</option>
                        @foreach($tiposReceita as $tr)
                        <option value="{{ $tr->id }}" {{ old('tipo_receita_id', $processo->tipo_receita_id) == $tr->id ? 'selected' : '' }}>
                            {{ $tr->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo de Remessa</label>
                    <select name="tipo_relacao_remessa_id" class="form-select">
                        <option value="">— Nenhum —</option>
                        @foreach($tiposRemessa as $tr)
                        <option value="{{ $tr->id }}" {{ old('tipo_relacao_remessa_id', $processo->tipo_relacao_remessa_id) == $tr->id ? 'selected' : '' }}>
                            {{ $tr->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nº da Receita</label>
                    <input type="text" name="numero_receita" class="form-control"
                           value="{{ old('numero_receita', $processo->numero_receita) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data da Receita</label>
                    <input type="date" name="data_receita" class="form-control"
                           value="{{ old('data_receita', $processo->data_receita?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Validade da Receita</label>
                    <input type="date" name="data_validade_receita" class="form-control @error('data_validade_receita') is-invalid @enderror"
                           value="{{ old('data_validade_receita', $processo->data_validade_receita?->format('Y-m-d')) }}">
                    @error('data_validade_receita')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">1ª Retirada</label>
                    <input type="date" name="data_primeira_retirada" class="form-control"
                           value="{{ old('data_primeira_retirada', $processo->data_primeira_retirada?->format('Y-m-d')) }}">
                </div>
            </div>
        </div>

        {{-- Documentos --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Documentos Entregues</h6>
            <div class="row g-2">
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="lme_entregue" value="1" id="lme"
                               {{ old('lme_entregue', $processo->lme_entregue) ? 'checked' : '' }}>
                        <label class="form-check-label" for="lme">LME</label>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="receita_entregue" value="1" id="receita"
                               {{ old('receita_entregue', $processo->receita_entregue) ? 'checked' : '' }}>
                        <label class="form-check-label" for="receita">Receita</label>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="exame_entregue" value="1" id="exame"
                               {{ old('exame_entregue', $processo->exame_entregue) ? 'checked' : '' }}>
                        <label class="form-check-label" for="exame">Exame</label>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="documentos_entregues" value="1" id="docs"
                               {{ old('documentos_entregues', $processo->documentos_entregues) ? 'checked' : '' }}>
                        <label class="form-check-label" for="docs">Docs Pessoais</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h6 class="section-title">Observações</h6>
            <textarea name="observacoes" class="form-control" rows="3">{{ old('observacoes', $processo->observacoes) }}</textarea>
        </div>
    </div>

    {{-- Coluna medicamentos --}}
    <div class="col-lg-4">
        <div class="card p-4 sticky-top" style="top:80px">
            <h6 class="section-title">Medicamentos *</h6>
            @error('medicamentos')
            <div class="alert alert-danger p-2 small">{{ $message }}</div>
            @enderror

            <div id="medicamentos-list">
                @foreach($processo->medicamentos as $idx => $med)
                <div class="medicamento-item border rounded p-3 mb-2" data-index="{{ $idx }}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-primary small">Medicamento {{ $idx + 1 }}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remover-med"
                                {{ $processo->medicamentos->count() <= 1 ? 'style=display:none' : '' }}>
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <select name="medicamentos[{{ $idx }}][id]" class="form-select form-select-sm mb-2 select-med" required>
                        <option value="">Selecione...</option>
                        @foreach($medicamentos as $m)
                        <option value="{{ $m->id }}"
                            data-periodicidade="{{ $m->periodicidade }}"
                            data-qtd-diaria="{{ $m->quantidade_diaria }}"
                            {{ $med->id == $m->id ? 'selected' : '' }}>
                            {{ $m->nome }}{{ $m->dosagem ? ' ' . $m->dosagem : '' }}
                        </option>
                        @endforeach
                    </select>
                    <div class="row g-1 mb-1">
                        <div class="col-6">
                            <label class="form-label form-label-sm text-muted mb-0">Periodicidade</label>
                            <select name="medicamentos[{{ $idx }}][periodicidade]" class="form-select form-select-sm" required>
                                <option value="mensal" {{ $med->pivot->periodicidade === 'mensal' ? 'selected' : '' }}>Mensal</option>
                                <option value="bimestral" {{ $med->pivot->periodicidade === 'bimestral' ? 'selected' : '' }}>Bimestral</option>
                                <option value="trimestral" {{ $med->pivot->periodicidade === 'trimestral' ? 'selected' : '' }}>Trimestral</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label class="form-label form-label-sm text-muted mb-0">Qtd/Dia</label>
                            <input type="number" name="medicamentos[{{ $idx }}][quantidade_diaria]" class="form-control form-control-sm"
                                   step="0.5" min="0.5" value="{{ $med->pivot->quantidade_diaria }}">
                        </div>
                        <div class="col-3">
                            <label class="form-label form-label-sm text-muted mb-0">Qtd Mensal</label>
                            <input type="number" name="medicamentos[{{ $idx }}][quantidade_mensal]" class="form-control form-control-sm"
                                   min="1" value="{{ $med->pivot->quantidade_mensal }}">
                        </div>
                    </div>
                    <input type="text" name="medicamentos[{{ $idx }}][posologia]" class="form-control form-control-sm mb-1"
                           placeholder="Posologia" value="{{ $med->pivot->posologia }}">
                    <input type="text" name="medicamentos[{{ $idx }}][observacoes]" class="form-control form-control-sm"
                           placeholder="Observações" value="{{ $med->pivot->observacoes }}">
                </div>
                @endforeach
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm w-100 mt-2" id="btn-add-med">
                <i class="bi bi-plus-lg me-1"></i>Adicionar Medicamento
            </button>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Alterações</button>
    <a href="{{ route('processos.show', $processo) }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:.75rem; }</style>
@endpush

@php
$medsJson = $medicamentos->map(function ($m) {
    return [
        'id'            => $m->id,
        'text'          => $m->nome . ($m->dosagem ? ' ' . $m->dosagem : ''),
        'periodicidade' => $m->periodicidade,
        'qtd_diaria'    => $m->quantidade_diaria,
    ];
})->values();
@endphp

@push('scripts')
<script>
let medIndex = {{ $processo->medicamentos->count() }};
const medsData = @json($medsJson);

// CID-10 filter
document.getElementById('cid-search').addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#select-cid option').forEach(opt => {
        opt.style.display = opt.dataset.text.toLowerCase().includes(q) ? '' : 'none';
    });
});

// Paciente info
document.getElementById('select-paciente').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (!opt.value) { document.getElementById('info-paciente').classList.add('d-none'); return; }
    document.getElementById('pac-mae').textContent = opt.dataset.mae || '—';
    document.getElementById('pac-dn').textContent = opt.dataset.dn || '—';
    document.getElementById('pac-idade').textContent = opt.dataset.idade ? '(' + opt.dataset.idade + ' anos)' : '';
    document.getElementById('pac-peso').textContent = opt.dataset.peso || '—';
    document.getElementById('pac-altura').textContent = opt.dataset.altura || '—';
    document.getElementById('info-paciente').classList.remove('d-none');
});

// Médico info
document.getElementById('select-medico').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const info = document.getElementById('info-medico');
    if (!opt.value) { info.classList.add('d-none'); return; }
    document.getElementById('med-crm').textContent = opt.dataset.crm ? 'CRM: ' + opt.dataset.crm : '';
    document.getElementById('med-cnes').textContent = opt.dataset.cnes ? ' | CNES: ' + opt.dataset.cnes : '';
    document.getElementById('med-estab').textContent = opt.dataset.estab || '';
    document.getElementById('med-esp').textContent = opt.dataset.esp ? ' — ' + opt.dataset.esp : '';
    info.classList.remove('d-none');
});

// Select-med auto fill
document.getElementById('medicamentos-list').addEventListener('change', function(e) {
    if (!e.target.classList.contains('select-med')) return;
    const item = e.target.closest('.medicamento-item');
    const med = medsData.find(m => m.id == e.target.value);
    if (med) {
        const perSelect = item.querySelector('select[name*=periodicidade]');
        const qtdDiaria = item.querySelector('input[name*=quantidade_diaria]');
        if (med.periodicidade) perSelect.value = med.periodicidade;
        if (med.qtd_diaria) qtdDiaria.value = med.qtd_diaria;
    }
});

function criarMedCard(idx) {
    let opts = '<option value="">Selecione...</option>';
    medsData.forEach(m => opts += `<option value="${m.id}" data-periodicidade="${m.periodicidade||''}" data-qtd-diaria="${m.qtd_diaria||''}">${m.text}</option>`);

    const div = document.createElement('div');
    div.className = 'medicamento-item border rounded p-3 mb-2';
    div.dataset.index = idx;
    div.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="badge bg-primary small">Medicamento ${idx + 1}</span>
            <button type="button" class="btn btn-sm btn-outline-danger btn-remover-med"><i class="bi bi-x"></i></button>
        </div>
        <select name="medicamentos[${idx}][id]" class="form-select form-select-sm mb-2 select-med" required>${opts}</select>
        <div class="row g-1 mb-1">
            <div class="col-6">
                <label class="form-label form-label-sm text-muted mb-0">Periodicidade</label>
                <select name="medicamentos[${idx}][periodicidade]" class="form-select form-select-sm" required>
                    <option value="mensal">Mensal</option>
                    <option value="bimestral">Bimestral</option>
                    <option value="trimestral">Trimestral</option>
                </select>
            </div>
            <div class="col-3">
                <label class="form-label form-label-sm text-muted mb-0">Qtd/Dia</label>
                <input type="number" name="medicamentos[${idx}][quantidade_diaria]" class="form-control form-control-sm" step="0.5" min="0.5">
            </div>
            <div class="col-3">
                <label class="form-label form-label-sm text-muted mb-0">Qtd Mensal</label>
                <input type="number" name="medicamentos[${idx}][quantidade_mensal]" class="form-control form-control-sm" min="1">
            </div>
        </div>
        <input type="text" name="medicamentos[${idx}][posologia]" class="form-control form-control-sm mb-1" placeholder="Posologia">
        <input type="text" name="medicamentos[${idx}][observacoes]" class="form-control form-control-sm" placeholder="Observações">
    `;
    return div;
}

document.getElementById('btn-add-med').addEventListener('click', function() {
    document.getElementById('medicamentos-list').appendChild(criarMedCard(medIndex++));
    atualizarBotoes();
});

document.getElementById('medicamentos-list').addEventListener('click', function(e) {
    if (e.target.closest('.btn-remover-med')) {
        e.target.closest('.medicamento-item').remove();
        atualizarBotoes();
    }
});

function atualizarBotoes() {
    const items = document.querySelectorAll('.medicamento-item');
    items.forEach(i => i.querySelector('.btn-remover-med').style.display = items.length > 1 ? '' : 'none');
}
</script>
@endpush
</x-app-layout>
