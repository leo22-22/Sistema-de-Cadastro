<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <h4><i class="bi bi-box-seam me-2"></i>Entrada de Lote</h4>
    <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Voltar
    </a>
</div>

<form action="{{ route('lotes.store') }}" method="POST">
@csrf
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card p-4">
            <h6 class="section-title">Dados do Lote</h6>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Medicamento *</label>
                    <select name="medicamento_id" class="form-select @error('medicamento_id') is-invalid @enderror" required>
                        <option value="">Selecionar medicamento...</option>
                        @foreach($medicamentos as $med)
                        <option value="{{ $med->id }}" {{ old('medicamento_id') == $med->id ? 'selected' : '' }}>
                            {{ $med->nome }}{{ $med->dosagem ? ' — ' . $med->dosagem : '' }}
                            ({{ $med->forma_label ?? $med->forma_farmaceutica }})
                        </option>
                        @endforeach
                    </select>
                    @error('medicamento_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Número do Lote *</label>
                    <input type="text" name="lote" class="form-control @error('lote') is-invalid @enderror"
                           value="{{ old('lote') }}" placeholder="ex: LOT2025001" required>
                    @error('lote')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Validade *</label>
                    <input type="date" name="validade" class="form-control @error('validade') is-invalid @enderror"
                           value="{{ old('validade') }}" required>
                    @error('validade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Quantidade Recebida *</label>
                    <input type="number" name="quantidade_inicial" class="form-control @error('quantidade_inicial') is-invalid @enderror"
                           value="{{ old('quantidade_inicial') }}" min="1" required>
                    @error('quantidade_inicial')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Data de Entrada *</label>
                    <input type="date" name="data_entrada" class="form-control @error('data_entrada') is-invalid @enderror"
                           value="{{ old('data_entrada', now()->format('Y-m-d')) }}" required>
                    @error('data_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Observações</label>
                    <textarea name="observacoes" class="form-control" rows="2"
                              placeholder="Nota fiscal, fornecedor, etc.">{{ old('observacoes') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card p-4 border-primary" style="border-width:2px!important">
            <h6 class="section-title text-primary">Atenção</h6>
            <ul class="small text-muted ps-3 mb-0">
                <li>A quantidade inicial será igual à quantidade disponível</li>
                <li>O saldo será descontado a cada dispensação</li>
                <li>Lotes vencidos não aparecem na dispensação</li>
                <li>Para ajustar saldo, use a edição do lote</li>
            </ul>
        </div>
    </div>
</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Registrar Entrada</button>
    <a href="{{ route('lotes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
</form>

@push('styles')
<style>.section-title { font-size:.72rem; font-weight:700; text-transform:uppercase; letter-spacing:.06em; color:#64748b; margin-bottom:1rem; }</style>
@endpush
</x-app-layout>
