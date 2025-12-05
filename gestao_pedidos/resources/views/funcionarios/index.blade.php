@extends('layouts.app')

@section('title', 'Funcionários')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-briefcase"></i> Funcionários</h2>
    <a href="{{ route('funcionarios.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Novo Funcionário
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('funcionarios.index') }}" class="row g-3">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" 
                       placeholder="Buscar por nome, e-mail ou CPF..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="ativo" class="form-select">
                    <option value="">Todos</option>
                    <option value="1" {{ request('ativo') == '1' ? 'selected' : '' }}>Ativos</option>
                    <option value="0" {{ request('ativo') == '0' ? 'selected' : '' }}>Inativos</option>
                </select>
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
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Cargo</th>
                        <th>Data Admissão</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($funcionarios as $funcionario)
                        <tr>
                            <td>#{{ $funcionario->id }}</td>
                            <td>{{ $funcionario->nome }}</td>
                            <td>{{ $funcionario->email }}</td>
                            <td>{{ $funcionario->cpf }}</td>
                            <td>{{ $funcionario->cargo ?? 'N/A' }}</td>
                            <td>{{ $funcionario->dataAdmissao ? $funcionario->dataAdmissao->format('d/m/Y') : 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $funcionario->ativo ? 'success' : 'secondary' }}">
                                    {{ $funcionario->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('funcionarios.show', $funcionario) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('funcionarios.edit', $funcionario) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('funcionarios.destroy', $funcionario) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este funcionário?');">
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
                            <td colspan="8" class="text-center">Nenhum funcionário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $funcionarios->links() }}
        </div>
    </div>
</div>
@endsection

