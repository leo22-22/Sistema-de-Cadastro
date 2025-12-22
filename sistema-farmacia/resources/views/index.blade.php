@extends('layouts.app') 
@section('content')
<div class="container mt-5">
    <div class="row align-items-center py-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold hero-title">Gestão Escalável para sua Empresa</h1>
            <p class="lead text-muted mt-4">
                Otimize o fluxo de grandes volumes de dados. Gerencie clientes e colaboradores em uma interface de alta performance.
            </p>
            <div class="mt-4">
                <a href="/clientes/create" class="btn btn-primary btn-lg me-2 shadow-sm">Cadastrar Cliente</a>
                <a href="/relatorios" class="btn btn-outline-dark btn-lg">Relatório Geral</a>
            </div>
        </div>
        
        <div class="col-lg-6">
             <div class="p-5 bg-white rounded-4 shadow-sm border text-center">
                 <h2 class="display-5 fw-bold text-primary">2.5k</h2>
                 <p class="text-muted fw-bold">Processamentos/dia</p>
                 <div class="progress mb-3" style="height: 12px;">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width: 85%"></div>
                 </div>
                 <small class="text-muted"><i class="bi bi-shield-check text-success"></i> Servidor Estável: 99.9%</small>
             </div>
        </div>
    </div>

    <div class="row g-4 mt-4 pb-5">
        <div class="col-md-4">
            <div class="card shadow-sm h-100 p-4">
                <div class="text-primary mb-3"><i class="bi bi-person-plus-fill fs-1"></i></div>
                <h4 class="fw-bold">Entrada de Dados</h4>
                <p class="text-muted small">Formulários otimizados para cadastros rápidos de funcionários e clientes.</p>
            </div>
        </div>
        </div>
</div>
@endsection