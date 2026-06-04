<x-app-layout>
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="bi bi-people-fill me-2"></i>Usuários</h4>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Novo Usuário
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Nome</th>
                        <th>E-mail</th>
                        <th>Farmácia</th>
                        <th class="text-center">Perfil</th>
                        <th class="text-center">Status</th>
                        <th class="pe-3 text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                    <tr>
                        <td class="ps-3 fw-bold">{{ $usuario->name }}</td>
                        <td class="text-muted">{{ $usuario->email }}</td>
                        <td class="text-muted">{{ $usuario->farmacia?->nome ?? '—' }}</td>
                        <td class="text-center">
                            @php
                                $badgeClass = match($usuario->role) {
                                    'superadmin'     => 'bg-danger',
                                    'admin_farmacia' => 'bg-warning text-dark',
                                    default          => 'bg-secondary',
                                };
                                $badgeLabel = match($usuario->role) {
                                    'superadmin'     => 'Superadmin',
                                    'admin_farmacia' => 'Admin Farmácia',
                                    default          => 'Funcionário',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $usuario->active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $usuario->active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="pe-3 text-end">
                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($usuario->id !== auth()->id())
                            <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Excluir o usuário {{ $usuario->name }}?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Nenhum usuário encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($usuarios->hasPages())
        <div class="card-footer bg-white">{{ $usuarios->links() }}</div>
        @endif
    </div>
</x-app-layout>
