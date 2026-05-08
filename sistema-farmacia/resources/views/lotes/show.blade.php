<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-1"><i class="bi bi-box-seam me-2"></i>Lote {{ $lote->lote }}</h4>
        <div class="d-flex gap-2 flex-wrap">
            <span class="badge bg-light text-dark border">{{ $lote->medicamento->nome }}{{ $lote->medicamento->dosagem ? ' — ' . $lote->medicamento->dosagem : '' }}</span>
            @if($lote->validade->isPast())
                <span class="badge bg-danger">Vencido</span>
            @elseif($lote->quantidade_atual <= 0)
                <span class="badge bg-secondary">Sem Estoque</span>
            @elseif($lote->quantidade_atual <= 10)
                <span class="badge bg-warning text-dark">Estoque Baixo</span>
            @else
                <span class="badge bg-success">Em Estoque</span>
            @endif
        </div>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('lotes.edit', $lote) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Voltar
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados do Lote</h6>
            <dl class="row mb-0 small">
                <dt class="col-5 text-muted">Medicamento</dt>
                <dd class="col-7 fw-semibold">{{ $lote->medicamento->nome }}</dd>

                @if($lote->medicamento->dosagem)
                <dt class="col-5 text-muted">Dosagem</dt>
                <dd class="col-7">{{ $lote->medicamento->dosagem }}</dd>
                @endif

                <dt class="col-5 text-muted">Nº Lote</dt>
                <dd class="col-7 font-monospace">{{ $lote->lote }}</dd>

                <dt class="col-5 text-muted">Validade</dt>
                <dd class="col-7 {{ $lote->validade->isPast() ? 'text-danger fw-bold' : '' }}">
                    {{ $lote->validade->format('d/m/Y') }}
                    @if($lote->validade->isPast()) <small>(VENCIDO)</small> @endif
                </dd>

                <dt class="col-5 text-muted">Data Entrada</dt>
                <dd class="col-7">{{ $lote->data_entrada->format('d/m/Y') }}</dd>

                <dt class="col-5 text-muted">Qtd Inicial</dt>
                <dd class="col-7">{{ $lote->quantidade_inicial }}</dd>

                <dt class="col-5 text-muted">Qtd Atual</dt>
                <dd class="col-7">
                    <span class="fw-bold fs-5 {{ $lote->quantidade_atual <= 0 ? 'text-danger' : ($lote->quantidade_atual <= 10 ? 'text-warning' : 'text-success') }}">
                        {{ $lote->quantidade_atual }}
                    </span>
                    <span class="text-muted">/ {{ $lote->quantidade_inicial }}</span>
                </dd>

                <dt class="col-5 text-muted">Dispensados</dt>
                <dd class="col-7">{{ $lote->quantidade_inicial - $lote->quantidade_atual }}</dd>
            </dl>
            @if($lote->observacoes)
            <hr>
            <p class="small text-muted mb-0">{{ $lote->observacoes }}</p>
            @endif
        </div>

        {{-- Barra de progresso --}}
        <div class="card p-4">
            <h6 class="section-title">Consumo</h6>
            @php
                $pct = $lote->quantidade_inicial > 0
                    ? round(($lote->quantidade_inicial - $lote->quantidade_atual) / $lote->quantidade_inicial * 100)
                    : 0;
                $cor = $pct >= 90 ? 'danger' : ($pct >= 70 ? 'warning' : 'success');
            @endphp
            <div class="progress" style="height:16px">
                <div class="progress-bar bg-{{ $cor }}" style="width:{{ $pct }}%">{{ $pct }}%</div>
            </div>
            <div class="d-flex justify-content-between mt-1">
                <small class="text-muted">{{ $lote->quantidade_inicial - $lote->quantidade_atual }} dispensados</small>
                <small class="text-muted">{{ $lote->quantidade_atual }} restantes</small>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Dispensações deste Lote ({{ $lote->recibos->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Nº Recibo</th>
                            <th>Paciente</th>
                            <th>Processo</th>
                            <th class="text-center">Qtd</th>
                            <th>Mês Ref.</th>
                            <th>Data</th>
                            <th class="pe-3 text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lote->recibos as $recibo)
                        <tr>
                            <td class="ps-3 fw-bold font-monospace">{{ $recibo->numero }}</td>
                            <td>{{ $recibo->processo->paciente->nome }}</td>
                            <td>
                                <a href="{{ route('processos.show', $recibo->processo) }}" class="text-decoration-none font-monospace small">
                                    {{ $recibo->processo->numero }}
                                </a>
                            </td>
                            <td class="text-center">{{ $recibo->quantidade }}</td>
                            <td class="small text-muted">{{ $recibo->mes_referencia?->format('m/Y') ?? '—' }}</td>
                            <td class="small text-muted">{{ $recibo->data_emissao->format('d/m/Y') }}</td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('recibos.show', $recibo) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhuma dispensação registrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:.75rem; }</style>
@endpush
</x-app-layout>
