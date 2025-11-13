@extends('layouts.app')

@section('title', 'Estoque')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam"></i> Estoque</h2>
    <a href="{{ route('estoques.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Estoque
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('estoques.index') }}" class="row g-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" 
                       placeholder="Buscar por produto..." 
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
                        <th>Produto</th>
                        <th>Quantidade Disponível</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estoques as $estoque)
                        <tr>
                            <td>#{{ $estoque->id }}</td>
                            <td>{{ $estoque->produto->nome }}</td>
                            <td>{{ $estoque->quantidadeDisponivel }}</td>
                            <td>
                                <span class="badge bg-{{ $estoque->quantidadeDisponivel > 0 ? 'success' : 'danger' }}">
                                    {{ $estoque->quantidadeDisponivel > 0 ? 'Disponível' : 'Indisponível' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('estoques.show', $estoque) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('estoques.edit', $estoque) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('estoques.destroy', $estoque) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este estoque?');">
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
                            <td colspan="5" class="text-center">Nenhum estoque encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $estoques->links() }}
</div>
@endsection

