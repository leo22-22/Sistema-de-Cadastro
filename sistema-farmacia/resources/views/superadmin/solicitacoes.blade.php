<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-envelope-open me-2"></i>Solicitações de Sistema</h4>
        <small class="text-muted">Prefeituras e órgãos que entraram em contato pelo site</small>
    </div>
    @php $naoLidas = $solicitacoes->where('lido', false)->count(); @endphp
    @if($naoLidas)
    <span class="badge bg-danger fs-6">{{ $naoLidas }} não lida(s)</span>
    @endif
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Data</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Município/UF</th>
                    <th>Mensagem</th>
                    <th class="pe-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($solicitacoes as $s)
                <tr class="{{ !$s->lido ? 'table-primary' : '' }}">
                    <td class="ps-3 small text-muted text-nowrap">{{ $s->created_at->format('d/m/Y H:i') }}</td>
                    <td class="fw-semibold">{{ $s->nome }}</td>
                    <td class="small"><a href="mailto:{{ $s->email }}" class="text-decoration-none">{{ $s->email }}</a></td>
                    <td class="small">{{ $s->telefone }}</td>
                    <td class="small">{{ $s->municipio }}/{{ $s->estado }}</td>
                    <td class="small text-muted" style="max-width:220px;">
                        <span title="{{ $s->mensagem }}">{{ Str::limit($s->mensagem, 60) ?: '—' }}</span>
                    </td>
                    <td class="pe-3 text-center">
                        @if($s->lido)
                            <span class="badge bg-success">Lido</span>
                        @else
                            <form action="{{ route('contato.lido', $s) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-primary">Marcar lido</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nenhuma solicitação recebida ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($solicitacoes->hasPages())
    <div class="card-footer bg-white">{{ $solicitacoes->links() }}</div>
    @endif
</div>
</x-app-layout>
