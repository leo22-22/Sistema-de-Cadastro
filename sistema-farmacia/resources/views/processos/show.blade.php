<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4 class="mb-1"><i class="bi bi-folder2-open me-2"></i>Processo {{ $processo->numero }}</h4>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            <span class="badge {{ $processo->statusBadgeClass() }} fs-6">{{ $processo->statusLabel() }}</span>
            <span class="badge bg-light text-dark border" style="font-size:.75rem">
                {{ \App\Models\Processo::$tiposProcesso[$processo->tipo_processo] ?? $processo->tipo_processo }}
            </span>
            @if($processo->validade_apac)
                @if($processo->validade_apac->isPast())
                    <span class="badge bg-danger">APAC VENCIDA: {{ $processo->validade_apac->format('d/m/Y') }}</span>
                @else
                    <span class="badge bg-success">APAC válida até {{ $processo->validade_apac->format('d/m/Y') }}</span>
                @endif
            @endif
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        @if($processo->podeDispensarMedicamento())
        <a href="{{ route('recibos.create', $processo) }}" class="btn btn-success btn-sm">
            <i class="bi bi-capsule me-1"></i>Dispensar Medicamento
        </a>
        @endif

        @if($processo->status === 'aberto')
        <form action="{{ route('processos.status', $processo) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="em_andamento">
            <button type="submit" class="btn btn-warning btn-sm text-dark">
                <i class="bi bi-play-circle me-1"></i>Iniciar Atendimento
            </button>
        </form>
        @endif

        @if($processo->status === 'em_andamento')
        <form action="{{ route('processos.status', $processo) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="concluido">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="bi bi-check-circle me-1"></i>Concluir
            </button>
        </form>
        @endif

        @if($processo->podeCancelar())
        <form action="{{ route('processos.status', $processo) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="cancelado">
            <button type="submit" class="btn btn-outline-danger btn-sm"
                    onclick="return confirm('Cancelar este processo?')">
                <i class="bi bi-x-circle me-1"></i>Cancelar
            </button>
        </form>
        @endif

        @if(in_array($processo->status, ['aberto','em_andamento']))
        <a href="{{ route('processos.edit', $processo) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        @endif

        <form action="{{ route('processos.renovar', $processo) }}" method="POST"
              onsubmit="return confirm('Criar processo de renovação baseado neste?')">
            @csrf
            <button type="submit" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-arrow-repeat me-1"></i>Renovar
            </button>
        </form>
    </div>
</div>

