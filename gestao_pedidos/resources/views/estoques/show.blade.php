@extends('layouts.app')

@section('title', 'Detalhes do Estoque')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-box-seam"></i> Estoque - {{ $estoque->produto->nome }}</h4>
            </div>
            <div class="card-body">
                <p><strong>Produto:</strong> {{ $estoque->produto->nome }}</p>
                <p><strong>Quantidade Disponível:</strong> {{ $estoque->quantidadeDisponivel }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $estoque->quantidadeDisponivel > 0 ? 'success' : 'danger' }}">
                        {{ $estoque->quantidadeDisponivel > 0 ? 'Disponível' : 'Indisponível' }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('estoques.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('estoques.edit', $estoque) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Editar
    </a>
</div>
@endsection

