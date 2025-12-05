@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2><i class="bi bi-speedometer2"></i> Dashboard Administrativo</h2>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total de Pedidos</h5>
                <h2>{{ \App\Models\Pedido::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Pedidos Pagos</h5>
                <h2>{{ \App\Models\Pedido::where('statusPagamento', 'pago')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Pedidos Pendentes</h5>
                <h2>{{ \App\Models\Pedido::where('statusPagamento', 'pendente')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Faturamento Total</h5>
                <h2>R$ {{ number_format(\App\Models\Pedido::sum('subtotal'), 2, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <h5 class="card-title">Total de Produtos</h5>
                <h2>{{ \App\Models\Produto::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-dark">
            <div class="card-body">
                <h5 class="card-title">Total de Clientes</h5>
                <h2>{{ \App\Models\Usuario::where('tipo', 'cliente')->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #6f42c1;">
            <div class="card-body">
                <h5 class="card-title">Total de Funcionários</h5>
                <h2>{{ \App\Models\Funcionario::count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white" style="background-color: #fd7e14;">
            <div class="card-body">
                <h5 class="card-title">Total de Categorias</h5>
                <h2>{{ \App\Models\Categoria::count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-box-seam"></i> Produtos com Estoque Baixo</h5>
            </div>
            <div class="card-body">
                @php
                    $produtosEstoqueBaixo = \App\Models\Estoque::where('quantidadeDisponivel', '<=', 10)
                        ->where('quantidadeDisponivel', '>', 0)
                        ->with('produto')
                        ->limit(5)
                        ->get();
                @endphp
                @if($produtosEstoqueBaixo->count() > 0)
                    <ul class="list-group">
                        @foreach($produtosEstoqueBaixo as $estoque)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $estoque->produto->nome ?? 'Produto não encontrado' }}
                                <span class="badge bg-warning rounded-pill">{{ $estoque->quantidadeDisponivel }} unidades</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Nenhum produto com estoque baixo.</p>
                @endif
                <a href="{{ route('estoques.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                    Ver Todos os Estoques
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-cart"></i> Pedidos Recentes</h5>
            </div>
            <div class="card-body">
                @php
                    $pedidosRecentes = \App\Models\Pedido::with('usuario')
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp
                @if($pedidosRecentes->count() > 0)
                    <ul class="list-group">
                        @foreach($pedidosRecentes as $pedido)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Pedido #{{ $pedido->id }}</strong><br>
                                    <small class="text-muted">{{ $pedido->usuario->nome }} - {{ $pedido->dataPedido->format('d/m/Y H:i') }}</small>
                                </div>
                                <span class="badge bg-{{ $pedido->statusPagamento == 'pago' ? 'success' : 'warning' }} rounded-pill">
                                    R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Nenhum pedido recente.</p>
                @endif
                <a href="{{ route('pedidos.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                    Ver Todos os Pedidos
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-link-45deg"></i> Acesso Rápido</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('produtos.create') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-plus-circle"></i> Novo Produto
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('estoques.create') }}" class="btn btn-outline-success w-100">
                            <i class="bi bi-box-seam"></i> Novo Estoque
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('funcionarios.create') }}" class="btn btn-outline-info w-100">
                            <i class="bi bi-briefcase"></i> Novo Funcionário
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="{{ route('categorias.create') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-tags"></i> Nova Categoria
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

