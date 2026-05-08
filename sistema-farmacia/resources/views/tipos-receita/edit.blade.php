<x-app-layout>
    <div class="page-header">
        <h4><i class="bi bi-pencil me-2"></i>Editar Tipo de Receita</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <form action="{{ route('tipos-receita.update', $tipo) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome *</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                               value="{{ old('nome', $tipo->nome) }}" required>
                        @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Cor (badge) *</label>
                        <select name="cor" class="form-select" required>
                            @foreach(['primary' => 'Azul','secondary' => 'Cinza','success' => 'Verde','danger' => 'Vermelho','warning' => 'Amarelo','info' => 'Ciano','dark' => 'Escuro'] as $val => $label)
                            <option value="{{ $val }}" {{ old('cor', $tipo->cor) === $val ? 'selected' : '' }}>
                                {{ $label }} ({{ $val }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="3">{{ old('descricao', $tipo->descricao) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="requer_retencao" value="1" id="ret"
                                   {{ old('requer_retencao', $tipo->requer_retencao) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ret">Requer retenção da receita</label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo"
                                   {{ $tipo->ativo ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo">Ativo</label>
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
