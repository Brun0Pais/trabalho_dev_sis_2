@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-receipt"></i> Pedidos</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('pedidos.index') }}" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Buscar por cliente..." 
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

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Data Pedido</th>
                        <th>Data Entrega</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                        <tr>
                            <td>#{{ $pedido->id }}</td>
                            <td>{{ $pedido->usuario->nome }}</td>
                            <td>{{ $pedido->dataPedido->format('d/m/Y H:i') }}</td>
                            <td>{{ $pedido->dataEntrega ? $pedido->dataEntrega->format('d/m/Y') : 'N/A' }}</td>
                            <td>R$ {{ number_format($pedido->subtotal, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $pedido->statusPagamento == 'pago' ? 'success' : ($pedido->statusPagamento == 'cancelado' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($pedido->statusPagamento) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('pedidos.show', $pedido) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('pedidos.edit', $pedido) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('pedidos.destroy', $pedido) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este pedido?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $pedidos->links() }}
</div>
@endsection

