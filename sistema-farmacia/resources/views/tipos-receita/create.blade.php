<x-app-layout>
    <div class="page-header">
        <h4><i class="bi bi-file-medical me-2"></i>Novo Tipo de Receita</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <form action="{{ route('tipos-receita.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome *</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome') }}" required placeholder="Ex: Receita Branca">
                        @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cor (badge) *</label>
                        <select name="cor" class="form-select @error('cor') is-invalid @enderror" required>
                            @foreach(['primary' => 'Azul','secondary' => 'Cinza','success' => 'Verde','danger' => 'Vermelho','warning' => 'Amarelo','info' => 'Ciano','dark' => 'Escuro'] as $val => $label)
                            <option value="{{ $val }}" {{ old('cor') === $val ? 'selected' : '' }}>
                                {{ $label }} ({{ $val }})
                            </option>
                            @endforeach
                        </select>
                        @error('cor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3">{{ old('descricao') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="requer_retencao" value="1" id="ret"
                                   {{ old('requer_retencao') ? 'checked' : '' }}>
                            <label class="form-check-label" for="ret">Requer retenção da receita</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar</button>
                        <a href="{{ route('tipos-receita.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