<div class="row g-4">
    {{-- Coluna esquerda --}}
    <div class="col-lg-4">

        {{-- Paciente --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Paciente</h6>
            <p class="fw-bold mb-1">{{ $processo->paciente->nome }}</p>
            @if($processo->paciente->nome_mae)<p class="text-muted small mb-0">Mãe: {{ $processo->paciente->nome_mae }}</p>@endif
            @if($processo->paciente->data_nascimento)
            <p class="text-muted small mb-0">DN: {{ $processo->paciente->data_nascimento->format('d/m/Y') }}
                @if($processo->paciente->idade) ({{ $processo->paciente->idade }} anos) @endif
            </p>
            @endif
            @if($processo->paciente->cns)<p class="text-muted small mb-0">CNS: {{ $processo->paciente->cns }}</p>@endif
            @if($processo->paciente->cpf)<p class="text-muted small mb-0">CPF: {{ $processo->paciente->cpf }}</p>@endif
            @if($processo->paciente->peso)<p class="text-muted small mb-0">Peso: {{ $processo->paciente->peso }} kg | Altura: {{ $processo->paciente->altura }} cm</p>@endif
            <a href="{{ route('pacientes.show', $processo->paciente) }}" class="btn btn-sm btn-outline-primary mt-2">
                <i class="bi bi-person me-1"></i>Ver ficha
            </a>
        </div>

        {{-- Declaração autorizadora --}}
        @if($processo->paciente->representantes->count())
        <div class="card p-4 mb-3">
            <h6 class="section-title">Declaração Autorizadora</h6>
            @foreach($processo->paciente->representantes as $rep)
            <div class="d-flex align-items-start gap-2 mb-2">
                <span class="badge bg-secondary" style="font-size:.65rem;min-width:22px">{{ $loop->iteration }}º</span>
                <div>
                    <div class="fw-semibold small">{{ $rep->nome }}</div>
                    @if($rep->cpf)<div class="text-muted" style="font-size:.75rem">CPF: {{ $rep->cpf }}</div>@endif
                    @if($rep->telefone)<div class="text-muted" style="font-size:.75rem"><i class="bi bi-telephone me-1"></i>{{ $rep->telefone }}</div>@endif
                </div>
            </div>
            @endforeach
        </div>
        @elseif($processo->paciente->sem_representante)
        <div class="card p-4 mb-3">
            <h6 class="section-title">Declaração Autorizadora</h6>
            <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i>Paciente declarou não querer representantes.</p>
        </div>
        @endif

        {{-- CID-10 --}}
        @if($processo->cid10)
        <div class="card p-4 mb-3">
            <h6 class="section-title">CID-10 / Patologia</h6>
            <span class="badge bg-dark mb-1">{{ $processo->cid10->codigo }}</span>
            <p class="mb-0 small">{{ $processo->cid10->nome }}</p>
        </div>
        @endif

        {{-- Médico prescritor --}}
        @if($processo->medicoPrescritor)
        <div class="card p-4 mb-3">
            <h6 class="section-title">Médico Prescritor</h6>
            <p class="fw-bold mb-1">{{ $processo->medicoPrescritor->nome }}</p>
            <dl class="row mb-0 small">
                @if($processo->medicoPrescritor->crm)
                <dt class="col-5 text-muted">CRM</dt>
                <dd class="col-7">{{ $processo->medicoPrescritor->crm }}</dd>
                @endif
                @if($processo->medicoPrescritor->cns)
                <dt class="col-5 text-muted">CNS</dt>
                <dd class="col-7">{{ $processo->medicoPrescritor->cns }}</dd>
                @endif
                @if($processo->medicoPrescritor->cnes)
                <dt class="col-5 text-muted">CNES</dt>
                <dd class="col-7">{{ $processo->medicoPrescritor->cnes }}</dd>
                @endif
                @if($processo->medicoPrescritor->estabelecimento)
                <dt class="col-5 text-muted">Estabelecimento</dt>
                <dd class="col-7">{{ $processo->medicoPrescritor->estabelecimento }}</dd>
                @endif
                @if($processo->medicoPrescritor->especialidade)
                <dt class="col-5 text-muted">Especialidade</dt>
                <dd class="col-7">{{ $processo->medicoPrescritor->especialidade }}</dd>
                @endif
                @if($processo->medicoPrescritor->telefone)
                <dt class="col-5 text-muted">Telefone</dt>
                <dd class="col-7">{{ $processo->medicoPrescritor->telefone }}</dd>
                @endif
            </dl>
        </div>
        @endif

        {{-- Dados da receita --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados da Receita</h6>
            <dl class="row mb-0 small">
                @if($processo->tipoReceita)
                <dt class="col-5 text-muted">Tipo</dt>
                <dd class="col-7">
                    <span class="badge bg-{{ $processo->tipoReceita->cor ?? 'secondary' }}">{{ $processo->tipoReceita->nome }}</span>
                    @if($processo->tipoReceita->requer_retencao)
                    <span class="badge bg-warning text-dark ms-1" style="font-size:.65rem">Retenção</span>
                    @endif
                </dd>
                @endif
                <dt class="col-5 text-muted">Nº Receita</dt>
                <dd class="col-7">{{ $processo->numero_receita ?? '—' }}</dd>
                <dt class="col-5 text-muted">Data</dt>
                <dd class="col-7">{{ $processo->data_receita?->format('d/m/Y') ?? '—' }}</dd>
                <dt class="col-5 text-muted">Validade</dt>
                <dd class="col-7">
                    @if($processo->data_validade_receita)
                        <span class="{{ $processo->data_validade_receita->isPast() ? 'text-danger fw-bold' : '' }}">
                            {{ $processo->data_validade_receita->format('d/m/Y') }}
                            @if($processo->data_validade_receita->isPast()) <small>(VENCIDA)</small> @endif
                        </span>
                    @else —
                    @endif
                </dd>
                @if($processo->tipoRelacaoRemessa)
                <dt class="col-5 text-muted">Remessa</dt>
                <dd class="col-7">{{ $processo->tipoRelacaoRemessa->nome }}</dd>
                @endif
                <dt class="col-5 text-muted">1ª Retirada</dt>
                <dd class="col-7">{{ $processo->data_primeira_retirada?->format('d/m/Y') ?? '—' }}</dd>
                <dt class="col-5 text-muted">Validade APAC</dt>
                <dd class="col-7">
                    @if($processo->validade_apac)
                        <span class="{{ $processo->validade_apac->isPast() ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                            {{ $processo->validade_apac->format('d/m/Y') }}
                        </span>
                    @else <span class="text-muted">—</span> @endif
                </dd>
            </dl>
        </div>

        {{-- Documentos entregues --}}
        <div class="card p-4">
            <h6 class="section-title">Documentos</h6>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <span class="badge {{ $processo->lme_entregue ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi bi-{{ $processo->lme_entregue ? 'check' : 'x' }} me-1"></i>LME
                </span>
                <span class="badge {{ $processo->receita_entregue ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi bi-{{ $processo->receita_entregue ? 'check' : 'x' }} me-1"></i>Receita
                </span>
                <span class="badge {{ $processo->exame_entregue ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi bi-{{ $processo->exame_entregue ? 'check' : 'x' }} me-1"></i>Exame
                </span>
                <span class="badge {{ $processo->documentos_entregues ? 'bg-success' : 'bg-secondary' }}">
                    <i class="bi bi-{{ $processo->documentos_entregues ? 'check' : 'x' }} me-1"></i>Docs Pessoais
                </span>
            </div>

            {{-- Upload --}}
            <form action="{{ route('processos.documentos.upload', $processo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-2">
                    <div class="col-12">
                        <select name="tipo" class="form-select form-select-sm" required>
                            <option value="">Tipo de documento...</option>
                            <option value="lme">LME</option>
                            <option value="receita">Receita</option>
                            <option value="exame">Exame</option>
                            <option value="documento_pessoal">Documento Pessoal</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="file" name="arquivo" class="form-control form-control-sm" accept=".pdf,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-upload me-1"></i>Enviar Arquivo
                        </button>
                    </div>
                </div>
            </form>

            {{-- Lista de documentos --}}
            @if($processo->documentos->count())
            <div class="mt-3">
                @foreach($processo->documentos as $doc)
                <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                    <div>
                        <i class="bi bi-file-earmark me-1 text-muted"></i>
                        <span class="small">{{ $doc->nome_original }}</span>
                        <br>
                        <small class="text-muted">{{ $doc->tipo_label ?? $doc->tipo }}</small>
                    </div>
                    <form action="{{ route('processos.documentos.delete', [$processo, $doc]) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" title="Remover" onclick="return confirm('Remover arquivo?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    {{-- Coluna direita --}}
    <div class="col-lg-8">

        {{-- Medicamentos --}}
        <div class="card mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Medicamentos ({{ $processo->medicamentos->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Medicamento</th>
                            <th>Dosagem / Forma</th>
                            <th>Periodicidade</th>
                            <th class="text-center">Qtd/Dia</th>
                            <th class="text-center">Qtd Mensal</th>
                            <th>Posologia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($processo->medicamentos as $med)
                        <tr>
                            <td class="ps-3">
                                <span class="fw-bold">{{ $med->nome }}</span>
                                @if($med->dosagem)<br><small class="text-muted">{{ $med->dosagem }}</small>@endif
                            </td>
                            <td class="small text-muted">{{ $med->forma_label ?? '—' }}</td>
                            <td>
                                <span class="badge bg-light text-dark border" style="font-size:.7rem">
                                    {{ ucfirst($med->pivot->periodicidade ?? '—') }}
                                </span>
                            </td>
                            <td class="text-center small">{{ $med->pivot->quantidade_diaria ?? '—' }}</td>
                            <td class="text-center small">{{ $med->pivot->quantidade_mensal ?? '—' }}</td>
                            <td class="text-muted small">{{ $med->pivot->posologia ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recibos / Dispensações --}}
        <div class="card mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold">Dispensações / Recibos ({{ $processo->recibos->count() }})</h6>
                @if($processo->podeDispensarMedicamento())
                <a href="{{ route('recibos.create', $processo) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-lg me-1"></i>Nova Dispensação
                </a>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Nº Recibo</th>
                            <th>Medicamento</th>
                            <th>Mês Ref.</th>
                            <th class="text-center">Qtd</th>
                            <th>Retirado por</th>
                            <th>Data</th>
                            <th class="pe-3 text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($processo->recibos as $recibo)
                        <tr>
                            <td class="ps-3 fw-bold font-monospace">{{ $recibo->numero }}</td>
                            <td class="small">{{ $recibo->medicamento->nome ?? '—' }}</td>
                            <td class="small text-muted">{{ $recibo->mes_referencia?->format('m/Y') ?? '—' }}</td>
                            <td class="text-center small">{{ $recibo->quantidade }}</td>
                            <td class="small text-muted">
                                @if($recibo->retirado_por_representante && $recibo->representante)
                                    <i class="bi bi-person-badge me-1"></i>{{ $recibo->representante->nome }}
                                @else
                                    <i class="bi bi-person me-1"></i>Paciente
                                @endif
                            </td>
                            <td class="small text-muted">{{ $recibo->data_emissao->format('d/m/Y') }}</td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('recibos.imprimir', $recibo) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Imprimir">
                                    <i class="bi bi-printer"></i>
                                </a>
                                <a href="{{ route('recibos.show', $recibo) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-3">Nenhuma dispensação registrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Observações e metadados --}}
        <div class="card p-4">
            <h6 class="section-title">Informações do Processo</h6>
            <dl class="row small mb-0">
                <dt class="col-md-3 text-muted">Abertura</dt>
                <dd class="col-md-9">{{ $processo->created_at->format('d/m/Y H:i') }}</dd>
                <dt class="col-md-3 text-muted">Aberto por</dt>
                <dd class="col-md-9">{{ $processo->criadoPor->name }}</dd>
            </dl>
            @if($processo->observacoes)
            <hr>
            <p class="small text-muted mb-0">{{ $processo->observacoes }}</p>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:.75rem; }</style>
@endpush
</x-app-layout>
