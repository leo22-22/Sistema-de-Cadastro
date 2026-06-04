<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-folder2-open me-2"></i>Processos</h4>
    <a href="{{ route('processos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Novo Processo
    </a>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <input type="text" name="busca" class="form-control form-control-sm"
                   placeholder="Nº processo ou nome do paciente..."
                   value="{{ request('busca') }}">
        </div>
        <div class="col-md-2">
            <select name="tipo_processo" class="form-select form-select-sm">
                <option value="">Todos os tipos</option>
                @foreach(\App\Models\Processo::$tiposProcesso as $val => $label)
                <option value="{{ $val }}" {{ request('tipo_processo') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="status" class="form-select form-select-sm">
                <option value="">Todos os status</option>
                @foreach(['aberto' => 'Aberto','em_andamento' => 'Em Andamento','concluido' => 'Concluído','cancelado' => 'Cancelado'] as $val => $label)
                <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-search me-1"></i>Buscar</button>
            <a href="{{ route('processos.index') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Nº Processo</th>
                    <th>Paciente</th>
                    <th>CID-10</th>
                    <th>Tipo</th>
                    <th>APAC</th>
                    <th>Abertura</th>
                    <th>Responsável</th>
                    <th class="text-center">Status</th>
                    <th class="pe-3 text-end">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($processos as $processo)
                <tr>
                    <td class="ps-3"><span class="fw-bold font-monospace">{{ $processo->numero }}</span></td>
                    <td>{{ $processo->paciente->nome }}</td>
                    <td>
                        @if($processo->cid10)
                        <span class="badge bg-light text-dark border" title="{{ $processo->cid10->nome }}">{{ $processo->cid10->codigo }}</span>
                        @else
                        <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border" style="font-size:.7rem">
                            {{ \App\Models\Processo::$tiposProcesso[$processo->tipo_processo] ?? $processo->tipo_processo }}
                        </span>
                    </td>
                    <td class="small">
                        @if($processo->validade_apac)
                            @if($processo->validade_apac->isPast())
                                <span class="text-danger fw-bold">{{ $processo->validade_apac->format('d/m/Y') }}<br><small>VENCIDA</small></span>
                            @else
                                <span class="text-success">{{ $processo->validade_apac->format('d/m/Y') }}</span>
                            @endif
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $processo->created_at->format('d/m/Y') }}</td>
                    <td class="text-muted small">{{ $processo->criadoPor?->name ?? '—' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $processo->statusBadgeClass() }}">{{ $processo->statusLabel() }}</span>
                    </td>
                    <td class="pe-3 text-end">
                        <a href="{{ route('processos.show', $processo) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Nenhum processo encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($processos->hasPages())
    <div class="card-footer bg-white">{{ $processos->links() }}</div>
    @endif
</div>
</x-app-layout>
