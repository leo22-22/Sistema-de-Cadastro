<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-pencil me-2"></i>Editar Paciente — {{ $paciente->nome }}</h4>
    <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('pacientes.update', $paciente) }}" method="POST">
@csrf @method('PATCH')
<div class="row g-4">

    <div class="col-lg-8">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados Pessoais</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $paciente->nome) }}" required>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome da Mãe</label>
                    <input type="text" name="nome_mae" class="form-control"
                           value="{{ old('nome_mae', $paciente->nome_mae) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" class="form-control"
                           value="{{ old('data_nascimento', $paciente->data_nascimento?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Raça/Cor</label>
                    <select name="raca_cor" class="form-select">
                        @foreach(\App\Models\Paciente::$racaCorLabels as $val => $label)
                        <option value="{{ $val }}" {{ old('raca_cor', $paciente->raca_cor) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nº Prontuário</label>
                    <input type="text" name="prontuario" class="form-control"
                           value="{{ old('prontuario', $paciente->prontuario) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CPF</label>
                    <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                           value="{{ old('cpf', $paciente->cpf) }}" placeholder="000.000.000-00" data-mask="cpf" maxlength="14">
                    @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">RG</label>
                    <input type="text" name="rg" class="form-control"
                           value="{{ old('rg', $paciente->rg) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CNS (Cartão SUS)</label>
                    <input type="text" name="cns" class="form-control @error('cns') is-invalid @enderror"
                           value="{{ old('cns', $paciente->cns) }}" placeholder="000 0000 0000 0000" data-mask="cns" maxlength="19">
                    @error('cns')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Peso (kg)</label>
                    <input type="number" name="peso" class="form-control"
                           value="{{ old('peso', $paciente->peso) }}" step="0.1" min="1" max="300">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Altura (cm)</label>
                    <input type="number" name="altura" class="form-control"
                           value="{{ old('altura', $paciente->altura) }}" min="30" max="250">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="{{ old('telefone', $paciente->telefone) }}" placeholder="(00) 00000-0000" data-mask="telefone" maxlength="15">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">E-mail</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $paciente->email) }}">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h6 class="section-title">Endereço</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control"
                           value="{{ old('cep', $paciente->cep) }}" placeholder="00000-000" data-mask="cep" maxlength="9">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Logradouro</label>
                    <input type="text" name="logradouro" id="logradouro" class="form-control"
                           value="{{ old('logradouro', $paciente->logradouro) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Número</label>
                    <input type="text" name="numero_endereco" class="form-control"
                           value="{{ old('numero_endereco', $paciente->numero_endereco) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Complemento</label>
                    <input type="text" name="complemento" class="form-control"
                           value="{{ old('complemento', $paciente->complemento) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bairro</label>
                    <input type="text" name="bairro" id="bairro" class="form-control"
                           value="{{ old('bairro', $paciente->bairro) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control"
                           value="{{ old('cidade', $paciente->cidade) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">UF</label>
                    <input type="text" name="uf" id="uf" class="form-control text-uppercase"
                           value="{{ old('uf', $paciente->uf) }}" maxlength="2">
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h6 class="section-title">Observações e Status</h6>
            <textarea name="observacoes" class="form-control mb-3" rows="3">{{ old('observacoes', $paciente->observacoes) }}</textarea>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo"
                       {{ old('ativo', $paciente->ativo) ? 'checked' : '' }}>
                <label class="form-check-label" for="ativo">Paciente ativo no sistema</label>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="section-title">Declaração Autorizadora</h6>
            <p class="small text-muted mb-3">Até <strong>3 representantes</strong> autorizados.</p>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="sem_representante"
                       id="sem_representante" value="1"
                       {{ old('sem_representante', $paciente->sem_representante) ? 'checked' : '' }}
                       onchange="toggleRepresentantes(this)">
                <label class="form-check-label fw-semibold text-muted" for="sem_representante">
                    Paciente não deseja representante
                </label>
            </div>

            <div id="div-representantes" style="{{ $paciente->sem_representante ? 'opacity:.35' : '' }}">
                @php $repIds = $paciente->representantes->pluck('id')->toArray(); @endphp
                @for($i = 0; $i < 3; $i++)
                @php $repAtual = $paciente->representantes->get($i); @endphp
                <div class="mb-2">
                    <label class="form-label small fw-semibold text-muted">{{ $i + 1 }}º Representante</label>
                    <select name="representantes[{{ $i }}]" class="form-select form-select-sm"
                            {{ $paciente->sem_representante ? 'disabled' : '' }}>
                        <option value="">— Nenhum —</option>
                        @foreach($representantes as $rep)
                        <option value="{{ $rep->id }}"
                            {{ old("representantes.$i", $repAtual?->id) == $rep->id ? 'selected' : '' }}>
                            {{ $rep->nome }}{{ $rep->cpf ? ' (' . $rep->cpf . ')' : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Alterações</button>
    <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:1rem; }</style>
@endpush
@push('scripts')
<script>
function toggleRepresentantes(cb) {
    document.getElementById('div-representantes').style.opacity = cb.checked ? '0.35' : '1';
    document.querySelectorAll('#div-representantes select').forEach(s => s.disabled = cb.checked);
}
document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g,'');
    if (cep.length !== 8) return;
    fetch(`https://viacep.com.br/ws/${cep}/json/`).then(r => r.json()).then(d => {
        if (d.erro) return;
        document.getElementById('logradouro').value = d.logradouro||'';
        document.getElementById('bairro').value     = d.bairro||'';
        document.getElementById('cidade').value     = d.localidade||'';
        document.getElementById('uf').value         = d.uf||'';
    }).catch(()=>{});
});
</script>
@endpush
</x-app-layout>
