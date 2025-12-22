@extends('layouts.app')

@section('title', 'Cadastrar Funcionário - CorpFlow')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-dark text-white p-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="bi bi-briefcase-fill text-warning me-2"></i> Novo Cadastro de Funcionário</h5>
                </div>
                
                <div class="card-body p-4 bg-white">
                    <form action="{{ route('funcionarios.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <h6 class="text-primary fw-bold border-bottom pb-2">Dados Pessoais</h6>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Nome Completo</label>
                                <input type="text" name="nome_completo" class="form-control border-primary-subtle" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">CPF</label>
                                <input type="text" name="cpf" class="form-control border-primary-subtle" placeholder="000.000.000-00" required>
                            </div>

                            <h6 class="text-primary fw-bold border-bottom pb-2 mt-4">Contratação e Finanças</h6>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Cargo</label>
                                <input type="text" name="cargo" class="form-control border-primary-subtle" placeholder="Ex: Gerente de Operações" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Data de Admissão</label>
                                <input type="date" name="data_admissao" class="form-control border-primary-subtle" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Salário Base (R$)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white border-0">R$</span>
                                    <input type="number" step="0.01" name="salario" class="form-control border-primary-subtle" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Bonificação (R$)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white border-0">R$</span>
                                    <input type="number" step="0.01" name="bonificacao" class="form-control border-primary-subtle" value="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2 px-4">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 shadow">Salvar Funcionário</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection