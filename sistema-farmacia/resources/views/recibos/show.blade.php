<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-receipt me-2"></i>Recibo {{ $recibo->numero }}</h4>
    <div class="d-flex gap-2">
        <a href="{{ route('recibos.imprimir', $recibo) }}" class="btn btn-outline-secondary btn-sm" target="_blank">
            <i class="bi bi-printer me-1"></i>Imprimir
        </a>
        <a href="{{ route('processos.show', $recibo->processo) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-folder2-open me-1"></i>Ver Processo
        </a>
        <form action="{{ route('recibos.destroy', $recibo) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Estornar este recibo? O estoque será restaurado.')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-arrow-counterclockwise me-1"></i>Estornar</button>
        </form>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card p-4">
            {{-- Cabeçalho --}}
            <div class="row mb-4 align-items-start">
                <div class="col-7">
                    <h5 class="fw-bold mb-0">GovSaúde</h5>
                    <p class="text-muted small mb-0">Componente Especializado da Assistência Farmacêutica</p>
                </div>
                <div class="col-5 text-end">
                    <span class="badge bg-success fs-6">RECIBO DE DISPENSAÇÃO</span>
                    <p class="text-muted small mb-0 mt-1">Nº {{ $recibo->numero }}</p>
                    <p class="text-muted small mb-0">Emitido em {{ $recibo->data_emissao->format('d/m/Y') }}</p>
                </div>
            </div>

            <hr>

            {{-- Paciente --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="text-muted small mb-0 text-uppercase fw-semibold" style="font-size:.72rem">Paciente</p>
                    <p class="fw-bold mb-0">{{ $recibo->processo->paciente->nome }}</p>
                    @if($recibo->processo->paciente->nome_mae)
                    <p class="text-muted small mb-0">Mãe: {{ $recibo->processo->paciente->nome_mae }}</p>
                    @endif
                    @if($recibo->processo->paciente->data_nascimento)
                    <p class="text-muted small mb-0">DN: {{ $recibo->processo->paciente->data_nascimento->format('d/m/Y') }}</p>
                    @endif
                    @if($recibo->processo->paciente->cns)
                    <p class="text-muted small mb-0">CNS: {{ $recibo->processo->paciente->cns }}</p>
                    @endif
                    @if($recibo->processo->paciente->cpf)
                    <p class="text-muted small mb-0">CPF: {{ $recibo->processo->paciente->cpf }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    @if($recibo->retirado_por_representante && $recibo->representante)
                    <p class="text-muted small mb-0 text-uppercase fw-semibold" style="font-size:.72rem">Retirado por (Representante)</p>
                    <p class="fw-bold mb-0">{{ $recibo->representante->nome }}</p>
                    @if($recibo->representante->cpf)
                    <p class="text-muted small mb-0">CPF: {{ $recibo->representante->cpf }}</p>
                    @endif
                    @if($recibo->representante->rg)
                    <p class="text-muted small mb-0">RG: {{ $recibo->representante->rg }}</p>
                    @endif
                    @else
                    <p class="text-muted small mb-0 text-uppercase fw-semibold" style="font-size:.72rem">Retirado por</p>
                    <p class="fw-bold mb-0">Paciente</p>
                    @endif
                </div>
            </div>

            {{-- Processo e CID --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="text-muted small mb-0 text-uppercase fw-semibold" style="font-size:.72rem">Processo</p>
                    <p class="mb-0">
                        <span class="font-monospace fw-bold">{{ $recibo->processo->numero }}</span>
                        @if($recibo->processo->tipoReceita)
                        &nbsp;<span class="badge bg-{{ $recibo->processo->tipoReceita->cor ?? 'secondary' }}">{{ $recibo->processo->tipoReceita->nome }}</span>
                        @endif
                    </p>
                </div>
                @if($recibo->processo->cid10)
                <div class="col-md-6">
                    <p class="text-muted small mb-0 text-uppercase fw-semibold" style="font-size:.72rem">CID-10</p>
                    <p class="mb-0"><span class="badge bg-dark me-1">{{ $recibo->processo->cid10->codigo }}</span>{{ $recibo->processo->cid10->nome }}</p>
                </div>
                @endif
            </div>

            {{-- Medicamento dispensado --}}
            <div class="mb-3">
                <p class="text-muted small mb-1 text-uppercase fw-semibold" style="font-size:.72rem">Medicamento Dispensado</p>
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Medicamento</th>
                            <th class="text-center" width="80">Qtd</th>
                            <th>Mês Ref.</th>
                            <th>Lote</th>
                            <th>Val. APAC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-semibold">
                                {{ $recibo->medicamento->nome ?? '—' }}
                                @if($recibo->medicamento?->dosagem)
                                <br><small class="text-muted">{{ $recibo->medicamento->dosagem }}</small>
                                @endif
                            </td>
                            <td class="text-center">{{ $recibo->quantidade }}</td>
                            <td class="small">{{ $recibo->mes_referencia?->format('m/Y') ?? '—' }}</td>
                            <td class="small">{{ $recibo->lote?->lote ?? '—' }}</td>
                            <td class="small {{ $recibo->validade_apac?->isPast() ? 'text-danger fw-bold' : 'text-success' }}">
                                {{ $recibo->validade_apac?->format('d/m/Y') ?? '—' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($recibo->observacoes)
            <div class="mb-3">
                <p class="text-muted small mb-1 text-uppercase fw-semibold" style="font-size:.72rem">Observações</p>
                <p class="text-muted mb-0">{{ $recibo->observacoes }}</p>
            </div>
            @endif

            <hr>
            <p class="text-muted small text-end mb-0">
                Gerado por {{ $recibo->geradoPor->name }} em {{ $recibo->created_at->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>
</div>
</x-app-layout>
