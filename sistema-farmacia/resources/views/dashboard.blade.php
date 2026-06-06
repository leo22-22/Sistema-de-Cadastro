<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
        <small class="text-muted">Bem-vindo, {{ auth()->user()->name }}</small>
    </div>
    <a href="{{ route('processos.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Novo Processo
    </a>
</div>

{{-- Métricas --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-4 col-xl-2">
        <a href="{{ route('pacientes.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(79,70,229,.12)">
                    <i class="bi bi-people-fill" style="color:#4f46e5"></i>
                </div>
                <div>
                    <div class="stat-value" data-count="{{ $totalPacientes }}">{{ $totalPacientes }}</div>
                    <div class="stat-label">Pacientes</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 col-xl-2">
        <a href="{{ route('processos.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(100,116,139,.12)">
                    <i class="bi bi-folder2-open" style="color:#475569"></i>
                </div>
                <div>
                    <div class="stat-value" data-count="{{ $totalProcessos }}">{{ $totalProcessos }}</div>
                    <div class="stat-label">Processos</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 col-xl-2">
        <a href="{{ route('processos.index', ['status' => 'aberto']) }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(6,182,212,.12)">
                    <i class="bi bi-folder-open" style="color:#0891b2"></i>
                </div>
                <div>
                    <div class="stat-value" style="color:#0891b2" data-count="{{ $processosAbertos }}">{{ $processosAbertos }}</div>
                    <div class="stat-label">Abertos</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 col-xl-2">
        <a href="{{ route('processos.index', ['status' => 'em_andamento']) }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(245,158,11,.12)">
                    <i class="bi bi-arrow-repeat" style="color:#d97706"></i>
                </div>
                <div>
                    <div class="stat-value" style="color:#d97706" data-count="{{ $processosEmAndamento }}">{{ $processosEmAndamento }}</div>
                    <div class="stat-label">Em Andamento</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 col-xl-2">
        <a href="{{ route('processos.index', ['status' => 'concluido']) }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(16,185,129,.12)">
                    <i class="bi bi-check-circle-fill" style="color:#059669"></i>
                </div>
                <div>
                    <div class="stat-value" style="color:#059669" data-count="{{ $processosConcluidos }}">{{ $processosConcluidos }}</div>
                    <div class="stat-label">Concluídos</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-4 col-xl-2">
        <a href="{{ route('recibos.index') }}" class="text-decoration-none">
            <div class="stat-card">
                <div class="stat-icon-wrap" style="background:rgba(124,58,237,.12)">
                    <i class="bi bi-receipt" style="color:#7c3aed"></i>
                </div>
                <div>
                    <div class="stat-value" style="color:#7c3aed" data-count="{{ $totalRecibos }}">{{ $totalRecibos }}</div>
                    <div class="stat-label">Dispensações</div>
                </div>
            </div>
        </a>
    </div>
</div>

{{-- Alertas: APACs vencidas/vencendo --}}
@if($apacAlerta->count())
<div class="alert alert-warning border-warning d-flex align-items-start gap-3 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-5 mt-1"></i>
    <div>
        <strong>{{ $apacAlerta->count() }} processo(s) com APAC vencida ou vencendo em 30 dias:</strong>
        <div class="mt-1 d-flex flex-wrap gap-1">
            @foreach($apacAlerta->take(8) as $p)
            <a href="{{ route('processos.show', $p) }}" class="badge bg-warning text-dark text-decoration-none">
                {{ $p->numero }} — {{ $p->paciente->nome }} ({{ $p->validade_apac->format('d/m/Y') }})
            </a>
            @endforeach
            @if($apacAlerta->count() > 8)
            <span class="badge bg-secondary">+{{ $apacAlerta->count() - 8 }} mais</span>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Alertas: Lotes vencendo em 30 dias --}}
@if($lotesVencendo30->count())
<div class="alert alert-danger border-danger d-flex align-items-start gap-3 mb-3">
    <i class="bi bi-exclamation-octagon-fill fs-5 mt-1"></i>
    <div>
        <strong>{{ $lotesVencendo30->count() }} lote(s) vencem em até 30 dias:</strong>
        <div class="mt-1 d-flex flex-wrap gap-1">
            @foreach($lotesVencendo30->take(6) as $l)
            <a href="{{ route('lotes.show', $l) }}" class="badge bg-danger text-decoration-none">
                {{ $l->medicamento->nome }} — Lote {{ $l->lote }} ({{ $l->validade->format('d/m/Y') }})
            </a>
            @endforeach
            @if($lotesVencendo30->count() > 6)<span class="badge bg-secondary">+{{ $lotesVencendo30->count() - 6 }} mais</span>@endif
        </div>
    </div>
</div>
@endif

@if($lotesVencendo90->count())
<div class="alert alert-warning border-warning d-flex align-items-start gap-3 mb-3">
    <i class="bi bi-exclamation-triangle-fill fs-5 mt-1"></i>
    <div>
        <strong>{{ $lotesVencendo90->count() }} lote(s) vencem entre 31 e 90 dias:</strong>
        <div class="mt-1 d-flex flex-wrap gap-1">
            @foreach($lotesVencendo90->take(6) as $l)
            <a href="{{ route('lotes.show', $l) }}" class="badge bg-warning text-dark text-decoration-none">
                {{ $l->medicamento->nome }} — Lote {{ $l->lote }} ({{ $l->validade->format('d/m/Y') }})
            </a>
            @endforeach
            @if($lotesVencendo90->count() > 6)<span class="badge bg-secondary">+{{ $lotesVencendo90->count() - 6 }} mais</span>@endif
        </div>
    </div>
</div>
@endif

{{-- Processos recentes --}}
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0 fw-bold">Processos Recentes</h6>
        <a href="{{ route('processos.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Nº Processo</th>
                    <th>Paciente</th>
                    <th>CID-10</th>
                    <th>Tipo</th>
                    <th>APAC</th>
                    <th>Aberto por</th>
                    <th>Data</th>
                    <th class="text-center">Status</th>
                    <th class="pe-3 text-end">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentes as $processo)
                <tr>
                    <td class="ps-3 fw-bold font-monospace">{{ $processo->numero }}</td>
                    <td>{{ $processo->paciente->nome }}</td>
                    <td>
                        @if($processo->cid10)
                        <span class="badge bg-dark" style="font-size:.7rem" title="{{ $processo->cid10->nome }}">
                            {{ $processo->cid10->codigo }}
                        </span>
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
                            @elseif($processo->validade_apac->diffInDays(now()) <= 30)
                                <span class="text-warning fw-bold">{{ $processo->validade_apac->format('d/m/Y') }}</span>
                            @else
                                <span class="text-success">{{ $processo->validade_apac->format('d/m/Y') }}</span>
                            @endif
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $processo->criadoPor->name }}</td>
                    <td class="text-muted small">{{ $processo->created_at->format('d/m/Y') }}</td>
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
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">Nenhum processo cadastrado ainda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
