<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-person-plus me-2"></i>Novo Paciente</h4>
    <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('pacientes.store') }}" method="POST">
@csrf

@if($errors->any())
<div class="alert alert-danger d-flex gap-2 mb-4" role="alert">
    <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1"></i>
    <div>
        <strong>Corrija os campos indicados abaixo:</strong>
        <ul class="mb-0 mt-1 ps-3">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="row g-4">

    {{-- COLUNA PRINCIPAL --}}
    <div class="col-lg-8">

        {{-- Dados pessoais --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados Pessoais</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome') }}" required autofocus>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome da Mãe</label>
                    <input type="text" name="nome_mae" class="form-control"
                           value="{{ old('nome_mae') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" class="form-control @error('data_nascimento') is-invalid @enderror"
                           value="{{ old('data_nascimento') }}">
                    @error('data_nascimento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Raça/Cor</label>
                    <select name="raca_cor" class="form-select">
                        @foreach(\App\Models\Paciente::$racaCorLabels as $val => $label)
                        <option value="{{ $val }}" {{ old('raca_cor','nao_informada') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Nº Prontuário</label>
                    <input type="text" name="prontuario" class="form-control" value="{{ old('prontuario') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CPF</label>
                    <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                           value="{{ old('cpf') }}" placeholder="000.000.000-00" data-mask="cpf" maxlength="14">
                    @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">RG</label>
                    <input type="text" name="rg" class="form-control @error('rg') is-invalid @enderror" value="{{ old('rg') }}">
                    @error('rg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CNS (Cartão SUS)</label>
                    <input type="text" name="cns" class="form-control @error('cns') is-invalid @enderror"
                           value="{{ old('cns') }}" placeholder="000 0000 0000 0000" data-mask="cns" maxlength="19">
                    @error('cns')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Peso (kg)</label>
                    <input type="number" name="peso" class="form-control" value="{{ old('peso') }}"
                           step="0.1" min="1" max="300" placeholder="ex: 72.5">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Altura (cm)</label>
                    <input type="number" name="altura" class="form-control" value="{{ old('altura') }}"
                           min="30" max="250" placeholder="ex: 175">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="{{ old('telefone') }}" placeholder="(00) 00000-0000" data-mask="telefone" maxlength="15">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">E-mail</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        {{-- Endereço --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Endereço</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control"
                           value="{{ old('cep') }}" placeholder="00000-000" data-mask="cep" maxlength="9">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Logradouro</label>
                    <input type="text" name="logradouro" id="logradouro" class="form-control"
                           value="{{ old('logradouro') }}" placeholder="Rua, Av, Travessa...">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Número</label>
                    <input type="text" name="numero_endereco" class="form-control"
                           value="{{ old('numero_endereco') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Complemento</label>
                    <input type="text" name="complemento" class="form-control"
                           value="{{ old('complemento') }}" placeholder="Apto, Bloco...">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bairro</label>
                    <input type="text" name="bairro" id="bairro" class="form-control"
                           value="{{ old('bairro') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control"
                           value="{{ old('cidade') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">UF</label>
                    <input type="text" name="uf" id="uf" class="form-control text-uppercase"
                           value="{{ old('uf') }}" maxlength="2">
                </div>
            </div>
        </div>

        {{-- Observações --}}
        <div class="card p-4">
            <h6 class="section-title">Observações</h6>
            <textarea name="observacoes" class="form-control" rows="3"
                      placeholder="Informações adicionais sobre o paciente...">{{ old('observacoes') }}</textarea>
        </div>
    </div>

    {{-- COLUNA LATERAL --}}
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Declaração Autorizadora</h6>
            <p class="small text-muted mb-3">O paciente pode autorizar até <strong>3 representantes</strong> para retirar medicações.</p>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="sem_representante"
                       id="sem_representante" value="1"
                       {{ old('sem_representante') ? 'checked' : '' }}
                       onchange="toggleRepresentantes(this)">
                <label class="form-check-label fw-semibold text-muted" for="sem_representante">
                    Paciente não deseja representante
                </label>
            </div>

            <div id="div-representantes">
                @for($i = 0; $i < 3; $i++)
                <div class="mb-2">
                    <label class="form-label small fw-semibold text-muted">{{ $i + 1 }}º Representante</label>
                    <select name="representantes[{{ $i }}]" class="form-select form-select-sm">
                        <option value="">— Nenhum —</option>
                        @foreach($representantes as $rep)
                        <option value="{{ $rep->id }}"
                            {{ old("representantes.$i") == $rep->id ? 'selected' : '' }}>
                            {{ $rep->nome }}{{ $rep->cpf ? ' (' . $rep->cpf . ')' : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endfor

                @if($representantes->isEmpty())
                <p class="text-muted small mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Nenhum representante cadastrado.
                    <a href="{{ route('representantes.create') }}" target="_blank">Cadastrar agora</a>
                </p>
                @endif
            </div>
        </div>

        <div class="card p-3 border-primary" style="border-width:2px!important">
            <h6 class="section-title text-primary">Resumo do Cadastro</h6>
            <ul class="small mb-0 ps-3 text-muted" id="resumo-list">
                <li>Preencha os dados e salve</li>
                <li>Vincule os representantes (opcional)</li>
                <li>Abra processos a partir do perfil do paciente</li>
            </ul>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Paciente</button>
    <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>
.section-title {
    font-size: .72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #64748b;
    margin-bottom: 1rem;
}
</style>
@endpush

@push('scripts')
<script>
function toggleRepresentantes(cb) {
    document.getElementById('div-representantes').style.opacity = cb.checked ? '0.35' : '1';
    document.querySelectorAll('#div-representantes select').forEach(s => s.disabled = cb.checked);
}

// Busca CEP via ViaCEP
document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) return;
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(r => r.json())
        .then(d => {
            if (d.erro) return;
            document.getElementById('logradouro').value = d.logradouro || '';
            document.getElementById('bairro').value     = d.bairro || '';
            document.getElementById('cidade').value     = d.localidade || '';
            document.getElementById('uf').value         = d.uf || '';
        })
        .catch(() => {});
});
</script>
@endpush
</x-app-layout>
