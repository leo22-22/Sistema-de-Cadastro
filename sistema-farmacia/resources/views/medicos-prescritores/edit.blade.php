<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-pencil me-2"></i>Editar — {{ $medico->nome }}</h4>
    <a href="{{ route('medicos-prescritores.show', $medico) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('medicos-prescritores.update', $medico) }}" method="POST">
@csrf @method('PATCH')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados do Médico</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $medico->nome) }}" required>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CRM</label>
                    <input type="text" name="crm" class="form-control @error('crm') is-invalid @enderror"
                           value="{{ old('crm', $medico->crm) }}" placeholder="ex: 12345/SP">
                    @error('crm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CNS</label>
                    <input type="text" name="cns" class="form-control @error('cns') is-invalid @enderror"
                           value="{{ old('cns', $medico->cns) }}" placeholder="000 0000 0000 0000" data-mask="cns" maxlength="19">
                    @error('cns')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CNES</label>
                    <input type="text" name="cnes" class="form-control @error('cnes') is-invalid @enderror"
                           value="{{ old('cnes', $medico->cnes) }}" placeholder="0000000" data-mask="cnes" maxlength="7">
                    @error('cnes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Estabelecimento de Saúde</label>
                    <input type="text" name="estabelecimento" class="form-control"
                           value="{{ old('estabelecimento', $medico->estabelecimento) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Especialidade</label>
                    <input type="text" name="especialidade" class="form-control"
                           value="{{ old('especialidade', $medico->especialidade) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="{{ old('telefone', $medico->telefone) }}" placeholder="(00) 00000-0000" data-mask="telefone" maxlength="15">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cidade</label>
                    <input type="text" name="cidade" class="form-control"
                           value="{{ old('cidade', $medico->cidade) }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">UF</label>
                    <input type="text" name="uf" class="form-control text-uppercase"
                           value="{{ old('uf', $medico->uf) }}" maxlength="2">
                </div>
            </div>
        </div>

        <div class="card p-4">
            <h6 class="section-title">Status</h6>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo"
                       {{ old('ativo', $medico->ativo) ? 'checked' : '' }}>
                <label class="form-check-label" for="ativo">Médico ativo no sistema</label>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Alterações</button>
    <a href="{{ route('medicos-prescritores.show', $medico) }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:1rem; }</style>
@endpush
</x-app-layout>
