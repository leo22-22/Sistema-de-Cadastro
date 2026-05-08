<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1"><i class="bi bi-person-badge me-2"></i>{{ $medico->nome }}</h4>
        <div class="d-flex gap-2 flex-wrap">
            @if($medico->crm)<span class="badge bg-primary">CRM: {{ $medico->crm }}</span>@endif
            @if($medico->especialidade)<span class="badge bg-light text-dark border">{{ $medico->especialidade }}</span>@endif
            <span class="badge {{ $medico->ativo ? 'bg-success' : 'bg-secondary' }}">{{ $medico->ativo ? 'Ativo' : 'Inativo' }}</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('medicos-prescritores.edit', $medico) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('medicos-prescritores.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Voltar
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4">
            <h6 class="section-title">Dados do Médico</h6>
            <dl class="row mb-0 small">
                <dt class="col-5 text-muted">Nome</dt>
                <dd class="col-7 fw-semibold">{{ $medico->nome }}</dd>

                <dt class="col-5 text-muted">CRM</dt>
                <dd class="col-7">{{ $medico->crm ?? '—' }}</dd>

                <dt class="col-5 text-muted">CNS</dt>
                <dd class="col-7">{{ $medico->cns ?? '—' }}</dd>

                <dt class="col-5 text-muted">CNES</dt>
                <dd class="col-7">{{ $medico->cnes ?? '—' }}</dd>

                <dt class="col-5 text-muted">Especialidade</dt>
                <dd class="col-7">{{ $medico->especialidade ?? '—' }}</dd>

                <dt class="col-5 text-muted">Estabelecimento</dt>
                <dd class="col-7">{{ $medico->estabelecimento ?? '—' }}</dd>

                <dt class="col-5 text-muted">Telefone</dt>
                <dd class="col-7">{{ $medico->telefone ?? '—' }}</dd>

                <dt class="col-5 text-muted">Cidade/UF</dt>
                <dd class="col-7">
                    @if($medico->cidade){{ $medico->cidade }}@if($medico->uf)/{{ $medico->uf }}@endif@else —@endif
                </dd>
            </dl>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Processos Vinculados</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Nº Processo</th>
                            <th>Paciente</th>
                            <th>CID-10</th>
                            <th>Abertura</th>
                            <th class="text-center">Status</th>
                            <th class="pe-3 text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medico->processos ?? [] as $proc)
                        <tr>
                            <td class="ps-3 fw-bold font-monospace">{{ $proc->numero }}</td>
                            <td>{{ $proc->paciente->nome }}</td>
                            <td>
                                @if($proc->cid10)
                                <span class="badge bg-light text-dark border">{{ $proc->cid10->codigo }}</span>
                                @else —
                                @endif
                            </td>
                            <td class="small text-muted">{{ $proc->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge {{ $proc->statusBadgeClass() }}">{{ $proc->statusLabel() }}</span>
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('processos.show', $proc) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhum processo vinculado.</td></tr>
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
