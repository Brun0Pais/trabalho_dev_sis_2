@extends('layouts.app')

@section('title', 'Editar Estoque')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-pencil"></i> Editar Estoque - {{ $estoque->produto->nome }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('estoques.update', $estoque) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Produto</label>
                        <input type="text" class="form-control" value="{{ $estoque->produto->nome }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="quantidadeDisponivel" class="form-label">Quantidade Disponível <span class="text-danger">*</span></label>
                        <input type="number" min="0" class="form-control @error('quantidadeDisponivel') is-invalid @enderror" 
                               id="quantidadeDisponivel" name="quantidadeDisponivel" 
                               value="{{ old('quantidadeDisponivel', $estoque->quantidadeDisponivel) }}" required>
                        @error('quantidadeDisponivel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('estoques.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

