<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    @if(session('status') === 'profile-updated')
    <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
        <i class="bi bi-check-circle me-1"></i> Perfil atualizado com sucesso.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Nome</label>
        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">E-mail</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mt-2 small text-warning">
            <i class="bi bi-exclamation-triangle me-1"></i>
            Seu endereço de e-mail não foi verificado.
            <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-underline">
                Reenviar e-mail de verificação
            </button>
        </div>
        @if (session('status') === 'verification-link-sent')
        <div class="mt-1 small text-success">
            <i class="bi bi-check-circle me-1"></i>Um novo link de verificação foi enviado.
        </div>
        @endif
        @endif
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save me-1"></i>Salvar
    </button>
</form>
