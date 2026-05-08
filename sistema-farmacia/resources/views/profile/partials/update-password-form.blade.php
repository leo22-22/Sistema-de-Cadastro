<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    @if(session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
        <i class="bi bi-check-circle me-1"></i> Senha alterada com sucesso.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="mb-3">
        <label for="current_password" class="form-label fw-semibold">Senha Atual</label>
        <input type="password" id="current_password" name="current_password"
               class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif"
               autocomplete="current-password">
        @if($errors->updatePassword->has('current_password'))
        <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Nova Senha</label>
        <input type="password" id="password" name="password"
               class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif"
               autocomplete="new-password">
        @if($errors->updatePassword->has('password'))
        <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-semibold">Confirmar Nova Senha</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
               autocomplete="new-password">
        @if($errors->updatePassword->has('password_confirmation'))
        <div class="invalid-feedback">{{ $errors->updatePassword->first('password_confirmation') }}</div>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-key me-1"></i>Alterar Senha
    </button>
</form>
