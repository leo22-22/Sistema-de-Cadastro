<header class="header-section fixed-top shadow">
    <div class="container d-flex justify-content-between align-items-center py-3">
        <div class="logo">
            <a href="/" class="text-white fs-4 fw-bold text-decoration-none">
                <span style="color: var(--accent-blue)">CORP</span>FLOW
            </a>
        </div>
        
        <nav class="d-none d-lg-block">
            <ul class="nav"> 
                <li class="nav-item"><a class="nav-link text-white px-3" href="/">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3" href="/clientes">Clientes</a></li>
                <li class="nav-item"><a class="nav-link text-white px-3" href="/funcionarios">Funcionários</a></li>
                <li class="nav-item"><a class="nav-link text-warning fw-bold px-3" href="/relatorios">Relatórios</a></li>
            </ul>
        </nav>

        <div class="d-flex align-items-center gap-3">
            @auth
                <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm dropdown-toggle border-0" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Meu Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
                <span class="badge bg-primary rounded-pill px-3 py-2 d-none d-md-inline">
                    <i class="bi bi-circle-fill me-1 small text-success"></i> Ativa
                </span>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-3 rounded-pill">Entrar</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-sm px-3 rounded-pill">Assinar</a>
            @endauth
        </div>
    </div>
</header>