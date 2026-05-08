<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-capsule me-2"></i>Dispensar Medicamento</h4>
        <span class="text-muted small">Processo {{ $processo->numero }} — {{ $processo->paciente->nome }}</span>
    </div>
    <a href="{{ route('processos.show', $processo) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<div class="row g-4">
    {{-- Formulário --}}
    <div class="col-lg-7">
        <form action="{{ route('recibos.store', $processo) }}" method="POST">
        @csrf

        <div class="card p-4 mb-3">
            <h6 class="section-title">Medicamento a Dispensar</h6>
            <div class="mb-3">
                <label class="form-label fw-semibold">Medicamento *</label>
                <select name="medicamento_id" class="form-select @error('medicamento_id') is-invalid @enderror"
                        required id="select-medicamento">
                    <option value="">Selecionar medicamento do processo...</option>
                    @foreach($processo->medicamentos as $med)
                    <option value="{{ $med->id }}"
                        data-periodicidade="{{ $med->pivot->periodicidade }}"
                        data-qtd-mensal="{{ $med->pivot->quantidade_mensal }}"
                        data-posologia="{{ $med->pivot->posologia }}"
                        {{ old('medicamento_id') == $med->id ? 'selected' : '' }}>
                        {{ $med->nome }}{{ $med->dosagem ? ' — ' . $med->dosagem : '' }}
                        ({{ ucfirst($med->pivot->periodicidade) }}, {{ $med->pivot->quantidade_mensal }} unidades/mês)
                    </option>
                    @endforeach
                </select>
                @error('medicamento_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Lote (estoque)</label>
                    <select name="lote_id" class="form-select @error('lote_id') is-invalid @enderror" id="select-lote">
                        <option value="">Sem controle de lote</option>
                        @foreach($lotes->collapse() as $lote)
                        <option value="{{ $lote->id }}"
                            data-med="{{ $lote->medicamento_id }}"
                            data-disponivel="{{ $lote->quantidade_atual }}"
                            {{ old('lote_id') == $lote->id ? 'selected' : '' }}>
                            {{ $lote->medicamento->nome }} — Lote {{ $lote->lote }}
                            ({{ $lote->quantidade_atual }} disp., val. {{ $lote->validade->format('d/m/Y') }})
                        </option>
                        @endforeach
                    </select>
                    @error('lote_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div id="estoque-info" class="form-text"></div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Quantidade *</label>
                    <input type="number" name="quantidade" class="form-control @error('quantidade') is-invalid @enderror"
                           id="input-quantidade" value="{{ old('quantidade', 1) }}" min="1" required>
                    @error('quantidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Mês de Referência *</label>
                    <input type="month" name="mes_referencia" class="form-control @error('mes_referencia') is-invalid @enderror"
                           value="{{ old('mes_referencia', now()->format('Y-m')) }}" required>
                    @error('mes_referencia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h6 class="section-title">Quem Retira</h6>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="retirado_por_representante" value="1"
                       id="check-rep" {{ old('retirado_por_representante') ? 'checked' : '' }}
                       onchange="toggleRepresentante(this)">
                <label class="form-check-label fw-semibold" for="check-rep">Retirado por representante</label>
            </div>
            <div id="div-representante" class="{{ old('retirado_por_representante') ? '' : 'd-none' }}">
                <label class="form-label fw-semibold">Representante</label>
                <select name="representante_id" class="form-select @error('representante_id') is-invalid @enderror">
                    <option value="">— Selecionar —</option>
                    @foreach($processo->paciente->representantes as $rep)
                    <option value="{{ $rep->id }}" {{ old('representante_id') == $rep->id ? 'selected' : '' }}>
                        {{ $rep->nome }}{{ $rep->cpf ? ' (CPF: ' . $rep->cpf . ')' : '' }}
                    </option>
                    @endforeach
                </select>
                @error('representante_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h6 class="section-title">Observações</h6>
            <textarea name="observacoes" class="form-control" rows="2"
                      placeholder="Observações sobre esta dispensação...">{{ old('observacoes') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-receipt me-1"></i>Registrar Dispensação
        </button>
        </form>
    </div>

    {{-- Painel informativo --}}
    <div class="col-lg-5">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados do Processo</h6>
            <dl class="row small mb-0">
                <dt class="col-5 text-muted">Paciente</dt>
                <dd class="col-7 fw-semibold">{{ $processo->paciente->nome }}</dd>
                @if($processo->paciente->nome_mae)
                <dt class="col-5 text-muted">Nome da Mãe</dt>
                <dd class="col-7">{{ $processo->paciente->nome_mae }}</dd>
                @endif
                @if($processo->paciente->data_nascimento)
                <dt class="col-5 text-muted">Data Nasc.</dt>
                <dd class="col-7">{{ $processo->paciente->data_nascimento->format('d/m/Y') }}</dd>
                @endif
                @if($processo->paciente->cns)
                <dt class="col-5 text-muted">CNS</dt>
                <dd class="col-7">{{ $processo->paciente->cns }}</dd>
                @endif
                @if($processo->cid10)
                <dt class="col-5 text-muted">CID-10</dt>
                <dd class="col-7"><span class="badge bg-dark">{{ $processo->cid10->codigo }}</span> {{ $processo->cid10->nome }}</dd>
                @endif
                @if($processo->medicoPrescritor)
                <dt class="col-5 text-muted">Médico</dt>
                <dd class="col-7">{{ $processo->medicoPrescritor->nome }}{{ $processo->medicoPrescritor->crm ? ' (CRM: ' . $processo->medicoPrescritor->crm . ')' : '' }}</dd>
                @endif
                <dt class="col-5 text-muted">Validade APAC</dt>
                <dd class="col-7">
                    @if($processo->validade_apac)
                        <span class="{{ $processo->validade_apac->isPast() ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                            {{ $processo->validade_apac->format('d/m/Y') }}
                        </span>
                    @else
                        <span class="text-muted">Será calculada na 1ª dispensação</span>
                    @endif
                </dd>
            </dl>
        </div>

        @if($processo->paciente->representantes->count())
        <div class="card p-4 mb-3">
            <h6 class="section-title">Declaração Autorizadora</h6>
            @foreach($processo->paciente->representantes as $rep)
            <div class="d-flex align-items-start gap-2 mb-2">
                <span class="badge bg-secondary" style="font-size:.65rem;min-width:22px">{{ $loop->iteration }}º</span>
                <div>
                    <div class="fw-semibold small">{{ $rep->nome }}</div>
                    @if($rep->cpf)<div class="text-muted" style="font-size:.75rem">CPF: {{ $rep->cpf }}</div>@endif
                    @if($rep->rg)<div class="text-muted" style="font-size:.75rem">RG: {{ $rep->rg }}</div>@endif
                    @if($rep->telefone)<div class="text-muted" style="font-size:.75rem"><i class="bi bi-telephone me-1"></i>{{ $rep->telefone }}</div>@endif
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="card p-4">
            <h6 class="section-title">Medicamentos do Processo</h6>
            @foreach($processo->medicamentos as $med)
            <div class="mb-2 pb-2 border-bottom">
                <div class="fw-semibold small">{{ $med->nome }}{{ $med->dosagem ? ' — ' . $med->dosagem : '' }}</div>
                <div class="text-muted" style="font-size:.75rem">
                    {{ ucfirst($med->pivot->periodicidade) }}
                    @if($med->pivot->quantidade_mensal) | {{ $med->pivot->quantidade_mensal }} unidades/mês @endif
                    @if($med->pivot->posologia) | {{ $med->pivot->posologia }} @endif
                </div>
                @php $lotesDisp = $lotes->get($med->id, collect()); @endphp
                @if($lotesDisp->count())
                <div class="text-success" style="font-size:.75rem">
                    <i class="bi bi-box me-1"></i>Em estoque: {{ $lotesDisp->sum('quantidade_atual') }} unidades
                </div>
                @else
                <div class="text-danger" style="font-size:.75rem">
                    <i class="bi bi-exclamation-triangle me-1"></i>Sem estoque disponível
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:.75rem; }</style>
@endpush

@push('scripts')
<script>
function toggleRepresentante(cb) {
    document.getElementById('div-representante').classList.toggle('d-none', !cb.checked);
}

// Ao trocar o medicamento, filtra os lotes disponíveis e preenche quantidade
document.getElementById('select-medicamento').addEventListener('change', function() {
    const medId = this.value;
    const opt = this.options[this.selectedIndex];
    const qtd = opt.dataset.qtdMensal;
    if (qtd) document.getElementById('input-quantidade').value = qtd;

    // Filtra lotes pelo medicamento selecionado
    const loteSelect = document.getElementById('select-lote');
    Array.from(loteSelect.options).forEach(o => {
        if (!o.value) return;
        o.style.display = (o.dataset.med == medId) ? '' : 'none';
    });
    loteSelect.value = '';
    document.getElementById('estoque-info').textContent = '';
});

document.getElementById('select-lote').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const info = document.getElementById('estoque-info');
    if (!opt.value) { info.textContent = ''; return; }
    info.textContent = `Disponível neste lote: ${opt.dataset.disponivel} unidades`;
    info.className = 'form-text text-success fw-semibold';
});
</script>
@endpush
</x-app-layout>
