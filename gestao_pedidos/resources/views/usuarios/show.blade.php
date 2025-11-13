@extends('layouts.app')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-person"></i> {{ $usuario->nome }}</h4>
            </div>
            <div class="card-body">
                <p><strong>E-mail:</strong> {{ $usuario->email }}</p>
                <p><strong>CPF:</strong> {{ $usuario->cpf }}</p>
                <p><strong>Telefone:</strong> {{ $usuario->telefone ?? 'N/A' }}</p>
                <p><strong>Tipo:</strong> 
                    <span class="badge bg-{{ $usuario->tipo == 'admin' ? 'danger' : 'primary' }}">
                        {{ ucfirst($usuario->tipo) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Editar
    </a>
</div>
@endsection

