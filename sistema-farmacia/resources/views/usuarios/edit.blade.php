<x-app-layout>
    <div class="page-header">
        <h4><i class="bi bi-pencil me-2"></i>Editar Usuário</h4>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $usuario->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-mail *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $usuario->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Perfil *</label>
                        <select name="role" class="form-select" required>
                            <option value="funcionario" {{ old('role', $usuario->role) === 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                            <option value="admin_farmacia" {{ old('role', $usuario->role) === 'admin_farmacia' ? 'selected' : '' }}>Admin Farmácia</option>
                            @if(auth()->user()->isSuperadmin())
                            <option value="superadmin" {{ old('role', $usuario->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            @endif
                        </select>
                    </div>
                    @if(auth()->user()->isSuperadmin())
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Farmácia</label>
                        <select name="farmacia_id" class="form-select @error('farmacia_id') is-invalid @enderror">
                            <option value="">— Nenhuma (superadmin de plataforma) —</option>
                            @foreach($farmacias as $f)
                            <option value="{{ $f->id }}" {{ old('farmacia_id', $usuario->farmacia_id) == $f->id ? 'selected' : '' }}>
                                {{ $f->nome }}
                            </option>
                            @endforeach
                        </select>
                        @error('farmacia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endif
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" value="1" id="active"
                                   {{ old('active', $usuario->active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">Usuário ativo</label>
                        </div>
                    </div>
                    <hr>
                    <p class="text-muted small">Deixe em branco para manter a senha atual.</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nova Senha</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmar Nova Senha</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Salvar</button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
