<x-guest-layout>
<h5 class="card-heading mb-1">Redefinir Senha</h5>
<p class="card-sub mb-4">Escolha uma nova senha para sua conta.</p>

<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" id="email" name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Nova Senha</label>
        <input type="password" id="password" name="password"
               class="form-control @error('password') is-invalid @enderror"
               required autocomplete="new-password">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
        <input type="password" id="password_confirmation" name="password_confirmation"
               class="form-control @error('password_confirmation') is-invalid @enderror"
               required autocomplete="new-password">
        @error('password_confirmation')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-login mt-2">
        Redefinir Senha
    </button>
</form>
</x-guest-layout>
