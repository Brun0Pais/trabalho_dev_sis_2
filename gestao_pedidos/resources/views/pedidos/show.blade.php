@extends('layouts.app')

@section('title', 'Detalhes do Pedido')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-receipt"></i> Pedido #{{ $pedido->id }}</h4>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Itens do Pedido</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço Unit.</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->itensPedido as $item)
                                <tr>
                                    <td>{{ $item->produto->nome }}</td>
                                    <td>{{ $item->quantidade }}</td>
                                    <td>R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3">Total:</td>
                                <td>R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Informações do Pedido</h5>
            </div>
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $pedido->usuario->nome }}</p>
                <p><strong>E-mail:</strong> {{ $pedido->usuario->email }}</p>
                <p><strong>Telefone:</strong> {{ $pedido->usuario->telefone ?? 'N/A' }}</p>
                <hr>
                <p><strong>Data do Pedido:</strong> {{ $pedido->dataPedido->format('d/m/Y H:i') }}</p>
                <p><strong>Data de Entrega:</strong> {{ $pedido->dataEntrega ? $pedido->dataEntrega->format('d/m/Y') : 'N/A' }}</p>
                <p><strong>Local de Entrega:</strong> {{ $pedido->localEntrega ?? 'N/A' }}</p>
                <p><strong>Forma de Pagamento:</strong> {{ ucfirst($pedido->formaPagamento) }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $pedido->statusPagamento == 'pago' ? 'success' : ($pedido->statusPagamento == 'cancelado' ? 'danger' : 'warning') }}">
                        {{ ucfirst($pedido->statusPagamento) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ Auth::user()->isAdmin() ? route('pedidos.index') : route('pedidos.meus-pedidos') }}" 
       class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    @if(Auth::user()->isAdmin())
        <a href="{{ route('pedidos.edit', $pedido) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
    @endif
</div>
@endsection

