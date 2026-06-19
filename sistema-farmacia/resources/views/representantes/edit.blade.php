<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-pencil me-2"></i>Editar — {{ $representante->nome }}</h4>
    <a href="{{ route('representantes.show', $representante) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('representantes.update', $representante) }}" method="POST">
@csrf @method('PATCH')

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
    <div class="col-lg-8">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados Pessoais</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $representante->nome) }}" required>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CPF</label>
                    <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                           value="{{ old('cpf', $representante->cpf) }}" placeholder="000.000.000-00" data-mask="cpf" maxlength="14">
                    @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">RG</label>
                    <input type="text" name="rg" class="form-control @error('rg') is-invalid @enderror"
                           value="{{ old('rg', $representante->rg) }}">
                    @error('rg')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="{{ old('telefone', $representante->telefone) }}" placeholder="(00) 00000-0000" data-mask="telefone" maxlength="15">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h6 class="section-title">Endereço</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control"
                           value="{{ old('cep', $representante->cep) }}" placeholder="00000-000" data-mask="cep" maxlength="9">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Logradouro</label>
                    <input type="text" name="logradouro" id="logradouro" class="form-control"
                           value="{{ old('logradouro', $representante->logradouro) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Número</label>
                    <input type="text" name="numero_endereco" class="form-control"
                           value="{{ old('numero_endereco', $representante->numero_endereco) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Complemento</label>
                    <input type="text" name="complemento" class="form-control"
                           value="{{ old('complemento', $representante->complemento) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bairro</label>
                    <input type="text" name="bairro" id="bairro" class="form-control"
                           value="{{ old('bairro', $representante->bairro) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control"
                           value="{{ old('cidade', $representante->cidade) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">UF</label>
                    <input type="text" name="uf" id="uf" class="form-control text-uppercase"
                           value="{{ old('uf', $representante->uf) }}" maxlength="2">
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h6 class="section-title">Observações e Status</h6>
            <textarea name="observacoes" class="form-control mb-3" rows="2">{{ old('observacoes', $representante->observacoes) }}</textarea>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo"
                       {{ old('ativo', $representante->ativo) ? 'checked' : '' }}>
                <label class="form-check-label" for="ativo">Representante ativo</label>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Alterações</button>
    <a href="{{ route('representantes.show', $representante) }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:1rem; }</style>
@endpush
@push('scripts')
<script>
document.getElementById('cep').addEventListener('blur', function() {
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
        }).catch(() => {});
});
</script>
@endpush
</x-app-layout>
