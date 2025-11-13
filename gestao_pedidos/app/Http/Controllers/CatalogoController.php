<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::with('estoque');

        if ($request->has('search') && $request->search) {
            $query->where('nome', 'like', '%' . $request->search . '%')
                  ->orWhere('descricao', 'like', '%' . $request->search . '%');
        }

        $produtos = $query->orderBy('nome')->paginate(12);
        $carrinho = session('carrinho', []);

        return view('catalogo.index', compact('produtos', 'carrinho'));
    }

    public function adicionarCarrinho(Request $request, Produto $produto)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        $carrinho = session('carrinho', []);
        $quantidade = $request->quantidade;

        // Verificar estoque
        if ($produto->estoque && $produto->estoque->quantidadeDisponivel < $quantidade) {
            return back()->with('error', 'Quantidade indisponível em estoque.');
        }

        if (isset($carrinho[$produto->id])) {
            $carrinho[$produto->id]['quantidade'] += $quantidade;
        } else {
            $carrinho[$produto->id] = [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->precoUnidade,
                'imagem' => $produto->imagem,
                'quantidade' => $quantidade,
            ];
        }

        session(['carrinho' => $carrinho]);

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function removerCarrinho($produtoId)
    {
        $carrinho = session('carrinho', []);
        unset($carrinho[$produtoId]);
        session(['carrinho' => $carrinho]);

        return back()->with('success', 'Produto removido do carrinho!');
    }

    public function atualizarCarrinho(Request $request, $produtoId)
    {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
        ]);

        $carrinho = session('carrinho', []);
        
        if (isset($carrinho[$produtoId])) {
            $produto = Produto::find($produtoId);
            if ($produto->estoque && $produto->estoque->quantidadeDisponivel < $request->quantidade) {
                return back()->with('error', 'Quantidade indisponível em estoque.');
            }
            $carrinho[$produtoId]['quantidade'] = $request->quantidade;
            session(['carrinho' => $carrinho]);
        }

        return back()->with('success', 'Carrinho atualizado!');
    }

    public function limparCarrinho()
    {
        session(['carrinho' => []]);
        return back()->with('success', 'Carrinho limpo!');
    }
}
