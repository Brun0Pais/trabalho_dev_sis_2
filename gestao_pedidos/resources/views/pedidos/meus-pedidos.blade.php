@extends('layouts.app')

@section('title', 'Meus Pedidos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Meus Pedidos</h2>
    <a href="{{ route('catalogo.index') }}" class="btn btn-primary">
        <i class="bi bi-shop"></i> Continuar Comprando
    </a>
</div>

<div class="card">
    <div class="card-body">
        @forelse($pedidos as $pedido)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5>Pedido #{{ $pedido->id }}</h5>
                            <p class="mb-1">
                                <strong>Data:</strong> {{ $pedido->dataPedido->format('d/m/Y H:i') }}
                            </p>
                            <p class="mb-1">
                                <strong>Entrega:</strong> {{ $pedido->dataEntrega ? $pedido->dataEntrega->format('d/m/Y') : 'N/A' }}
                            </p>
                            <p class="mb-1">
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $pedido->statusPagamento == 'pago' ? 'success' : ($pedido->statusPagamento == 'cancelado' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($pedido->statusPagamento) }}
                                </span>
                            </p>
                            <p class="mb-0">
                                <strong>Total:</strong> R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <a href="{{ route('pedidos.show', $pedido) }}" class="btn btn-outline-primary">
                                <i class="bi bi-eye"></i> Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Você ainda não realizou nenhum pedido.
                <a href="{{ route('catalogo.index') }}" class="alert-link">Comece a comprar agora!</a>
            </div>
        @endforelse
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $pedidos->links() }}
</div>
@endsection

