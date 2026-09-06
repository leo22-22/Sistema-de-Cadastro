<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-capsule me-2"></i>Medicamentos</h4>
    @if(auth()->user()->isAdminFarmacia())
    <a href="{{ route('medicamentos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Novo Medicamento
    </a>
    @endif
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-8">
            <input type="text" name="busca" class="form-control form-control-sm"
                   placeholder="Buscar por nome ou princípio ativo..."
                   value="{{ request('busca') }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search me-1"></i>Buscar</button>
            <a href="{{ route('medicamentos.index') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Nome</th>
                    <th>Princípio Ativo</th>
                    <th>Dosagem</th>
                    <th>Forma Farm.</th>
                    <th>Periodicidade</th>
                    <th>Tipo Receita</th>
                    <th class="text-center">Status</th>
                    @if(auth()->user()->isAdminFarmacia())
                    <th class="pe-3 text-end">Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($medicamentos as $med)
                <tr>
                    <td class="ps-3 fw-semibold">{{ $med->nome }}</td>
                    <td class="small text-muted">{{ $med->principio_ativo ?? '—' }}</td>
                    <td class="small text-muted">{{ $med->dosagem ?? '—' }}</td>
                    <td class="small text-muted">{{ $med->forma_label ?? '—' }}</td>
                    <td class="small text-muted">{{ $med->periodicidade ? ucfirst($med->periodicidade) : '—' }}</td>
                    <td>
                        @if($med->tipoReceita)
                        <span class="badge bg-{{ $med->tipoReceita->cor ?? 'secondary' }}" style="font-size:.7rem">
                            {{ $med->tipoReceita->nome }}
                        </span>
                        @else
                        <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge {{ $med->ativo ? 'bg-success' : 'bg-secondary' }}">
                            {{ $med->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </td>
                    @if(auth()->user()->isAdminFarmacia())
                    <td class="pe-3 text-end">
                        <a href="{{ route('medicamentos.edit', $med) }}" class="btn btn-sm btn-outline-secondary" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('medicamentos.destroy', $med) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Excluir {{ $med->nome }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Nenhum medicamento encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($medicamentos->hasPages())
    <div class="card-footer bg-white">{{ $medicamentos->links() }}</div>
    @endif
</div>
</x-app-layout>
