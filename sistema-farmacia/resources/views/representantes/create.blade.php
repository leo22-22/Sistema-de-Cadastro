<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-person-badge me-2"></i>Novo Representante</h4>
    <a href="{{ route('representantes.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('representantes.store') }}" method="POST">
@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados Pessoais</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome') }}" required autofocus>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CPF</label>
                    <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                           value="{{ old('cpf') }}" placeholder="000.000.000-00" data-mask="cpf" maxlength="14">
                    @error('cpf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">RG</label>
                    <input type="text" name="rg" class="form-control"
                           value="{{ old('rg') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="{{ old('telefone') }}" placeholder="(00) 00000-0000" data-mask="telefone" maxlength="15">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h6 class="section-title">Endereço</h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control"
                           value="{{ old('cep') }}" placeholder="00000-000" data-mask="cep" maxlength="9">
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Logradouro</label>
                    <input type="text" name="logradouro" id="logradouro" class="form-control"
                           value="{{ old('logradouro') }}" placeholder="Rua, Av...">
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

        <div class="card p-4">
            <h6 class="section-title">Observações</h6>
            <textarea name="observacoes" class="form-control" rows="3"
                      placeholder="Grau de parentesco, informações adicionais...">{{ old('observacoes') }}</textarea>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4 border-primary" style="border-width:2px!important">
            <h6 class="section-title text-primary">Declaração Autorizadora</h6>
            <p class="small text-muted mb-0">
                O representante poderá ser vinculado a até 3 pacientes como responsável pela retirada de medicamentos.
                O RG é necessário para identificação na retirada.
            </p>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Representante</button>
    <a href="{{ route('representantes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
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
