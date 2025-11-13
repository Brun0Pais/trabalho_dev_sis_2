@extends('layouts.app')

@section('title', 'Novo Estoque')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-plus-circle"></i> Novo Estoque</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('estoques.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="produto_id" class="form-label">Produto <span class="text-danger">*</span></label>
                        <select class="form-select @error('produto_id') is-invalid @enderror" 
                                id="produto_id" name="produto_id" required>
                            <option value="">Selecione um produto...</option>
                            @foreach($produtos as $produto)
                                <option value="{{ $produto->id }}" {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                                    {{ $produto->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('produto_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantidadeDisponivel" class="form-label">Quantidade Disponível <span class="text-danger">*</span></label>
                        <input type="number" min="0" class="form-control @error('quantidadeDisponivel') is-invalid @enderror" 
                               id="quantidadeDisponivel" name="quantidadeDisponivel" value="{{ old('quantidadeDisponivel', 0) }}" required>
                        @error('quantidadeDisponivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('estoques.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

