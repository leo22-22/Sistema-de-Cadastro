@extends('layouts.app')

@section('title', 'Gestão de Clientes - CorpFlow')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-people-fill text-primary"></i> Clientes</h2>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Novo Cliente
        </a>
    </div>

    <div class="card shadow border-0" style="border-radius: 15px;">
        <div class="table-responsive p-3">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nome/Fantasia</th>
                        <th>Documento</th>
                        <th>Tipo</th>
                        <th>Contacto</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                    <tr>
                        <td>
                            <div class="fw-bold text-dark">{{ $cliente->nome_fantasia }}</div>
                            <small class="text-muted">{{ $cliente->razao_social ?? 'Pessoa Singular' }}</small>
                        </td>
                        <td>{{ $cliente->documento }}</td>
                        <td>
                            <span class="badge {{ $cliente->tipo == 'PF' ? 'bg-info' : 'bg-primary' }}">
                                {{ $cliente->tipo }}
                            </span>
                        </td>
                        <td>{{ $cliente->telefone ?? 'N/A' }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <form action="/clientes/{{ $cliente->id }}" method="POST" onsubmit="return confirm('Tens a certeza que desejas eliminar este cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Nenhum cliente registado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection