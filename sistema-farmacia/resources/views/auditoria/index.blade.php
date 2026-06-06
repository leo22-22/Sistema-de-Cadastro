<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-shield-check me-2"></i>Log de Auditoria</h4>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Ação</label>
            <select name="acao" class="form-select form-select-sm">
                <option value="">Todas</option>
                @foreach($acoes as $a)
                <option value="{{ $a }}" {{ request('acao') == $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
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
        <div class="col-md-5 d-flex gap-2 align-items-end">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            <a href="{{ route('auditoria.index') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Data/Hora</th>
                    <th>Usuário</th>
                    @if(auth()->user()->isSuperadmin())<th>Farmácia</th>@endif
                    <th>Ação</th>
                    <th>Descrição</th>
                    <th class="pe-3">IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="ps-3 small text-muted text-nowrap">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="small fw-semibold">{{ $log->usuario?->name ?? 'Sistema' }}</td>
                    @if(auth()->user()->isSuperadmin())
                    <td class="small text-muted">{{ $log->farmacia?->nome ?? '—' }}</td>
                    @endif
                    <td>
                        @php
                            $cores = ['criar'=>'bg-success','editar'=>'bg-primary','excluir'=>'bg-danger','status'=>'bg-warning text-dark','dispensar'=>'bg-info text-dark','estornar'=>'bg-danger','renovar'=>'bg-secondary'];
                        @endphp
                        <span class="badge {{ $cores[$log->acao] ?? 'bg-secondary' }}">{{ ucfirst($log->acao) }}</span>
                    </td>
                    <td class="small">{{ $log->descricao }}</td>
                    <td class="pe-3 small text-muted font-monospace">{{ $log->ip }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhum registro encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="card-footer bg-white">{{ $logs->links() }}</div>
    @endif
</div>
</x-app-layout>
