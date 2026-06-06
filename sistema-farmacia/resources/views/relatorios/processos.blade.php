<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h4><i class="bi bi-folder2-open me-2"></i>Relatório de Processos</h4>
    <a href="{{ route('relatorios.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select name="status" class="form-select form-select-sm">
                <option value="">Todos</option>
                <option value="aberto" {{ request('status')=='aberto' ? 'selected' : '' }}>Aberto</option>
                <option value="em_andamento" {{ request('status')=='em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                <option value="concluido" {{ request('status')=='concluido' ? 'selected' : '' }}>Concluído</option>
                <option value="cancelado" {{ request('status')=='cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">De</label>
            <input type="date" name="data_de" class="form-control form-control-sm" value="{{ request('data_de') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label">Até</label>
            <input type="date" name="data_ate" class="form-control form-control-sm" value="{{ request('data_ate') }}">
        </div>
        <div class="col d-flex gap-2 align-items-end flex-wrap">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            <button type="submit" name="formato" value="csv" class="btn btn-outline-success btn-sm"><i class="bi bi-filetype-csv me-1"></i>CSV</button>
            <button type="submit" name="formato" value="pdf" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>PDF</button>
            <a href="{{ route('relatorios.processos') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card mb-3 p-3">
    <span class="text-muted small">Total encontrado</span>
    <div class="fs-4 fw-bold">{{ $processos->count() }}</div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Número</th>
                    <th>Paciente</th>
                    <th>CID</th>
                    <th>Tipo</th>
                    <th>Abertura</th>
                    <th class="text-center">APAC</th>
                    <th class="pe-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($processos as $p)
                <tr>
                    <td class="ps-3 fw-bold font-monospace small">{{ $p->numero }}</td>
                    <td class="small">{{ $p->paciente->nome ?? '—' }}</td>
                    <td><span class="badge bg-dark" style="font-size:.7rem">{{ $p->cid10->codigo ?? '—' }}</span></td>
                    <td><span class="badge bg-light text-dark border" style="font-size:.7rem">{{ \App\Models\Processo::$tiposProcesso[$p->tipo_processo] ?? $p->tipo_processo }}</span></td>
                    <td class="small text-muted">{{ $p->created_at->format('d/m/Y') }}</td>
                    <td class="text-center small">
                        @if($p->validade_apac)
                            <span class="{{ $p->validade_apac->isPast() ? 'text-danger fw-bold' : 'text-success' }}">{{ $p->validade_apac->format('d/m/Y') }}</span>
                        @else —
                        @endif
                    </td>
                    <td class="pe-3 text-center"><span class="badge {{ $p->statusBadgeClass() }}">{{ $p->statusLabel() }}</span></td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nenhum processo encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
