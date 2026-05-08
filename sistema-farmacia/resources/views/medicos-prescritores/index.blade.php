<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-person-badge me-2"></i>Médicos Prescritores</h4>
    <a href="{{ route('medicos-prescritores.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Novo Médico
    </a>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-8">
            <input type="text" name="busca" class="form-control form-control-sm"
                   placeholder="Buscar por nome, CRM ou estabelecimento..."
                   value="{{ request('busca') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search me-1"></i>Buscar</button>
            <a href="{{ route('medicos-prescritores.index') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Nome</th>
                    <th>CRM</th>
                    <th>CNS</th>
                    <th>CNES</th>
                    <th>Estabelecimento</th>
                    <th>Especialidade</th>
                    <th>Cidade/UF</th>
                    <th class="text-center">Status</th>
                    <th class="pe-3 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicos as $medico)
                <tr>
                    <td class="ps-3 fw-semibold">{{ $medico->nome }}</td>
                    <td class="small">{{ $medico->crm ?? '—' }}</td>
                    <td class="small text-muted">{{ $medico->cns ?? '—' }}</td>
                    <td class="small text-muted">{{ $medico->cnes ?? '—' }}</td>
                    <td class="small">{{ $medico->estabelecimento ?? '—' }}</td>
                    <td class="small text-muted">{{ $medico->especialidade ?? '—' }}</td>
                    <td class="small text-muted">
                        @if($medico->cidade){{ $medico->cidade }}@if($medico->uf)/{{ $medico->uf }}@endif@else —@endif
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $medico->ativo ? 'bg-success' : 'bg-secondary' }}">
                            {{ $medico->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    <td class="pe-3 text-end">
                        <a href="{{ route('medicos-prescritores.show', $medico) }}" class="btn btn-sm btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('medicos-prescritores.edit', $medico) }}" class="btn btn-sm btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('medicos-prescritores.destroy', $medico) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Remover Dr(a). {{ $medico->nome }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Remover"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Nenhum médico cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($medicos->hasPages())
    <div class="card-footer bg-white">{{ $medicos->links() }}</div>
    @endif
</div>
</x-app-layout>
