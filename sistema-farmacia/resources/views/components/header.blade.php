<nav class="fixed-top header-section shadow-lg border-b border-blue-900/30" style="background: #0f172a !important; padding: 15px 0;">
    <div class="container-fluid px-5">
        <div class="d-flex align-items-center justify-content-between">
            
            <a class="d-flex align-items-center text-decoration-none" href="{{ route('dashboard') }}">
                <span class="fs-3 fw-black text-white tracking-tighter">
                    CORP<span class="text-blue-500">FLOW</span>
                </span>
            </a>

            <div class="d-none d-md-flex align-items-center gap-4">
                <a href="{{ route('dashboard') }}" class="nav-link text-white fw-bold hover:text-blue-400 transition">Dashboard</a>
                <a href="{{ route('registros.index') }}" class="nav-link text-white fw-bold hover:text-blue-400 transition">Registros</a>
                <a href="{{ route('relatorios') }}" class="nav-link text-white fw-bold hover:text-blue-400 transition">Relatórios</a>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="bg-success/20 px-3 py-1 rounded-full border border-success/30">
                    <span class="text-success text-xs fw-bold">
                        <i class="bi bi-circle-fill animate-pulse me-1"></i> ATIVA
                    </span>
                </div>

                <div class="dropdown">
                    <button class="btn btn-link text-warning text-decoration-none dropdown-toggle fw-bold" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-xl border-0 rounded-3 mt-2">
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-gear me-2"></i>Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</nav>

<style>
    .header-section {
        z-index: 1030;
    }
    .nav-link {
        font-size: 0.95rem;
    }
    /* Animação do pingo verde */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
    }
</style>