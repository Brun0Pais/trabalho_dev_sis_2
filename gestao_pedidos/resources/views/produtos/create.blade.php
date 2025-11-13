@extends('layouts.app')

@section('title', 'Novo Produto')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4><i class="bi bi-plus-circle"></i> Novo Produto</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do Produto <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome') }}" 
                               required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" 
                                  name="descricao" 
                                  rows="3">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ingredientesPrincipais" class="form-label">Ingredientes Principais</label>
                        <input type="text" 
                               class="form-control @error('ingredientesPrincipais') is-invalid @enderror" 
                               id="ingredientesPrincipais" 
                               name="ingredientesPrincipais" 
                               value="{{ old('ingredientesPrincipais') }}">
                        @error('ingredientesPrincipais')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="precoUnidade" class="form-label">Preço Unitário (R$) <span class="text-danger">*</span></label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               class="form-control @error('precoUnidade') is-invalid @enderror" 
                               id="precoUnidade" 
                               name="precoUnidade" 
                               value="{{ old('precoUnidade') }}" 
                               required>
                        @error('precoUnidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="imagem" class="form-label">Imagem do Produto</label>
                        <input type="file" 
                               class="form-control @error('imagem') is-invalid @enderror" 
                               id="imagem" 
                               name="imagem" 
                               accept="image/*">
                        <small class="form-text text-muted">Formatos aceitos: JPEG, PNG, JPG, GIF. Tamanho máximo: 2MB</small>
                        @error('imagem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
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

