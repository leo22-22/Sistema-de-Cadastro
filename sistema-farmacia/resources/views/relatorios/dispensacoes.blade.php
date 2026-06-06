<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h4><i class="bi bi-receipt me-2"></i>Relatório de Dispensações</h4>
    <a href="{{ route('relatorios.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Voltar</a>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Medicamento</label>
            <select name="medicamento_id" class="form-select form-select-sm">
                <option value="">Todos</option>
                @foreach($medicamentos as $m)
                <option value="{{ $m->id }}" {{ request('medicamento_id') == $m->id ? 'selected' : '' }}>{{ $m->nome }}</option>
                @endforeach
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
            <a href="{{ route('relatorios.dispensacoes') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card mb-3 p-3 d-flex flex-row gap-4 align-items-center">
    <div><span class="text-muted small">Total de registros</span><div class="fs-4 fw-bold">{{ $recibos->count() }}</div></div>
    <div><span class="text-muted small">Total de unidades</span><div class="fs-4 fw-bold text-success">{{ $total }}</div></div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Número</th>
                    <th>Data</th>
                    <th>Paciente</th>
                    <th>Medicamento</th>
                    <th class="text-center">Qtd</th>
                    <th>Mês Ref.</th>
                    <th class="pe-3">Gerado por</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recibos as $r)
                <tr>
                    <td class="ps-3 font-monospace small fw-bold">{{ $r->numero }}</td>
                    <td class="small text-muted">{{ $r->created_at->format('d/m/Y H:i') }}</td>
                    <td class="small">{{ $r->processo->paciente->nome ?? '—' }}</td>
                    <td class="small fw-semibold">{{ $r->medicamento->nome ?? '—' }}</td>
                    <td class="text-center small">{{ $r->quantidade }}</td>
                    <td class="small text-muted">{{ $r->mes_referencia ? \Carbon\Carbon::parse($r->mes_referencia)->translatedFormat('M/Y') : '—' }}</td>
                    <td class="pe-3 small text-muted">{{ $r->geradoPor->name ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Nenhuma dispensação encontrada.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
