<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1"><i class="bi bi-person-badge me-2"></i>{{ $representante->nome }}</h4>
        <span class="badge {{ $representante->ativo ? 'bg-success' : 'bg-secondary' }}">
            {{ $representante->ativo ? 'Ativo' : 'Inativo' }}
        </span>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('representantes.edit', $representante) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('representantes.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Voltar
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados Pessoais</h6>
            <dl class="row mb-0 small">
                <dt class="col-5 text-muted">CPF</dt>
                <dd class="col-7">{{ $representante->cpf ?? '—' }}</dd>

                <dt class="col-5 text-muted">RG</dt>
                <dd class="col-7">{{ $representante->rg ?? '—' }}</dd>

                <dt class="col-5 text-muted">Telefone</dt>
                <dd class="col-7">{{ $representante->telefone ?? '—' }}</dd>
            </dl>
            @if($representante->observacoes)
            <hr>
            <p class="small text-muted mb-0">{{ $representante->observacoes }}</p>
            @endif
        </div>

        @if($representante->logradouro || $representante->cidade)
        <div class="card p-4">
            <h6 class="section-title">Endereço</h6>
            <p class="small mb-1">
                {{ $representante->logradouro }}
                @if($representante->numero_endereco), nº {{ $representante->numero_endereco }}@endif
                @if($representante->complemento) — {{ $representante->complemento }}@endif
            </p>
            @if($representante->bairro)<p class="small mb-1 text-muted">{{ $representante->bairro }}</p>@endif
            <p class="small mb-1">{{ $representante->cidade }}@if($representante->uf)/{{ $representante->uf }}@endif</p>
            @if($representante->cep)<p class="small mb-0 text-muted">CEP: {{ $representante->cep }}</p>@endif
        </div>
        @endif
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Pacientes Representados ({{ $representante->pacientes->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Nome</th>
                            <th>CNS</th>
                            <th>CPF</th>
                            <th>Prontuário</th>
                            <th class="text-center">Status</th>
                            <th class="pe-3 text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($representante->pacientes as $pac)
                        <tr>
                            <td class="ps-3 fw-semibold">{{ $pac->nome }}</td>
                            <td class="small text-muted">{{ $pac->cns ?? '—' }}</td>
                            <td class="small text-muted">{{ $pac->cpf ?? '—' }}</td>
                            <td class="small text-muted">{{ $pac->prontuario ?? '—' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $pac->ativo ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $pac->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('pacientes.show', $pac) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhum paciente vinculado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:.75rem; }</style>
@endpush
</x-app-layout>
