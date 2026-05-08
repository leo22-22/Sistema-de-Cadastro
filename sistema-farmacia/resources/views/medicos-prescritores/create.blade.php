<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-person-plus me-2"></i>Novo Médico Prescritor</h4>
    <a href="{{ route('medicos-prescritores.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('medicos-prescritores.store') }}" method="POST">
@csrf
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados do Médico</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome') }}" required autofocus>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CRM</label>
                    <input type="text" name="crm" class="form-control @error('crm') is-invalid @enderror"
                           value="{{ old('crm') }}" placeholder="ex: 12345/SP">
                    @error('crm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CNS</label>
                    <input type="text" name="cns" class="form-control @error('cns') is-invalid @enderror"
                           value="{{ old('cns') }}" placeholder="000 0000 0000 0000" maxlength="15">
                    @error('cns')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">CNES</label>
                    <input type="text" name="cnes" class="form-control @error('cnes') is-invalid @enderror"
                           value="{{ old('cnes') }}" placeholder="0000000">
                    @error('cnes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Estabelecimento de Saúde</label>
                    <input type="text" name="estabelecimento" class="form-control"
                           value="{{ old('estabelecimento') }}" placeholder="Hospital, UBS, clínica...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Especialidade</label>
                    <input type="text" name="especialidade" class="form-control"
                           value="{{ old('especialidade') }}" placeholder="ex: Cardiologia">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Telefone</label>
                    <input type="text" name="telefone" class="form-control"
                           value="{{ old('telefone') }}" placeholder="(00) 00000-0000">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Cidade</label>
                    <input type="text" name="cidade" class="form-control"
                           value="{{ old('cidade') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">UF</label>
                    <input type="text" name="uf" class="form-control text-uppercase"
                           value="{{ old('uf') }}" maxlength="2">
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4 border-primary" style="border-width:2px!important">
            <h6 class="section-title text-primary">Informação</h6>
            <ul class="small text-muted ps-3 mb-0">
                <li>O CRM é obrigatório para prescrições controladas</li>
                <li>O CNES identifica o estabelecimento de saúde</li>
                <li>O CNS do médico é necessário para emissão de APAC</li>
            </ul>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Médico</button>
    <a href="{{ route('medicos-prescritores.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:1rem; }</style>
@endpush
</x-app-layout>
