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
        <div class="card mb-3">
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

        @if(Auth::user()->isAdmin())
        <!-- Funcionários do Pedido -->
        <div class="card">
            <div class="card-header">
                <h5><i class="bi bi-briefcase"></i> Funcionários</h5>
            </div>
            <div class="card-body">
                @if($pedido->funcionarios->count() > 0)
                    <ul class="list-group list-group-flush">
                        @foreach($pedido->funcionarios as $funcionario)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $funcionario->nome }}</strong><br>
                                    <small class="text-muted">
                                        <span class="badge bg-info">{{ $funcionario->pivot->funcao ?? 'Geral' }}</span>
                                    </small>
                                </div>
                                <form action="{{ route('pedidos.remover-funcionario', [$pedido, $funcionario]) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Remover este funcionário?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Nenhum funcionário associado.</p>
                @endif

                <hr>
                <h6 class="mb-3">Adicionar Funcionário</h6>
                <form action="{{ route('pedidos.associar-funcionario', $pedido) }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <select name="funcionario_id" 
                                class="form-select form-select-sm @error('funcionario_id') is-invalid @enderror" 
                                required>
                            <option value="">Selecione um funcionário</option>
                            @foreach($funcionarios as $funcionario)
                                @if(!$pedido->funcionarios->contains($funcionario->id))
                                    <option value="{{ $funcionario->id }}">{{ $funcionario->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('funcionario_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <input type="text" 
                               name="funcao" 
                               class="form-control form-control-sm @error('funcao') is-invalid @enderror" 
                               placeholder="Função (Ex: Preparador, Entregador)" 
                               value="{{ old('funcao') }}"
                               required>
                        @error('funcao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary w-100">
                        <i class="bi bi-plus-circle"></i> Adicionar
                    </button>
                </form>
            </div>
        </div>
        @endif
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

