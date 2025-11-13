@extends('layouts.app')

@section('title', 'Produtos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Produtos</h2>
    @auth
        @if(Auth::user()->isAdmin())
            <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Novo Produto
            </a>
        @endif
    @endauth
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('produtos.index') }}" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Buscar por nome ou descrição..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Buscar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    @forelse($produtos as $produto)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow-sm">
                @if($produto->imagem)
                    <img src="{{ asset('storage/' . $produto->imagem) }}" 
                         class="card-img-top" 
                         alt="{{ $produto->nome }}"
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                         style="height: 200px;">
                        <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $produto->nome }}</h5>
                    <p class="card-text text-muted small">
                        {{ Str::limit($produto->descricao, 80) }}
                    </p>
                    <div class="mt-auto">
                        <p class="h5 text-primary mb-3">
                            R$ {{ number_format($produto->precoUnidade, 2, ',', '.') }}
                        </p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('produtos.show', $produto) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> Ver Detalhes
                            </a>
                            @auth
                                @if(Auth::user()->isAdmin())
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('produtos.edit', $produto) }}" 
                                           class="btn btn-outline-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('produtos.destroy', $produto) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Nenhum produto encontrado.
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center">
    {{ $produtos->links() }}
</div>
@endsection

