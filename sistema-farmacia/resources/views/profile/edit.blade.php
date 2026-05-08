<x-app-layout>
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-person-circle me-2"></i>Meu Perfil</h4>
        <small class="text-muted">Gerencie suas informações de acesso</small>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Informações do Perfil</h6>
                <small class="text-muted">Atualize seu nome e endereço de e-mail.</small>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Alterar Senha</h6>
                <small class="text-muted">Use uma senha longa e aleatória para manter sua conta segura.</small>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card border-danger">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-danger">Excluir Conta</h6>
                <small class="text-muted">Esta ação é permanente e não pode ser desfeita.</small>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4 text-center">
            <div class="mb-3">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width:80px;height:80px">
                    <i class="bi bi-person-fill fs-1 text-primary"></i>
                </div>
            </div>
            <div class="fw-semibold fs-5">{{ auth()->user()->name }}</div>
            <div class="text-muted small">{{ auth()->user()->email }}</div>
            <hr>
            <div class="d-flex justify-content-between small text-muted">
                <span>Perfil</span>
                <span class="badge bg-{{ auth()->user()->role === 'superadmin' ? 'danger' : 'primary' }}">
                    {{ auth()->user()->role === 'superadmin' ? 'Superadmin' : 'Funcionário' }}
                </span>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
