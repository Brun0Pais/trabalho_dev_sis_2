@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-earmark-bar-graph"></i> Relatórios e Gráficos</h2>
    <div>
        <a href="{{ route('relatorios.pedidos.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> Relatório de Pedidos (PDF)
        </a>
        <a href="{{ route('relatorios.produtos.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-pdf"></i> Relatório de Produtos (PDF)
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Vendas por Período</h5>
            </div>
            <div class="card-body">
                {!! $chartVendas->container() !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Produtos Mais Vendidos</h5>
            </div>
            <div class="card-body">
                {!! $chartProdutos->container() !!}
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Estatísticas Gerais</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="text-center">
                    <h3 class="text-primary">{{ \App\Models\Pedido::count() }}</h3>
                    <p class="text-muted">Total de Pedidos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h3 class="text-success">R$ {{ number_format(\App\Models\Pedido::sum('subtotal'), 2, ',', '.') }}</h3>
                    <p class="text-muted">Faturamento Total</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h3 class="text-info">{{ \App\Models\Produto::count() }}</h3>
                    <p class="text-muted">Total de Produtos</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-center">
                    <h3 class="text-warning">{{ \App\Models\Usuario::where('tipo', 'cliente')->count() }}</h3>
                    <p class="text-muted">Total de Clientes</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {!! $chartVendas->script() !!}
    {!! $chartProdutos->script() !!}
@endpush
@endsection

