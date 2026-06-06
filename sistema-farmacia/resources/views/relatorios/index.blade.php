<x-app-layout>
<div class="page-header">
    <h4><i class="bi bi-bar-chart-line me-2"></i>Relatórios</h4>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;background:rgba(16,185,129,.12);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-receipt fs-4 text-success"></i>
                </div>
                <h5 class="mb-0 fw-bold">Dispensações</h5>
            </div>
            <p class="text-muted small">Histórico de dispensações por período, medicamento ou paciente. Exportável em CSV ou PDF.</p>
            <a href="{{ route('relatorios.dispensacoes') }}" class="btn btn-success btn-sm mt-auto">
                <i class="bi bi-arrow-right me-1"></i>Gerar Relatório
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;background:rgba(59,130,246,.12);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-box-seam fs-4 text-primary"></i>
                </div>
                <h5 class="mb-0 fw-bold">Estoque</h5>
            </div>
            <p class="text-muted small">Posição de estoque por lote: quantidades, validades, vencidos e estoque baixo.</p>
            <a href="{{ route('relatorios.estoque') }}" class="btn btn-primary btn-sm mt-auto">
                <i class="bi bi-arrow-right me-1"></i>Gerar Relatório
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div style="width:48px;height:48px;background:rgba(245,158,11,.12);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-folder2-open fs-4 text-warning"></i>
                </div>
                <h5 class="mb-0 fw-bold">Processos</h5>
            </div>
            <p class="text-muted small">Lista de processos filtrados por status e período com CID e situação da APAC.</p>
            <a href="{{ route('relatorios.processos') }}" class="btn btn-warning btn-sm mt-auto text-dark">
                <i class="bi bi-arrow-right me-1"></i>Gerar Relatório
            </a>
        </div>
    </div>
</div>
</x-app-layout>
