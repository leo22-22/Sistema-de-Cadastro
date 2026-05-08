<x-guest-layout>
<h5 class="card-heading mb-1">Recuperar Senha</h5>
<p class="card-sub mb-4">Informe seu e-mail e enviaremos um link para redefinir sua senha.</p>

@if (session('status'))
<div class="alert alert-success py-2 mb-3">
    <i class="bi bi-check-circle me-1"></i>{{ session('status') }}
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" id="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus autocomplete="username">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-login mt-2">
        Enviar Link de Redefinição
    </button>

    <div class="text-center mt-3">
        <a href="{{ route('login') }}" class="forgot-link">
            <i class="bi bi-arrow-left me-1"></i>Voltar ao login
        </a>
    </div>
</form>
</x-guest-layout>
