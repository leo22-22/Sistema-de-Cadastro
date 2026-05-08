<x-app-layout>
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="bi bi-person-badge me-2"></i>Representantes</h4>
        <a href="{{ route('representantes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Novo Representante
        </a>
    </div>

    <div class="card mb-3 p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-8">
                <input type="text" name="busca" class="form-control" placeholder="Buscar por nome ou CPF..."
                       value="{{ request('busca') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search me-1"></i>Buscar</button>
                <a href="{{ route('representantes.index') }}" class="btn btn-outline-secondary">Limpar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Nome</th>
                        <th>CPF</th>
                        <th>RG</th>
                        <th>Telefone</th>
                        <th>Cidade/UF</th>
                        <th class="text-center">Status</th>
                        <th class="pe-3 text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($representantes as $rep)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $rep->nome }}</td>
                        <td class="small text-muted">{{ $rep->cpf ?? '—' }}</td>
                        <td class="small text-muted">{{ $rep->rg ?? '—' }}</td>
                        <td class="small text-muted">{{ $rep->telefone ?? '—' }}</td>
                        <td class="small text-muted">{{ $rep->cidade ? $rep->cidade . '/' . $rep->uf : '—' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $rep->ativo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $rep->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('representantes.show', $rep) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('representantes.edit', $rep) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('representantes.destroy', $rep) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Excluir {{ $rep->nome }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Nenhum representante encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($representantes->hasPages())
        <div class="card-footer bg-white">{{ $representantes->links() }}</div>
        @endif
    </div>
</x-app-layout>
