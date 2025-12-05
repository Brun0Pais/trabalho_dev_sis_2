<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Pedido;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Funcionario::query();

        if ($request->has('search') && $request->search) {
            $query->where('nome', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('cpf', 'like', '%' . $request->search . '%');
        }

        if ($request->has('ativo') && $request->ativo !== '') {
            $query->where('ativo', $request->ativo);
        }

        $funcionarios = $query->orderBy('nome')->paginate(15);

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        return view('funcionarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:funcionarios,email',
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf',
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'nullable|string|max:255',
            'dataAdmissao' => 'nullable|date',
            'ativo' => 'boolean',
        ]);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        Funcionario::create($validated);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário criado com sucesso!');
    }

    public function show(Funcionario $funcionario)
    {
        $funcionario->load('pedidos.usuario', 'pedidos.itensPedido.produto');
        return view('funcionarios.show', compact('funcionario'));
    }

    public function edit(Funcionario $funcionario)
    {
        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update(Request $request, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:funcionarios,email,' . $funcionario->id,
            'cpf' => 'required|string|max:14|unique:funcionarios,cpf,' . $funcionario->id,
            'telefone' => 'nullable|string|max:20',
            'cargo' => 'nullable|string|max:255',
            'dataAdmissao' => 'nullable|date',
            'ativo' => 'boolean',
        ]);

        $validated['ativo'] = $request->has('ativo') ? true : false;

        $funcionario->update($validated);

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário atualizado com sucesso!');
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();

        return redirect()->route('funcionarios.index')
            ->with('success', 'Funcionário excluído com sucesso!');
    }

    public function associarPedidos(Request $request, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'pedidos' => 'required|array',
            'pedidos.*' => 'exists:pedidos,id',
            'funcao' => 'nullable|string|max:255',
        ]);

        foreach ($validated['pedidos'] as $pedidoId) {
            $funcionario->pedidos()->syncWithoutDetaching([
                $pedidoId => ['funcao' => $validated['funcao'] ?? 'geral']
            ]);
        }

        return redirect()->route('funcionarios.show', $funcionario)
            ->with('success', 'Pedidos associados com sucesso!');
    }

    public function removerPedido(Request $request, Funcionario $funcionario, Pedido $pedido)
    {
        $funcionario->pedidos()->detach($pedido->id);

        return redirect()->route('funcionarios.show', $funcionario)
            ->with('success', 'Pedido removido com sucesso!');
    }
}
