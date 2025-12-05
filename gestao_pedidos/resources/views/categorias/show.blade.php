@extends('layouts.app')

@section('title', 'Detalhes da Categoria')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h4><i class="bi bi-tag"></i> {{ $categoria->nome }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Descrição:</strong> {{ $categoria->descricao ?? 'N/A' }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $categoria->ativo ? 'success' : 'secondary' }}">
                        {{ $categoria->ativo ? 'Ativa' : 'Inativa' }}
                    </span>
                </p>
                <p><strong>Total de Produtos:</strong> {{ $categoria->produtos->count() }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-box"></i> Produtos desta Categoria ({{ $categoria->produtos->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categoria->produtos as $produto)
                                <tr>
                                    <td>#{{ $produto->id }}</td>
                                    <td>{{ $produto->nome }}</td>
                                    <td>R$ {{ number_format($produto->precoUnidade, 2, ',', '.') }}</td>
                                    <td>
                                        @if($produto->estoque)
                                            <span class="badge bg-{{ $produto->estoque->quantidadeDisponivel > 0 ? 'success' : 'danger' }}">
                                                {{ $produto->estoque->quantidadeDisponivel }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Sem estoque</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('produtos.show', $produto) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Nenhum produto nesta categoria.</td>
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
    <a href="{{ route('categorias.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Editar
    </a>
</div>
@endsection

