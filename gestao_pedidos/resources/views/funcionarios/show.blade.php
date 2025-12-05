@extends('layouts.app')

@section('title', 'Detalhes do Funcionário')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="bi bi-briefcase"></i> {{ $funcionario->nome }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>E-mail:</strong> {{ $funcionario->email }}</p>
                        <p><strong>CPF:</strong> {{ $funcionario->cpf }}</p>
                        <p><strong>Telefone:</strong> {{ $funcionario->telefone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Cargo:</strong> {{ $funcionario->cargo ?? 'N/A' }}</p>
                        <p><strong>Data de Admissão:</strong> {{ $funcionario->dataAdmissao ? $funcionario->dataAdmissao->format('d/m/Y') : 'N/A' }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-{{ $funcionario->ativo ? 'success' : 'secondary' }}">
                                {{ $funcionario->ativo ? 'Ativo' : 'Inativo' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-cart"></i> Pedidos Associados ({{ $funcionario->pedidos->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Data Pedido</th>
                                <th>Valor</th>
                                <th>Função</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($funcionario->pedidos as $pedido)
                                <tr>
                                    <td>#{{ $pedido->id }}</td>
                                    <td>{{ $pedido->usuario->nome }}</td>
                                    <td>{{ $pedido->dataPedido->format('d/m/Y H:i') }}</td>
                                    <td>R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $pedido->pivot->funcao ?? 'Geral' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pedidos.show', $pedido) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('funcionarios.remover-pedido', [$funcionario, $pedido]) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Remover este pedido do funcionário?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Nenhum pedido associado.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('funcionarios.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('funcionarios.edit', $funcionario) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Editar
    </a>
</div>
@endsection

