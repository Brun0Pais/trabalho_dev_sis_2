@extends('layouts.app')

@section('title', 'Catálogo de Produtos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-shop"></i> Catálogo de Produtos</h2>
    @if(count($carrinho) > 0)
        <div>
            <a href="{{ route('pedidos.create') }}" class="btn btn-success">
                <i class="bi bi-cart-check"></i> Finalizar Pedido ({{ count($carrinho) }})
            </a>
            <form action="{{ route('catalogo.limpar') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Limpar carrinho?')">
                    <i class="bi bi-trash"></i> Limpar
                </button>
            </form>
        </div>
    @endif
</div>

@if(count($carrinho) > 0)
<div class="card mb-4 bg-light">
    <div class="card-body">
        <h5><i class="bi bi-cart"></i> Carrinho de Compras</h5>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unit.</th>
                        <th>Subtotal</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalCarrinho = 0; @endphp
                    @foreach($carrinho as $item)
                        @php $subtotal = $item['preco'] * $item['quantidade']; $totalCarrinho += $subtotal; @endphp
                        <tr>
                            <td>{{ $item['nome'] }}</td>
                            <td>
                                <form action="{{ route('catalogo.atualizar', $item['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantidade" value="{{ $item['quantidade'] }}" 
                                           min="1" class="form-control form-control-sm d-inline" style="width: 80px;" 
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('catalogo.remover', $item['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="3">Total:</td>
                        <td>R$ {{ number_format($totalCarrinho, 2, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('catalogo.index') }}" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Buscar produtos..." 
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
                    @if($produto->estoque)
                        <p class="small mb-2">
                            <span class="badge bg-{{ $produto->estoque->quantidadeDisponivel > 0 ? 'success' : 'danger' }}">
                                Estoque: {{ $produto->estoque->quantidadeDisponivel }}
                            </span>
                        </p>
                    @endif
                    <div class="mt-auto">
                        <p class="h5 text-primary mb-3">
                            R$ {{ number_format($produto->precoUnidade, 2, ',', '.') }}
                        </p>
                        @if($produto->estoque && $produto->estoque->quantidadeDisponivel > 0)
                            <form action="{{ route('catalogo.adicionar', $produto) }}" method="POST">
                                @csrf
                                <div class="input-group mb-2">
                                    <input type="number" name="quantidade" value="1" min="1" 
                                           max="{{ $produto->estoque->quantidadeDisponivel }}" 
                                           class="form-control form-control-sm" required>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </form>
                        @else
                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                Indisponível
                            </button>
                        @endif
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
    {{ $produtos->links('vendor.pagination.bootstrap-5-no-arrows') }}
</div>
@endsection

