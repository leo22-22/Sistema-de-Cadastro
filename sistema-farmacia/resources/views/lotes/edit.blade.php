<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-pencil me-2"></i>Editar Lote — {{ $lote->lote }}</h4>
    <a href="{{ route('lotes.show', $lote) }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('lotes.update', $lote) }}" method="POST">
@csrf @method('PATCH')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card p-4">
            <h6 class="section-title">Dados do Lote</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Medicamento</label>
                    <input type="text" class="form-control" value="{{ $lote->medicamento->nome }}{{ $lote->medicamento->dosagem ? ' — ' . $lote->medicamento->dosagem : '' }}" disabled>
                    <div class="form-text">O medicamento não pode ser alterado após o cadastro.</div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Número do Lote *</label>
                    <input type="text" name="lote" class="form-control @error('lote') is-invalid @enderror"
                           value="{{ old('lote', $lote->lote) }}" required>
                    @error('lote')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Validade *</label>
                    <input type="date" name="validade" class="form-control @error('validade') is-invalid @enderror"
                           value="{{ old('validade', $lote->validade->format('Y-m-d')) }}" required>
                    @error('validade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Quantidade Inicial</label>
                    <input type="text" class="form-control" value="{{ $lote->quantidade_inicial }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Quantidade Atual</label>
                    <input type="text" class="form-control" value="{{ $lote->quantidade_atual }}" disabled>
                    <div class="form-text">Ajustada automaticamente a cada dispensação.</div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Observações</label>
                    <textarea name="observacoes" class="form-control" rows="2">{{ old('observacoes', $lote->observacoes) }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar Alterações</button>
    <a href="{{ route('lotes.show', $lote) }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:1rem; }</style>
@endpush
</x-app-layout>
