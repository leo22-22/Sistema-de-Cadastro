<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h4><i class="bi bi-box-seam me-2"></i>Relatório de Estoque</h4>
    <a href="{{ route('relatorios.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Situação</label>
            <select name="situacao" class="form-select form-select-sm">
                <option value="">Todas</option>
                <option value="ok" {{ request('situacao')=='ok' ? 'selected' : '' }}>OK</option>
                <option value="baixo" {{ request('situacao')=='baixo' ? 'selected' : '' }}>Estoque Baixo</option>
                <option value="sem_estoque" {{ request('situacao')=='sem_estoque' ? 'selected' : '' }}>Sem Estoque</option>
                <option value="vencidos" {{ request('situacao')=='vencidos' ? 'selected' : '' }}>Vencidos</option>
            </select>
        </div>
        <div class="col d-flex gap-2 align-items-end flex-wrap">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            <button type="submit" name="formato" value="csv" class="btn btn-outline-success btn-sm"><i class="bi bi-filetype-csv me-1"></i>CSV</button>
            <button type="submit" name="formato" value="pdf" class="btn btn-outline-danger btn-sm"><i class="bi bi-file-pdf me-1"></i>PDF</button>
            <a href="{{ route('relatorios.estoque') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Medicamento</th>
                    <th>Lote</th>
                    <th class="text-center">Qtd Inicial</th>
                    <th class="text-center">Qtd Atual</th>
                    <th>Validade</th>
                    <th>Entrada</th>
                    <th class="pe-3 text-center">Situação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lotes as $l)
                @php
                    $vencido    = $l->validade->isPast();
                    $semEstoque = $l->quantidade_atual <= 0;
                    $baixo      = !$vencido && !$semEstoque && $l->quantidade_atual <= 10;
                @endphp
                <tr class="{{ $vencido ? 'table-danger' : ($semEstoque ? 'table-secondary' : '') }}">
                    <td class="ps-3 fw-semibold small">{{ $l->medicamento->nome }}</td>
                    <td class="font-monospace small">{{ $l->lote }}</td>
                    <td class="text-center small">{{ $l->quantidade_inicial }}</td>
                    <td class="text-center fw-bold {{ $semEstoque ? 'text-danger' : 'text-success' }}">{{ $l->quantidade_atual }}</td>
                    <td class="small {{ $vencido ? 'text-danger fw-bold' : '' }}">{{ $l->validade->format('d/m/Y') }}</td>
                    <td class="small text-muted">{{ $l->data_entrada->format('d/m/Y') }}</td>
                    <td class="pe-3 text-center">
                        @if($vencido)<span class="badge bg-danger">Vencido</span>
                        @elseif($semEstoque)<span class="badge bg-secondary">Sem Estoque</span>
                        @elseif($baixo)<span class="badge bg-warning text-dark">Estoque Baixo</span>
                        @else<span class="badge bg-success">OK</span>@endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nenhum lote encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
