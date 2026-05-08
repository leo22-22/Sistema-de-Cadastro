<p class="text-muted small mb-3">
    Uma vez excluída, todos os dados da sua conta serão permanentemente removidos.
    Baixe qualquer informação que deseja manter antes de prosseguir.
</p>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalExcluirConta">
    <i class="bi bi-trash me-1"></i>Excluir Minha Conta
</button>

<div class="modal fade" id="modalExcluirConta" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-header border-danger">
                    <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Excluir Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.</p>

                    <div class="mb-3">
                        <label for="delete_password" class="form-label fw-semibold">Confirme sua senha</label>
                        <input type="password" id="delete_password" name="password"
                               class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
                               placeholder="Sua senha atual">
                        @if($errors->userDeletion->has('password'))
                        <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Excluir Conta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new bootstrap.Modal(document.getElementById('modalExcluirConta')).show();
    });
</script>
@endif
