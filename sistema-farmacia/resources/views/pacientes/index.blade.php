<x-app-layout>
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="bi bi-people me-2"></i>Pacientes</h4>
        <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Novo Paciente
        </a>
    </div>

    <div class="card mb-3 p-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-6">
                <input type="text" name="busca" class="form-control" placeholder="Buscar por nome ou CPF..."
                       value="{{ request('busca') }}">
            </div>
            <div class="col-md-3">
                <select name="ativo" class="form-select">
                    <option value="">Todos os status</option>
                    <option value="1" {{ request('ativo') === '1' ? 'selected' : '' }}>Ativos</option>
                    <option value="0" {{ request('ativo') === '0' ? 'selected' : '' }}>Inativos</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search me-1"></i>Buscar</button>
                <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">Limpar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Nome</th>
                        <th>Prontuário</th>
                        <th>CNS</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Cidade/UF</th>
                        <th class="text-center">Status</th>
                        <th class="pe-3 text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pacientes as $paciente)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $paciente->nome }}</td>
                        <td class="small text-muted">{{ $paciente->prontuario ?? '—' }}</td>
                        <td class="small text-muted">{{ $paciente->cns ?? '—' }}</td>
                        <td class="small text-muted">{{ $paciente->cpf ?? '—' }}</td>
                        <td class="small text-muted">{{ $paciente->telefone ?? '—' }}</td>
                        <td class="small text-muted">{{ $paciente->cidade ? $paciente->cidade . '/' . $paciente->uf : '—' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $paciente->ativo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $paciente->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('pacientes.show', $paciente) }}" class="btn btn-sm btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-sm btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('pacientes.destroy', $paciente) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Excluir o paciente {{ $paciente->nome }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Excluir"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Nenhum paciente encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pacientes->hasPages())
        <div class="card-footer bg-white">{{ $pacientes->links() }}</div>
        @endif
    </div>
</x-app-layout>
