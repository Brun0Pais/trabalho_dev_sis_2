@extends('layouts.app')

@section('title', 'Finalizar Pedido')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-cart-check"></i> Finalizar Pedido</h4>
            </div>
            <div class="card-body">
                <h5 class="mb-3">Itens do Pedido</h5>
                <div class="table-responsive mb-4">
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
                            @php $total = 0; @endphp
                            @foreach($carrinho as $item)
                                @php $subtotal = $item['preco'] * $item['quantidade']; $total += $subtotal; @endphp
                                <tr>
                                    <td>{{ $item['nome'] }}</td>
                                    <td>{{ $item['quantidade'] }}</td>
                                    <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                                    <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3">Total:</td>
                                <td>R$ {{ number_format($total, 2, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <form action="{{ route('pedidos.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="formaPagamento" class="form-label">Forma de Pagamento <span class="text-danger">*</span></label>
                        <select class="form-select @error('formaPagamento') is-invalid @enderror" 
                                id="formaPagamento" 
                                name="formaPagamento" 
                                required>
                            <option value="">Selecione...</option>
                            <option value="dinheiro" {{ old('formaPagamento') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                            <option value="cartao_credito" {{ old('formaPagamento') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                            <option value="cartao_debito" {{ old('formaPagamento') == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                            <option value="pix" {{ old('formaPagamento') == 'pix' ? 'selected' : '' }}>PIX</option>
                        </select>
                        @error('formaPagamento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="dataEntrega" class="form-label">Data de Entrega <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('dataEntrega') is-invalid @enderror" 
                               id="dataEntrega" 
                               name="dataEntrega" 
                               value="{{ old('dataEntrega') }}" 
                               min="{{ date('Y-m-d') }}" 
                               required>
                        @error('dataEntrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="localEntrega" class="form-label">Local de Entrega <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('localEntrega') is-invalid @enderror" 
                                  id="localEntrega" 
                                  name="localEntrega" 
                                  rows="3" 
                                  required>{{ old('localEntrega') }}</textarea>
                        <small class="form-text text-muted">Informe o endereço completo para entrega</small>
                        @error('localEntrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('catalogo.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Confirmar Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

