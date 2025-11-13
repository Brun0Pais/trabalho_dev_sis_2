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
                <h5 class="card-title">Total de Produtos</h5>
                <h2>{{ \App\Models\Produto::count() }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Últimos Pedidos</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach(\App\Models\Pedido::with('usuario')->latest()->take(5)->get() as $pedido)
                        <a href="{{ route('pedidos.show', $pedido) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Pedido #{{ $pedido->id }} - {{ $pedido->usuario->nome }}</h6>
                                <small>{{ $pedido->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</p>
                            <small>
                                <span class="badge bg-{{ $pedido->statusPagamento == 'pago' ? 'success' : ($pedido->statusPagamento == 'cancelado' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($pedido->statusPagamento) }}
                                </span>
                            </small>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Ações Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Novo Produto
                    </a>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-success">
                        <i class="bi bi-receipt"></i> Ver Pedidos
                    </a>
                    <a href="{{ route('estoques.index') }}" class="btn btn-warning">
                        <i class="bi bi-box-seam"></i> Gerenciar Estoque
                    </a>
                    <a href="{{ route('relatorios.index') }}" class="btn btn-info">
                        <i class="bi bi-file-earmark-pdf"></i> Relatórios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

