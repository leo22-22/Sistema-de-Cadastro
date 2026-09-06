<x-app-layout>
<div class="page-header">
    <h4><i class="bi bi-bar-chart-line me-2"></i>Relatórios — Visão da Plataforma</h4>
    <small class="text-muted">Métricas agregadas de todas as farmácias do sistema.</small>
</div>

{{-- KPIs --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-primary border-4">
            <div class="text-muted small">Farmácias</div>
            <div class="fs-3 fw-bold">{{ $totalFarmacias }}</div>
            <span class="small text-muted">{{ $farmaciasAtivas }} ativas · {{ $farmaciasInativas }} inativas</span>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-info border-4">
            <div class="text-muted small">Usuários</div>
            <div class="fs-3 fw-bold">{{ $totalUsuarios }}</div>
            <span class="small text-muted">Todas as farmácias</span>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-warning border-4">
            <div class="text-muted small">Processos</div>
            <div class="fs-3 fw-bold">{{ $totalProcessos }}</div>
            <span class="small text-muted">Todas as farmácias</span>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-success border-4">
            <div class="text-muted small">Dispensações</div>
            <div class="fs-3 fw-bold">{{ $totalRecibos }}</div>
            <span class="small text-muted">Todas as farmácias</span>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-danger border-4">
            <div class="text-muted small">Medicamentos</div>
            <div class="fs-3 fw-bold">{{ $totalMedicamentos }}</div>
            <span class="small text-muted">Catálogos somados</span>
        </div>
    </div>
</div>

{{-- Crescimento de farmácias --}}
@php
    $maxTotal = max(1, $crescimentoMensal->max('total'));
    $largura = 760; $altura = 160; $fatia = $largura / count($crescimentoMensal); $gap = 2;
@endphp
<div class="card p-4 mb-4">
    <h6 class="fw-semibold mb-3" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.06em;color:#64748b;">
        Farmácias cadastradas — últimos 12 meses
    </h6>
    <div style="overflow-x:auto;">
        <svg viewBox="0 0 {{ $largura }} {{ $altura + 24 }}" style="width:100%;max-width:{{ $largura }}px;height:auto;" role="img" aria-label="Farmácias cadastradas por mês, últimos 12 meses">
            <line x1="0" y1="{{ $altura }}" x2="{{ $largura }}" y2="{{ $altura }}" stroke="#e2e8f0" stroke-width="1"></line>
            @foreach($crescimentoMensal as $chave => $ponto)
                @php
                    $x = $loop->index * $fatia;
                    $barW = max(4, $fatia - $gap);
                    $barH = $ponto['total'] > 0 ? max(4, ($ponto['total'] / $maxTotal) * ($altura - 8)) : 0;
                    $y = $altura - $barH;
                @endphp
                <g>
                    @if($barH > 0)
                    <rect x="{{ $x + $gap/2 }}" y="{{ $y }}" width="{{ $barW }}" height="{{ $barH }}" rx="4" fill="#3b82f6">
                        <title>{{ $ponto['label'] }}: {{ $ponto['total'] }} farmácia(s)</title>
                    </rect>
                    @else
                    <rect x="{{ $x + $gap/2 }}" y="{{ $altura - 2 }}" width="{{ $barW }}" height="2" rx="1" fill="#e2e8f0">
                        <title>{{ $ponto['label'] }}: 0 farmácias</title>
                    </rect>
                    @endif
                    <text x="{{ $x + $fatia/2 }}" y="{{ $altura + 16 }}" text-anchor="middle" font-size="10" fill="#94a3b8">{{ $ponto['label'] }}</text>
                </g>
            @endforeach
        </svg>
    </div>
    <table class="visually-hidden">
        <caption>Farmácias cadastradas por mês</caption>
        <thead><tr><th>Mês</th><th>Total</th></tr></thead>
        <tbody>
            @foreach($crescimentoMensal as $ponto)
            <tr><td>{{ $ponto['label'] }}</td><td>{{ $ponto['total'] }}</td></tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Farmácias mais ativas --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold" style="font-size:.875rem;"><i class="bi bi-hospital me-2 text-primary"></i>Farmácias por Atividade</span>
        <a href="{{ route('farmacias.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Nome</th>
                    <th class="text-center">Usuários</th>
                    <th class="text-center">Processos</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($farmaciasTop as $f)
                <tr>
                    <td class="ps-3 fw-semibold">{{ $f->nome }}</td>
                    <td class="text-center"><span class="badge bg-secondary">{{ $f->users_count }}</span></td>
                    <td class="text-center"><span class="badge bg-primary">{{ $f->processos_count }}</span></td>
                    <td class="text-center">
                        <span class="badge {{ $f->ativo ? 'bg-success' : 'bg-secondary' }}">
                            {{ $f->ativo ? 'Ativa' : 'Inativa' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Nenhuma farmácia cadastrada ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
