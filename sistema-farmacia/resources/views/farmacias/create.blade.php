<x-app-layout>
    <div class="page-header">
        <h4><i class="bi bi-hospital me-2"></i>Nova Farmácia</h4>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <form action="{{ route('farmacias.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nome *</label>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                   value="{{ old('nome') }}" required>
                            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control @error('cnpj') is-invalid @enderror"
                                   value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00" data-mask="cnpj" maxlength="18">
                            @error('cnpj')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">CNES</label>
                            <input type="text" name="cnes" class="form-control @error('cnes') is-invalid @enderror"
                                   value="{{ old('cnes') }}" placeholder="0000000" data-mask="cnes" maxlength="7">
                            @error('cnes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Responsável</label>
                            <input type="text" name="responsavel" class="form-control @error('responsavel') is-invalid @enderror"
                                   value="{{ old('responsavel') }}">
                            @error('responsavel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Endereço</label>
                            <input type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror"
                                   value="{{ old('endereco') }}">
                            @error('endereco')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Cidade</label>
                            <input type="text" name="cidade" class="form-control @error('cidade') is-invalid @enderror"
                                   value="{{ old('cidade') }}">
                            @error('cidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">UF</label>
                            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror"
                                   value="{{ old('estado') }}" maxlength="2" placeholder="SP">
                            @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror"
                                   value="{{ old('telefone') }}" placeholder="(00) 00000-0000" data-mask="telefone" maxlength="15">
                            @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar</button>
                        <a href="{{ route('farmacias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
