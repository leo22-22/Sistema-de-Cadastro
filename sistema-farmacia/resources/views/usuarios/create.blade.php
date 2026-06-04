<x-app-layout>
    <div class="page-header">
        <h4><i class="bi bi-person-plus me-2"></i>Novo Usuário</h4>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nome *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-mail *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Perfil *</label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="funcionario" {{ old('role') === 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                            <option value="admin_farmacia" {{ old('role') === 'admin_farmacia' ? 'selected' : '' }}>Admin Farmácia</option>
                            @if(auth()->user()->isSuperadmin())
                            <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            @endif
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @if(auth()->user()->isSuperadmin())
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Farmácia</label>
                        <select name="farmacia_id" class="form-select @error('farmacia_id') is-invalid @enderror">
                            <option value="">— Nenhuma (superadmin de plataforma) —</option>
                            @foreach($farmacias as $f)
                            <option value="{{ $f->id }}" {{ old('farmacia_id') == $f->id ? 'selected' : '' }}>
                                {{ $f->nome }}
                            </option>
                            @endforeach
                        </select>
                        @error('farmacia_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Senha *</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmar Senha *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
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
