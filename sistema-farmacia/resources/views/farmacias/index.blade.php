<x-app-layout>
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="bi bi-hospital me-2"></i>Farmácias</h4>
        <a href="{{ route('farmacias.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Nova Farmácia
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Nome</th>
                        <th>CNPJ</th>
                        <th>CNES</th>
                        <th>Cidade / UF</th>
                        <th class="text-center">Usuários</th>
                        <th class="text-center">Status</th>
                        <th class="pe-3 text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($farmacias as $farmacia)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $farmacia->nome }}</td>
                        <td class="text-muted">{{ $farmacia->cnpj ?? '—' }}</td>
                        <td class="text-muted">{{ $farmacia->cnes ?? '—' }}</td>
                        <td class="text-muted">
                            {{ $farmacia->cidade ? $farmacia->cidade . ' / ' . $farmacia->estado : '—' }}
                        </td>
                        <td class="text-center">
                            <span class="badge bg-secondary">{{ $farmacia->users_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $farmacia->ativo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $farmacia->ativo ? 'Ativa' : 'Inativa' }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('farmacias.edit', $farmacia) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($farmacia->users_count === 0)
                            <form action="{{ route('farmacias.destroy', $farmacia) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Excluir a farmácia {{ $farmacia->nome }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Nenhuma farmácia cadastrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($farmacias->hasPages())
        <div class="card-footer bg-white">{{ $farmacias->links() }}</div>
        @endif
    </div>
</x-app-layout>
