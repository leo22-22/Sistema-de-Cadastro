<x-guest-layout>
<h5 class="card-heading mb-1">Confirmar Senha</h5>
<p class="card-sub mb-4">Esta é uma área segura. Confirme sua senha para continuar.</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" id="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required autocomplete="current-password">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-login mt-2">
        Confirmar
    </button>
</form>
</x-guest-layout>
