<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-speedometer2 me-2"></i>Painel da Plataforma</h4>
        <small class="text-muted">Bem-vindo, {{ auth()->user()->name }} — visão geral do sistema</small>
    </div>
    <a href="{{ route('farmacias.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Nova Farmácia
    </a>
</div>

{{-- Métricas da plataforma --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-primary border-4">
            <div class="text-muted small">Farmácias</div>
            <div class="fs-3 fw-bold">{{ $totalFarmacias }}</div>
            <a href="{{ route('farmacias.index') }}" class="small text-primary text-decoration-none">Gerenciar →</a>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-success border-4">
            <div class="text-muted small">Ativas</div>
            <div class="fs-3 fw-bold">{{ $farmaciasAtivas }}</div>
            <a href="{{ route('farmacias.index') }}" class="small text-success text-decoration-none">Ver todas →</a>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-info border-4">
            <div class="text-muted small">Usuários</div>
            <div class="fs-3 fw-bold">{{ $totalUsuarios }}</div>
            <a href="{{ route('usuarios.index') }}" class="small text-info text-decoration-none">Ver todos →</a>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-secondary border-4">
            <div class="text-muted small">Processos</div>
            <div class="fs-3 fw-bold">{{ $totalProcessos }}</div>
            <span class="small text-muted">Todas as farmácias</span>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-warning border-4">
            <div class="text-muted small">Dispensações</div>
            <div class="fs-3 fw-bold">{{ $totalRecibos }}</div>
            <span class="small text-muted">Todas as farmácias</span>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card p-3 border-start border-danger border-4">
            <div class="text-muted small">Medicamentos</div>
            <div class="fs-3 fw-bold">{{ $totalMedicamentos }}</div>
            <a href="{{ route('medicamentos.index') }}" class="small text-danger text-decoration-none">Catálogo →</a>
        </div>
    </div>
</div>

{{-- Acesso rápido --}}
<div class="row g-3 mb-4">
    <div class="col-12">
        <h6 class="text-muted fw-semibold mb-3" style="font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;">
            Acesso Rápido
        </h6>
    </div>
    <div class="col-md-3">
        <a href="{{ route('farmacias.create') }}" class="card p-3 text-decoration-none d-flex flex-row align-items-center gap-3 h-100" style="transition:box-shadow .15s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(59,130,246,.15)'" onmouseout="this.style.boxShadow=''">
            <div style="width:40px;height:40px;background:rgba(59,130,246,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-hospital text-primary fs-5"></i>
            </div>
            <div>
                <div class="fw-semibold text-dark" style="font-size:.875rem;">Nova Farmácia</div>
                <div class="text-muted" style="font-size:.78rem;">Cadastrar nova unidade</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('usuarios.create') }}" class="card p-3 text-decoration-none d-flex flex-row align-items-center gap-3 h-100" style="transition:box-shadow .15s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(59,130,246,.15)'" onmouseout="this.style.boxShadow=''">
            <div style="width:40px;height:40px;background:rgba(16,185,129,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-person-plus text-success fs-5"></i>
            </div>
            <div>
                <div class="fw-semibold text-dark" style="font-size:.875rem;">Novo Usuário</div>
                <div class="text-muted" style="font-size:.78rem;">Criar conta de acesso</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('medicamentos.index') }}" class="card p-3 text-decoration-none d-flex flex-row align-items-center gap-3 h-100" style="transition:box-shadow .15s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(59,130,246,.15)'" onmouseout="this.style.boxShadow=''">
            <div style="width:40px;height:40px;background:rgba(239,68,68,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-capsule text-danger fs-5"></i>
            </div>
            <div>
                <div class="fw-semibold text-dark" style="font-size:.875rem;">Medicamentos</div>
                <div class="text-muted" style="font-size:.78rem;">Gerenciar catálogo</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('usuarios.index') }}" class="card p-3 text-decoration-none d-flex flex-row align-items-center gap-3 h-100" style="transition:box-shadow .15s;" onmouseover="this.style.boxShadow='0 4px 16px rgba(59,130,246,.15)'" onmouseout="this.style.boxShadow=''">
            <div style="width:40px;height:40px;background:rgba(245,158,11,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-people-fill text-warning fs-5"></i>
            </div>
            <div>
                <div class="fw-semibold text-dark" style="font-size:.875rem;">Usuários</div>
                <div class="text-muted" style="font-size:.78rem;">Todos os usuários</div>
            </div>
        </a>
    </div>
</div>

{{-- Últimas farmácias cadastradas --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-semibold" style="font-size:.875rem;"><i class="bi bi-hospital me-2 text-primary"></i>Farmácias Cadastradas</span>
        <a href="{{ route('farmacias.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-3">Nome</th>
                    <th>Cidade / UF</th>
                    <th>CNES</th>
                    <th class="text-center">Usuários</th>
                    <th class="text-center">Status</th>
                    <th class="pe-3 text-end">Ação</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimasFarmacias as $f)
                <tr>
                    <td class="ps-3 fw-semibold">{{ $f->nome }}</td>
                    <td class="text-muted">{{ $f->cidade ? $f->cidade . ' / ' . $f->estado : '—' }}</td>
                    <td class="text-muted">{{ $f->cnes ?? '—' }}</td>
                    <td class="text-center"><span class="badge bg-secondary">{{ $f->users_count }}</span></td>
                    <td class="text-center">
                        <span class="badge {{ $f->ativo ? 'bg-success' : 'bg-secondary' }}">
                            {{ $f->ativo ? 'Ativa' : 'Inativa' }}
                        </span>
                    </td>
                    <td class="pe-3 text-end">
                        <a href="{{ route('farmacias.edit', $f) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhuma farmácia cadastrada ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
