@extends('layouts.app') 

@section('content')
<div class="container mt-5">
    <div class="row align-items-center py-5">
        <div class="col-lg-6">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold mb-3">SaaS de Alta Performance</span>
            <h1 class="display-4 fw-bold hero-title text-dark">Chega de Planilhas <span class="text-primary">Lentas e Confusas.</span></h1>
            <p class="lead text-muted mt-4">
                Abandone o Excel manual. O <strong>CorpFlow</strong> automatiza o cadastro, relatório e a exclusão de grandes volumes de dados com a velocidade que sua operação exige.
            </p>
            
            <div class="mt-4">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow-sm px-4 fw-bold">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Acessar o Sistema
                    </a>
                </div>
                <p class="text-muted mt-3 small">
                    <i class="bi bi-check-circle-fill text-success me-1"></i> Sem compromisso 
                    <span class="mx-2 text-silver">|</span> 
                    <i class="bi bi-check-circle-fill text-success me-1"></i> Acesso total às ferramentas
                </p>
            </div>
        </div>
        
        <div class="col-lg-6">
             <div class="p-5 bg-white rounded-4 shadow-lg border-0 text-center position-relative">
                 <div class="position-absolute top-0 start-50 translate-middle badge bg-danger rounded-pill px-4 py-2 shadow">
                    <i class="bi bi-file-earmark-excel-fill"></i> Excel substituído
                 </div>

                 <h2 class="display-4 fw-bold text-primary mt-3">99.9%</h2>
                 <p class="text-dark fw-bold fs-5">Mais agilidade no processamento</p>
                 
                 <div class="progress mb-4" style="height: 15px; border-radius: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                 </div>
                 
                 <div class="row text-start mt-4">
                     <div class="col-6 text-center border-end">
                         <h4 class="fw-bold text-dark mb-0">R$ 0</h4>
                         <small class="text-muted small uppercase">Primeiros 7 dias</small>
                     </div>
                     <div class="col-6 text-center">
                         <h4 class="fw-bold text-dark mb-0">Ilimitado</h4>
                         <small class="text-muted small">Cadastros e Relatórios</small>
                     </div>
                 </div>
             </div>
        </div>
    </div>

    <div class="row g-4 mt-5 pb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 p-4 bg-light">
                <div class="text-primary mb-3"><i class="bi bi-lightning-charge-fill fs-1"></i></div>
                <h5 class="fw-bold">Gestão Ágil</h5>
                <p class="text-muted small">Esqueça o tempo de carregamento de planilhas gigantes. Cadastre e busque pessoas em milissegundos.</p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 p-4 bg-light">
                <div class="text-success mb-3"><i class="bi bi-pie-chart-fill fs-1"></i></div>
                <h5 class="fw-bold">Relatórios Automáticos</h5>
                <p class="text-muted small">Os dados de funcionários e clientes geram gráficos inteligentes sem que você precise digitar uma fórmula.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 p-4 bg-light">
                <div class="text-danger mb-3"><i class="bi bi-trash3-fill fs-1"></i></div>
                <h5 class="fw-bold">Limpeza de Dados</h5>
                <p class="text-muted small">Exclusão segura e rápida de registros duplicados ou antigos, mantendo seu sistema sempre limpo.</p>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-title { line-height: 1.1; letter-spacing: -1px; }
    .card { transition: transform 0.3s ease; border-radius: 15px; }
    .card:hover { transform: translateY(-5px); background-color: #fff !important; box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important; }
    .text-silver { color: #dee2e6; }
</style>
@endsection