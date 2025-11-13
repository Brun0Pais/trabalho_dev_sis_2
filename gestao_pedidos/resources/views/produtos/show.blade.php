@extends('layouts.app')

@section('title', $produto->nome)

@section('content')
<div class="row">
    <div class="col-md-6">
        @if($produto->imagem)
            <img src="{{ asset('storage/' . $produto->imagem) }}" 
                 class="img-fluid rounded shadow" 
                 alt="{{ $produto->nome }}">
        @else
            <div class="bg-light d-flex align-items-center justify-content-center rounded shadow" 
                 style="height: 400px;">
                <i class="bi bi-image" style="font-size: 5rem; color: #ccc;"></i>
            </div>
        @endif
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">{{ $produto->nome }}</h2>
                <p class="h3 text-primary mb-4">
                    R$ {{ number_format($produto->precoUnidade, 2, ',', '.') }}
                </p>

                @if($produto->descricao)
                    <div class="mb-3">
                        <h5>Descrição</h5>
                        <p class="text-muted">{{ $produto->descricao }}</p>
                    </div>
                @endif

                @if($produto->ingredientesPrincipais)
                    <div class="mb-3">
                        <h5>Ingredientes Principais</h5>
                        <p class="text-muted">{{ $produto->ingredientesPrincipais }}</p>
                    </div>
                @endif

                @if($produto->estoque)
                    <div class="mb-3">
                        <h5>Estoque Disponível</h5>
                        <p class="badge bg-{{ $produto->estoque->quantidadeDisponivel > 0 ? 'success' : 'danger' }}">
                            {{ $produto->estoque->quantidadeDisponivel }} unidades
                        </p>
                    </div>
                @endif

                <div class="d-flex gap-2">
                    <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('produtos.edit', $produto) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

