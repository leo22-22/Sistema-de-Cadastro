<x-guest-layout>

    <div class="mb-4" style="animation:fadeUp .4s ease both">
        <div class="auth-heading">Bem-vindo de volta</div>
        <div class="auth-sub">Informe suas credenciais para acessar o sistema</div>
    </div>

    @if(session('status'))
    <div class="alert-gs alert-gs-info mb-3" style="animation:shakeIn .3s ease both">
        <i class="bi bi-info-circle-fill"></i>
        {{ session('status') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-gs alert-gs-err mb-3" style="animation:shakeErr .45s ease both">
        <i class="bi bi-exclamation-triangle-fill"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" novalidate id="loginForm">
        @csrf

        <div class="mb-3" style="animation:fadeUp .45s .05s ease both;opacity:0">
            <label class="form-label">E-mail</label>
            <div class="input-wrap">
                <i class="bi bi-envelope input-icon"></i>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="seu@email.com"
                    required
                    autofocus
                    autocomplete="username"
                >
            </div>
        </div>

        <div class="mb-3" style="animation:fadeUp .45s .1s ease both;opacity:0">
            <label class="form-label">Senha</label>
            <div class="input-wrap">
                <i class="bi bi-lock input-icon"></i>
                <input
                    id="gs-password"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
                <button class="eye-btn" type="button" onclick="gsTogglePass()" tabindex="-1">
                    <i class="bi bi-eye" id="gsEyeIcon"></i>
                </button>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4"
             style="animation:fadeUp .45s .15s ease both;opacity:0">
            <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.84rem;color:#475569;user-select:none">
                <input type="checkbox" name="remember" class="form-check-input m-0">
                Lembrar-me
            </label>
            @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Esqueceu a senha?</a>
            @endif
        </div>

        <div style="animation:fadeUp .45s .2s ease both;opacity:0">
            <button type="submit" class="btn-primary-full" id="loginBtn">
                <span id="loginBtnText"><i class="bi bi-box-arrow-in-right me-2"></i>Entrar</span>
                <span id="loginSpinner" style="display:none">
                    <span class="gs-spinner"></span> Entrando...
                </span>
            </button>
        </div>
    </form>

    <script>
    function gsTogglePass() {
        var inp = document.getElementById('gs-password');
        var ico = document.getElementById('gsEyeIcon');
        if (inp.type === 'password') {
            inp.type = 'text';
            ico.className = 'bi bi-eye-slash';
        } else {
            inp.type = 'password';
            ico.className = 'bi bi-eye';
        }
    }
    document.getElementById('loginForm').addEventListener('submit', function() {
        document.getElementById('loginBtnText').style.display = 'none';
        document.getElementById('loginSpinner').style.display = '';
        document.getElementById('loginBtn').disabled = true;
    });
    </script>

</x-guest-layout>
