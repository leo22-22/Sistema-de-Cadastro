<x-guest-layout>
<h5 class="card-heading mb-1">Verificar E-mail</h5>
<p class="card-sub mb-4">
    Antes de continuar, verifique seu e-mail clicando no link que enviamos.
    Se não recebeu, podemos enviar outro.
</p>

@if (session('status') == 'verification-link-sent')
<div class="alert alert-success py-2 mb-3">
    <i class="bi bi-check-circle me-1"></i>Um novo link de verificação foi enviado para o seu e-mail.
</div>
@endif

<form method="POST" action="{{ route('verification.send') }}" class="mb-3">
    @csrf
    <button type="submit" class="btn btn-login">
        Reenviar E-mail de Verificação
    </button>
</form>

<form method="POST" action="{{ route('logout') }}" class="text-center">
    @csrf
    <button type="submit" class="btn btn-link forgot-link p-0">
        <i class="bi bi-box-arrow-right me-1"></i>Sair
    </button>
</form>
</x-guest-layout>
