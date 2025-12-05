@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> Editar Pedido #{{ $pedido->id }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('pedidos.update', $pedido) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="formaPagamento" class="form-label">Forma de Pagamento <span class="text-danger">*</span></label>
                        <select class="form-select @error('formaPagamento') is-invalid @enderror" 
                                id="formaPagamento" 
                                name="formaPagamento" 
                                required>
                            <option value="dinheiro" {{ old('formaPagamento', $pedido->formaPagamento) == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                            <option value="cartao_credito" {{ old('formaPagamento', $pedido->formaPagamento) == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                            <option value="cartao_debito" {{ old('formaPagamento', $pedido->formaPagamento) == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                            <option value="pix" {{ old('formaPagamento', $pedido->formaPagamento) == 'pix' ? 'selected' : '' }}>PIX</option>
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
                               value="{{ old('dataEntrega', $pedido->dataEntrega ? $pedido->dataEntrega->format('Y-m-d') : '') }}" 
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
                                  required>{{ old('localEntrega', $pedido->localEntrega) }}</textarea>
                        @error('localEntrega')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="statusPagamento" class="form-label">Status do Pagamento <span class="text-danger">*</span></label>
                        <select class="form-select @error('statusPagamento') is-invalid @enderror" 
                                id="statusPagamento" 
                                name="statusPagamento" 
                                required>
                            <option value="pendente" {{ old('statusPagamento', $pedido->statusPagamento) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="pago" {{ old('statusPagamento', $pedido->statusPagamento) == 'pago' ? 'selected' : '' }}>Pago</option>
                            <option value="cancelado" {{ old('statusPagamento', $pedido->statusPagamento) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('statusPagamento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Seção de Funcionários -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="bi bi-briefcase"></i> Funcionários do Pedido</h5>
            </div>
            <div class="card-body">
                <!-- Lista de Funcionários Associados -->
                @if($pedido->funcionarios->count() > 0)
                    <div class="table-responsive mb-4">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Funcionário</th>
                                    <th>Função</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedido->funcionarios as $funcionario)
                                    <tr>
                                        <td>{{ $funcionario->nome }}</td>
                                        <td>
                                            <form action="{{ route('pedidos.atualizar-funcao-funcionario', [$pedido, $funcionario]) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <div class="input-group input-group-sm">
                                                    <input type="text" 
                                                           name="funcao" 
                                                           class="form-control" 
                                                           value="{{ $funcionario->pivot->funcao ?? 'Geral' }}"
                                                           placeholder="Ex: Preparador, Entregador">
                                                    <button type="submit" class="btn btn-outline-primary">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="{{ route('pedidos.remover-funcionario', [$pedido, $funcionario]) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Remover este funcionário do pedido?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i> Remover
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Nenhum funcionário associado a este pedido.</p>
                @endif

                <!-- Formulário para Adicionar Funcionário -->
                <hr>
                <h6 class="mb-3">Adicionar Funcionário</h6>
                <form action="{{ route('pedidos.associar-funcionario', $pedido) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-5">
                            <select name="funcionario_id" 
                                    class="form-select @error('funcionario_id') is-invalid @enderror" 
                                    required>
                                <option value="">Selecione um funcionário</option>
                                @foreach($funcionarios as $funcionario)
                                    @if(!$pedido->funcionarios->contains($funcionario->id))
                                        <option value="{{ $funcionario->id }}">{{ $funcionario->nome }} - {{ $funcionario->cargo ?? 'Sem cargo' }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('funcionario_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <input type="text" 
                                   name="funcao" 
                                   class="form-control @error('funcao') is-invalid @enderror" 
                                   placeholder="Função (Ex: Preparador, Entregador, Atendente)" 
                                   value="{{ old('funcao') }}"
                                   required>
                            @error('funcao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-plus-circle"></i> Adicionar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

