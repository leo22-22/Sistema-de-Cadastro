<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-pencil me-2"></i>Editar — {{ $medicamento->nome }}</h4>
    <a href="{{ route('medicamentos.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('medicamentos.update', $medicamento) }}" method="POST">
@csrf @method('PATCH')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card p-4 mb-3">
            <h6 class="section-title">Identificação</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Nome *</label>
                    <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror"
                           value="{{ old('nome', $medicamento->nome) }}" required>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Princípio Ativo</label>
                    <input type="text" name="principio_ativo" class="form-control"
                           value="{{ old('principio_ativo', $medicamento->principio_ativo) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Dosagem</label>
                    <input type="text" name="dosagem" class="form-control"
                           value="{{ old('dosagem', $medicamento->dosagem) }}" placeholder="Ex: 50mg, 100mg/mL">
                </div>
            </div>
        </div>

        <div class="card p-4 mb-3">
            <h6 class="section-title">Forma Farmacêutica e Posologia Padrão</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Forma Farmacêutica</label>
                    <select name="forma_farmaceutica" class="form-select @error('forma_farmaceutica') is-invalid @enderror">
                        <option value="">Selecione...</option>
                        @foreach(\App\Models\Medicamento::$formasFarmaceuticas as $val => $label)
                        <option value="{{ $val }}" {{ old('forma_farmaceutica', $medicamento->forma_farmaceutica) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('forma_farmaceutica')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Periodicidade Padrão</label>
                    <select name="periodicidade" class="form-select">
                        <option value="">—</option>
                        @foreach(\App\Models\Medicamento::$periodicidades as $val => $label)
                        <option value="{{ $val }}" {{ old('periodicidade', $medicamento->periodicidade) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Qtd Diária Padrão</label>
                    <input type="number" name="quantidade_diaria" class="form-control"
                           value="{{ old('quantidade_diaria', $medicamento->quantidade_diaria) }}"
                           step="0.5" min="0.5">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tipo de Receita Padrão</label>
                    <select name="tipo_receita_id" class="form-select">
                        <option value="">— Nenhum —</option>
                        @foreach($tiposReceita as $tr)
                        <option value="{{ $tr->id }}" {{ old('tipo_receita_id', $medicamento->tipo_receita_id) == $tr->id ? 'selected' : '' }}>
                            {{ $tr->nome }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Descrição / Observações</label>
                    <textarea name="descricao" class="form-control" rows="2">{{ old('descricao', $medicamento->descricao) }}</textarea>
                </div>
            </div>
        </div>

        {{-- CIDs vinculados --}}
        @if($cids->count())
        <div class="card p-4 mb-3">
            <h6 class="section-title">CIDs Indicados</h6>
            @php $cidsSelecionados = $medicamento->cids->pluck('id')->toArray(); @endphp
            <div class="row g-1" style="max-height:220px; overflow-y:auto;">
                @foreach($cids as $cid)
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="cids[]"
                               value="{{ $cid->id }}" id="cid_{{ $cid->id }}"
                               {{ in_array($cid->id, old('cids', $cidsSelecionados)) ? 'checked' : '' }}>
                        <label class="form-check-label small" for="cid_{{ $cid->id }}">
                            <span class="badge bg-dark me-1" style="font-size:.65rem">{{ $cid->codigo }}</span>{{ $cid->nome }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card p-4">
            <h6 class="section-title">Status</h6>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="ativo" value="1" id="ativo"
                       {{ old('ativo', $medicamento->ativo) ? 'checked' : '' }}>
                <label class="form-check-label" for="ativo">Medicamento ativo no sistema</label>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Alterações</button>
    <a href="{{ route('medicamentos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:1rem; }</style>
@endpush
</x-app-layout>
