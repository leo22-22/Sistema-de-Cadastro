@extends('layouts.app')

@section('title', 'Cadastrar Cliente - CorpFlow')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-dark text-white p-3" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0"><i class="bi bi-person-plus-fill text-primary me-2"></i> Novo Cadastro de Cliente</h5>
                </div>
                
                <div class="card-body p-4 bg-white">
                    <form action="/clientes" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nome Fantasia / Nome Social</label>
                                <input type="text" name="nome_fantasia" class="form-control border-primary-subtle" placeholder="Ex: Barbearia do Zé ou João Silva" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipo de Cliente</label>
                                <select name="tipo" class="form-select border-primary-subtle">
                                    <option value="PF">Pessoa Física (CPF)</option>
                                    <option value="PJ">Pessoa Jurídica (CNPJ)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Documento (CPF ou CNPJ)</label>
                                <input type="text" name="documento" class="form-control border-primary-subtle" placeholder="000.000.000-00" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Razão Social (Opcional)</label>
                                <input type="text" name="razao_social" class="form-control border-primary-subtle" placeholder="Nome jurídico da empresa">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Telefone/WhatsApp</label>
                                <input type="text" name="telefone" class="form-control border-primary-subtle" placeholder="(00) 00000-0000">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" class="form-control border-primary-subtle" placeholder="contato@empresa.com">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold">Observações de Demanda</label>
                                <textarea name="observacoes" class="form-control border-primary-subtle" rows="3" placeholder="Ex: Prefere semijoias banhadas a ouro ou corte degradê com tesoura..."></textarea>
                            </div>
                        </div>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary me-2 px-4">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5 shadow">Salvar Cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection