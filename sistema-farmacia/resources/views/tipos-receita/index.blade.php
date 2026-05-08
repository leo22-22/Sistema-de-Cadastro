<x-app-layout>
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="bi bi-file-medical me-2"></i>Tipos de Receita</h4>
        <a href="{{ route('tipos-receita.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Novo Tipo
        </a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Nome</th>
                        <th class="text-center">Cor</th>
                        <th class="text-center">Requer Retenção</th>
                        <th class="text-center">Status</th>
                        <th class="pe-3 text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tipos as $tipo)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $tipo->nome }}</td>
                        <td class="text-center"><span class="badge bg-{{ $tipo->cor }}">{{ ucfirst($tipo->cor) }}</span></td>
                        <td class="text-center">
                            @if($tipo->requer_retencao)
                                <i class="bi bi-check-circle-fill text-success"></i>
                            @else
                                <i class="bi bi-dash-circle text-muted"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $tipo->ativo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $tipo->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('tipos-receita.edit', $tipo) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('tipos-receita.destroy', $tipo) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Excluir {{ $tipo->nome }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Nenhum tipo cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tipos->hasPages())
        <div class="card-footer bg-white">{{ $tipos->links() }}</div>
        @endif
    </div>
</x-app-layout>
