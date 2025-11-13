<?php

namespace App\Http\Controllers;

use App\Models\Estoque;
use App\Models\Produto;
use Illuminate\Http\Request;

class EstoqueController extends Controller
{
    public function index(Request $request)
    {
        $query = Estoque::with('produto');

        if ($request->has('search') && $request->search) {
            $query->whereHas('produto', function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%');
            });
        }

        $estoques = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('estoques.index', compact('estoques'));
    }

    public function create()
    {
        $produtos = Produto::doesntHave('estoque')->orderBy('nome')->get();
        return view('estoques.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id|unique:estoques,produto_id',
            'quantidadeDisponivel' => 'required|integer|min:0',
            'dataEntrada' => 'nullable|date',
            'datasaida' => 'nullable|date',
        ]);

        Estoque::create($validated);

        return redirect()->route('estoques.index')
            ->with('success', 'Estoque criado com sucesso!');
    }

    public function show(Estoque $estoque)
    {
        $estoque->load('produto');
        return view('estoques.show', compact('estoque'));
    }

    public function edit(Estoque $estoque)
    {
        $estoque->load('produto');
        return view('estoques.edit', compact('estoque'));
    }

    public function update(Request $request, Estoque $estoque)
    {
        $validated = $request->validate([
            'quantidadeDisponivel' => 'required|integer|min:0',
            'dataEntrada' => 'nullable|date',
            'datasaida' => 'nullable|date',
        ]);

        $estoque->update($validated);

        return redirect()->route('estoques.index')
            ->with('success', 'Estoque atualizado com sucesso!');
    }

    public function destroy(Estoque $estoque)
    {
        $estoque->delete();

        return redirect()->route('estoques.index')
            ->with('success', 'Estoque excluído com sucesso!');
    }
}
