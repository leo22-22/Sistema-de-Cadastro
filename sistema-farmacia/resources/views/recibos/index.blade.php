<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-receipt me-2"></i>Recibos de Dispensação</h4>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="busca" class="form-control form-control-sm"
                   placeholder="Nº recibo ou nome do paciente..."
                   value="{{ request('busca') }}">
        </div>
        <div class="col-md-3">
            <input type="month" name="mes" class="form-control form-control-sm"
                   value="{{ request('mes') }}" title="Filtrar por mês de referência">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search me-1"></i>Buscar</button>
            <a href="{{ route('recibos.index') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Nº Recibo</th>
                    <th>Processo</th>
                    <th>Paciente</th>
                    <th>Medicamento</th>
                    <th class="text-center">Qtd</th>
                    <th>Mês Ref.</th>
                    <th>Emissão</th>
                    <th>Gerado por</th>
                    <th class="pe-3 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recibos as $recibo)
                <tr>
                    <td class="ps-3"><span class="fw-bold font-monospace">{{ $recibo->numero }}</span></td>
                    <td>
                        <a href="{{ route('processos.show', $recibo->processo) }}" class="text-decoration-none font-monospace small">
                            {{ $recibo->processo->numero }}
                        </a>
                    </td>
                    <td>{{ $recibo->processo->paciente->nome }}</td>
                    <td class="small">{{ $recibo->medicamento?->nome ?? '—' }}</td>
                    <td class="text-center small">{{ $recibo->quantidade }}</td>
                    <td class="small text-muted">{{ $recibo->mes_referencia?->format('m/Y') ?? '—' }}</td>
                    <td class="text-muted small">{{ $recibo->data_emissao->format('d/m/Y') }}</td>
                    <td class="text-muted small">{{ $recibo->geradoPor->name }}</td>
                    <td class="pe-3 text-end">
                        <a href="{{ route('recibos.show', $recibo) }}" class="btn btn-sm btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('recibos.imprimir', $recibo) }}" class="btn btn-sm btn-outline-secondary" title="Imprimir" target="_blank"><i class="bi bi-printer"></i></a>
                        <form action="{{ route('recibos.destroy', $recibo) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Estornar recibo {{ $recibo->numero }}? O estoque será restaurado.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Estornar"><i class="bi bi-arrow-counterclockwise"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Nenhum recibo gerado ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($recibos->hasPages())
    <div class="card-footer bg-white">{{ $recibos->links() }}</div>
    @endif
</div>
</x-app-layout>
