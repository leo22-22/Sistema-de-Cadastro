<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h4 class="mb-1"><i class="bi bi-person me-2"></i>{{ $paciente->nome }}</h4>
        <div class="d-flex gap-2 flex-wrap">
            @if($paciente->prontuario)<span class="badge bg-secondary">Prontuário: {{ $paciente->prontuario }}</span>@endif
            @if($paciente->cns)<span class="badge bg-info text-dark">CNS: {{ $paciente->cns }}</span>@endif
            <span class="badge {{ $paciente->ativo ? 'bg-success' : 'bg-secondary' }}">{{ $paciente->ativo ? 'Ativo' : 'Inativo' }}</span>
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('processos.create', ['paciente_id' => $paciente->id]) }}" class="btn btn-primary btn-sm">
            <i class="bi bi-folder-plus me-1"></i>Novo Processo
        </a>
        <a href="{{ route('pacientes.edit', $paciente) }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil me-1"></i>Editar
        </a>
        @if(auth()->user()->isAdminFarmacia() || auth()->user()->isSuperadmin())
        <a href="{{ route('lgpd.exportar', $paciente) }}" class="btn btn-outline-secondary btn-sm" title="Exportar dados pessoais (LGPD)">
            <i class="bi bi-download me-1"></i>LGPD
        </a>
        @endif
    </div>
</div>

@if($paciente->alergias->where('gravidade', 'grave')->count() > 0)
<div class="alert alert-danger d-flex align-items-center gap-2 mb-3 py-2" role="alert">
    <i class="bi bi-exclamation-octagon-fill fs-5"></i>
    <div>
        <strong>ATENÇÃO:</strong> Paciente possui
        <strong>{{ $paciente->alergias->where('gravidade', 'grave')->count() }} alergia(s) grave(s)</strong>:
        {{ $paciente->alergias->where('gravidade', 'grave')->pluck('descricao')->implode(', ') }}
    </div>
</div>
@endif

