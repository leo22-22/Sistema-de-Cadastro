<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-box-seam me-2"></i>Estoque — Lotes</h4>
    <a href="{{ route('lotes.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Entrada de Lote
    </a>
</div>

<div class="card mb-3 p-3">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-4">
            <select name="medicamento_id" class="form-select form-select-sm">
                <option value="">Todos os medicamentos</option>
                @foreach($medicamentos as $med)
                <option value="{{ $med->id }}" {{ request('medicamento_id') == $med->id ? 'selected' : '' }}>
                    {{ $med->nome }}{{ $med->dosagem ? ' — ' . $med->dosagem : '' }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <div class="form-check form-check-inline mt-1">
                <input class="form-check-input" type="checkbox" name="vencidos" value="1" id="vencidos"
                       {{ request('vencidos') ? 'checked' : '' }}>
                <label class="form-check-label small" for="vencidos">Mostrar vencidos</label>
            </div>
        </div>
        <div class="col-md-5 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filtrar</button>
            <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary btn-sm">Limpar</a>
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
                    <th>Cadastrado por</th>
                    <th class="text-center">Situação</th>
                    <th class="pe-3 text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lotes as $lote)
                @php
                    $vencido = $lote->validade->isPast();
                    $semEstoque = $lote->quantidade_atual <= 0;
                @endphp
                <tr class="{{ $vencido ? 'table-danger' : ($semEstoque ? 'table-secondary' : '') }}">
                    <td class="ps-3 fw-semibold">
                        {{ $lote->medicamento->nome }}
                        @if($lote->medicamento->dosagem)<br><small class="text-muted">{{ $lote->medicamento->dosagem }}</small>@endif
                    </td>
                    <td class="font-monospace small">{{ $lote->lote }}</td>
                    <td class="text-center small">{{ $lote->quantidade_inicial }}</td>
                    <td class="text-center">
                        <span class="fw-bold {{ $semEstoque ? 'text-danger' : 'text-success' }}">
                            {{ $lote->quantidade_atual }}
                        </span>
                    </td>
                    <td class="small {{ $vencido ? 'text-danger fw-bold' : '' }}">
                        {{ $lote->validade->format('d/m/Y') }}
                        @if($vencido)<br><small>VENCIDO</small>@endif
                    </td>
                    <td class="small text-muted">{{ $lote->data_entrada->format('d/m/Y') }}</td>
                    <td class="small text-muted">{{ $lote->criadoPor?->name ?? '—' }}</td>
                    <td class="text-center">
                        @if($vencido)
                            <span class="badge bg-danger">Vencido</span>
                        @elseif($semEstoque)
                            <span class="badge bg-secondary">Sem Estoque</span>
                        @elseif($lote->quantidade_atual <= 10)
                            <span class="badge bg-warning text-dark">Estoque Baixo</span>
                        @else
                            <span class="badge bg-success">OK</span>
                        @endif
                    </td>
                    <td class="pe-3 text-end">
                        <a href="{{ route('lotes.show', $lote) }}" class="btn btn-sm btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('lotes.edit', $lote) }}" class="btn btn-sm btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('lotes.destroy', $lote) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Remover este lote?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Remover"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Nenhum lote cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($lotes->hasPages())
    <div class="card-footer bg-white">{{ $lotes->links() }}</div>
    @endif
</div>
</x-app-layout>
