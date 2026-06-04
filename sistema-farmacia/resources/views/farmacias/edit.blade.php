<x-app-layout>
    <div class="page-header d-flex justify-content-between align-items-center">
        <h4><i class="bi bi-hospital me-2"></i>Editar Farmácia — {{ $farmacia->nome }}</h4>
        <small class="text-muted">{{ $farmacia->users->count() }} usuário(s) vinculado(s)</small>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <form action="{{ route('farmacias.update', $farmacia) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nome *</label>
                            <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                                   value="{{ old('nome', $farmacia->nome) }}" required>
                            @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control @error('cnpj') is-invalid @enderror"
                                   value="{{ old('cnpj', $farmacia->cnpj) }}" placeholder="00.000.000/0000-00">
                            @error('cnpj')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">CNES</label>
                            <input type="text" name="cnes" class="form-control @error('cnes') is-invalid @enderror"
                                   value="{{ old('cnes', $farmacia->cnes) }}">
                            @error('cnes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Responsável</label>
                            <input type="text" name="responsavel" class="form-control @error('responsavel') is-invalid @enderror"
                                   value="{{ old('responsavel', $farmacia->responsavel) }}">
                            @error('responsavel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Endereço</label>
                            <input type="text" name="endereco" class="form-control @error('endereco') is-invalid @enderror"
                                   value="{{ old('endereco', $farmacia->endereco) }}">
                            @error('endereco')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Cidade</label>
                            <input type="text" name="cidade" class="form-control @error('cidade') is-invalid @enderror"
                                   value="{{ old('cidade', $farmacia->cidade) }}">
                            @error('cidade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold">UF</label>
                            <input type="text" name="estado" class="form-control @error('estado') is-invalid @enderror"
                                   value="{{ old('estado', $farmacia->estado) }}" maxlength="2" placeholder="SP">
                            @error('estado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" name="telefone" class="form-control @error('telefone') is-invalid @enderror"
                                   value="{{ old('telefone', $farmacia->telefone) }}">
                            @error('telefone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $farmacia->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo"
                                       {{ old('ativo', $farmacia->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="ativo">Farmácia ativa</label>
                            </div>
                        </div>
                    </div>

                    @if($farmacia->users->count() > 0)
                    <div class="mt-4">
                        <p class="fw-semibold text-muted mb-2" style="font-size:.8rem;text-transform:uppercase;letter-spacing:.07em;">Usuários vinculados</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($farmacia->users as $u)
                            <span class="badge bg-light text-dark border">
                                <i class="bi bi-person me-1"></i>{{ $u->name }}
                                <span class="text-muted ms-1">({{ $u->role }})</span>
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar</button>
                        <a href="{{ route('farmacias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