<div class="row g-4">
    {{-- Coluna esquerda: dados --}}
    <div class="col-lg-4">

        {{-- Dados pessoais --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Dados Pessoais</h6>
            <dl class="row mb-0 small">
                <dt class="col-5 text-muted">Nome da Mãe</dt>
                <dd class="col-7">{{ $paciente->nome_mae ?? '—' }}</dd>

                <dt class="col-5 text-muted">Data Nasc.</dt>
                <dd class="col-7">
                    {{ $paciente->data_nascimento ? $paciente->data_nascimento->format('d/m/Y') : '—' }}
                    @if($paciente->idade) <span class="text-muted">({{ $paciente->idade }} anos)</span> @endif
                </dd>

                <dt class="col-5 text-muted">CPF</dt>
                <dd class="col-7">{{ $paciente->cpf ?? '—' }}</dd>

                <dt class="col-5 text-muted">RG</dt>
                <dd class="col-7">{{ $paciente->rg ?? '—' }}</dd>

                <dt class="col-5 text-muted">CNS</dt>
                <dd class="col-7">{{ $paciente->cns ?? '—' }}</dd>

                <dt class="col-5 text-muted">Raça/Cor</dt>
                <dd class="col-7">{{ \App\Models\Paciente::$racaCorLabels[$paciente->raca_cor] ?? '—' }}</dd>

                <dt class="col-5 text-muted">Peso</dt>
                <dd class="col-7">{{ $paciente->peso ? $paciente->peso . ' kg' : '—' }}</dd>

                <dt class="col-5 text-muted">Altura</dt>
                <dd class="col-7">{{ $paciente->altura ? $paciente->altura . ' cm' : '—' }}</dd>

                <dt class="col-5 text-muted">Telefone</dt>
                <dd class="col-7">{{ $paciente->telefone ?? '—' }}</dd>

                <dt class="col-5 text-muted">E-mail</dt>
                <dd class="col-7">{{ $paciente->email ?? '—' }}</dd>
            </dl>
        </div>

        {{-- Endereço --}}
        <div class="card p-4 mb-3">
            <h6 class="section-title">Endereço</h6>
            @if($paciente->logradouro || $paciente->cidade)
                <p class="small mb-1">
                    {{ $paciente->logradouro }}
                    @if($paciente->numero_endereco), nº {{ $paciente->numero_endereco }}@endif
                    @if($paciente->complemento) — {{ $paciente->complemento }}@endif
                </p>
                @if($paciente->bairro)<p class="small mb-1 text-muted">{{ $paciente->bairro }}</p>@endif
                <p class="small mb-1">{{ $paciente->cidade }}@if($paciente->uf)/{{ $paciente->uf }}@endif</p>
                @if($paciente->cep)<p class="small mb-0 text-muted">CEP: {{ $paciente->cep }}</p>@endif
            @else
                <p class="text-muted small mb-0">Endereço não informado.</p>
            @endif
        </div>

        {{-- Alergias e Intolerâncias --}}
        <div class="card p-4 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="section-title mb-0"><i class="bi bi-exclamation-triangle text-danger me-1"></i>Alergias / Intolerâncias</h6>
            </div>

            @forelse($paciente->alergias as $alergia)
            <div class="d-flex justify-content-between align-items-start mb-2 pb-2 border-bottom">
                <div>
                    <span class="badge {{ $alergia->gravidade_badge }} me-1" style="font-size:.62rem">{{ $alergia->gravidade_label }}</span>
                    <span class="badge bg-light text-dark border me-1" style="font-size:.62rem">{{ $alergia->tipo_label }}</span>
                    <span class="small fw-semibold">{{ $alergia->descricao }}</span>
                    @if($alergia->reacao)
                    <br><small class="text-muted"><i class="bi bi-arrow-return-right me-1"></i>{{ $alergia->reacao }}</small>
                    @endif
                </div>
                <form action="{{ route('alergias.destroy', [$paciente, $alergia]) }}" method="POST" class="ms-2">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger py-0 px-1" title="Remover"><i class="bi bi-x"></i></button>
                </form>
            </div>
            @empty
            <p class="text-muted small mb-2">Nenhuma alergia registrada.</p>
            @endforelse

            <form action="{{ route('alergias.store', $paciente) }}" method="POST" class="mt-2">
                @csrf
                <div class="row g-2">
                    <div class="col-6">
                        <select name="tipo" class="form-select form-select-sm" required>
                            <option value="">Tipo...</option>
                            @foreach(\App\Models\Alergia::$tipos as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <select name="gravidade" class="form-select form-select-sm" required>
                            <option value="">Gravidade...</option>
                            @foreach(\App\Models\Alergia::$gravidadeLabels as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="text" name="descricao" class="form-control form-control-sm" placeholder="Descrição (ex: Amoxicilina)" required>
                    </div>
                    <div class="col-12">
                        <input type="text" name="reacao" class="form-control form-control-sm" placeholder="Reação (opcional)">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                            <i class="bi bi-plus me-1"></i>Adicionar Alergia
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Declaração autorizadora / Representantes --}}
        <div class="card p-4">
            <h6 class="section-title">
                Declaração Autorizadora
                @if($paciente->sem_representante)
                    <span class="badge bg-warning text-dark ms-1" style="font-size:.65rem">Sem representante</span>
                @endif
            </h6>

            @if($paciente->sem_representante)
                <p class="small text-muted mb-2">Paciente declarou não querer representantes.</p>
            @endif

            @forelse($paciente->representantes as $rep)
            <div class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom">
                <div>
                    <span class="badge bg-secondary me-1" style="font-size:.65rem">{{ $loop->iteration }}º</span>
                    <strong class="small">{{ $rep->nome }}</strong><br>
                    @if($rep->cpf)<small class="text-muted">CPF: {{ $rep->cpf }}</small><br>@endif
                    @if($rep->telefone)<small class="text-muted"><i class="bi bi-telephone me-1"></i>{{ $rep->telefone }}</small>@endif
                </div>
                <form action="{{ route('pacientes.desvincularRepresentante', [$paciente, $rep]) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" title="Desvincular"><i class="bi bi-x"></i></button>
                </form>
            </div>
            @empty
            <p class="text-muted small">Nenhum representante vinculado.</p>
            @endforelse

            @if(!$paciente->sem_representante && $paciente->representantes->count() < 3)
            <form action="{{ route('pacientes.vincularRepresentante', $paciente) }}" method="POST" class="mt-2">
                @csrf
                <label class="form-label small fw-semibold text-muted">Vincular Representante</label>
                <div class="input-group input-group-sm">
                    <select name="representante_id" class="form-select" required>
                        <option value="">Selecionar...</option>
                        @foreach($representantesDisponiveis->whereNotIn('id', $paciente->representantes->pluck('id')) as $r)
                        <option value="{{ $r->id }}">{{ $r->nome }}{{ $r->cpf ? ' (' . $r->cpf . ')' : '' }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-outline-primary">Vincular</button>
                </div>
            </form>
            @endif
        </div>
    </div>

    {{-- Coluna direita: processos + dispensações --}}
    <div class="col-lg-8">
        {{-- Processos --}}
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-bold">Processos ({{ $paciente->processos->count() }})</h6>
                <a href="{{ route('processos.create', ['paciente_id' => $paciente->id]) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Novo
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Número</th>
                            <th>CID / Doença</th>
                            <th>Tipo</th>
                            <th>Abertura</th>
                            <th class="text-center">APAC</th>
                            <th class="text-center">Status</th>
                            <th class="pe-3 text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paciente->processos as $proc)
                        <tr>
                            <td class="ps-3 fw-bold">{{ $proc->numero }}</td>
                            <td>
                                @if($proc->cid10)
                                <span class="badge bg-light text-dark border">{{ $proc->cid10->codigo }}</span>
                                <br><small class="text-muted">{{ Str::limit($proc->cid10->nome, 30) }}</small>
                                @else —
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border" style="font-size:.7rem">
                                    {{ \App\Models\Processo::$tiposProcesso[$proc->tipo_processo] ?? $proc->tipo_processo }}
                                </span>
                            </td>
                            <td class="small text-muted">{{ $proc->created_at->format('d/m/Y') }}</td>
                            <td class="text-center small">
                                @if($proc->validade_apac)
                                    @if($proc->validade_apac->isPast())
                                        <span class="text-danger fw-bold">{{ $proc->validade_apac->format('d/m/Y') }}<br><small>VENCIDA</small></span>
                                    @else
                                        <span class="text-success">{{ $proc->validade_apac->format('d/m/Y') }}</span>
                                    @endif
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $proc->statusBadgeClass() }}">{{ $proc->statusLabel() }}</span>
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('processos.show', $proc) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Nenhum processo cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Histórico de Dispensações --}}
        @php
            $todasDispensacoes = $paciente->processos->flatMap(fn($p) => $p->recibos->map(fn($r) => ['recibo' => $r, 'processo' => $p]))->sortByDesc(fn($item) => $item['recibo']->created_at);
        @endphp
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>Histórico de Dispensações ({{ $todasDispensacoes->count() }})</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-3">Data</th>
                            <th>Medicamento</th>
                            <th>Processo</th>
                            <th class="text-center">Qtd</th>
                            <th>Mês Ref.</th>
                            <th class="pe-3 text-end">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todasDispensacoes as $item)
                        @php $recibo = $item['recibo']; $proc = $item['processo']; @endphp
                        <tr>
                            <td class="ps-3 small text-muted">{{ $recibo->created_at->format('d/m/Y') }}</td>
                            <td class="fw-semibold small">{{ $recibo->medicamento->nome }}</td>
                            <td><span class="badge bg-light text-dark border font-monospace" style="font-size:.7rem">{{ $proc->numero }}</span></td>
                            <td class="text-center small">{{ $recibo->quantidade }}</td>
                            <td class="small text-muted">
                                {{ $recibo->mes_referencia ? \Carbon\Carbon::parse($recibo->mes_referencia)->translatedFormat('M/Y') : '—' }}
                            </td>
                            <td class="pe-3 text-end">
                                <a href="{{ route('recibos.show', $recibo) }}" class="btn btn-sm btn-outline-primary" title="Ver recibo">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">Nenhuma dispensação registrada.</td></tr>
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
