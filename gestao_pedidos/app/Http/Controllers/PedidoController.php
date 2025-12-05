<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Produto;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pedido::with(['usuario', 'itensPedido.produto']);

        if ($request->has('search') && $request->search) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%');
            });
        }

        $pedidos = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('pedidos.index', compact('pedidos'));
    }

    public function meusPedidos()
    {
        $pedidos = Pedido::with(['itensPedido.produto'])
            ->where('usuario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('pedidos.meus-pedidos', compact('pedidos'));
    }

    public function create()
    {
        $carrinho = session('carrinho', []);
        
        if (empty($carrinho)) {
            return redirect()->route('catalogo.index')
                ->with('error', 'Seu carrinho está vazio!');
        }

        return view('pedidos.create', compact('carrinho'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'formaPagamento' => 'required|string',
            'dataEntrega' => 'required|date',
            'localEntrega' => 'required|string|max:255',
        ]);

        $carrinho = session('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('catalogo.index')
                ->with('error', 'Seu carrinho está vazio!');
        }

        DB::beginTransaction();
        try {
            $pedido = Pedido::create([
                'usuario_id' => Auth::id(),
                'formaPagamento' => $validated['formaPagamento'],
                'dataPedido' => now(),
                'dataEntrega' => $validated['dataEntrega'],
                'localEntrega' => $validated['localEntrega'],
                'statusPagamento' => 'pendente',
                'subtotal' => 0,
            ]);

            $total = 0;
            foreach ($carrinho as $item) {
                $produto = Produto::find($item['id']);
                
                // Verificar estoque
                if ($produto->estoque && $produto->estoque->quantidadeDisponivel < $item['quantidade']) {
                    throw new \Exception("Produto {$produto->nome} sem estoque suficiente.");
                }

                $subtotal = $item['preco'] * $item['quantidade'];
                $total += $subtotal;

                ItemPedido::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $item['id'],
                    'quantidade' => $item['quantidade'],
                    'valor_unitario' => $item['preco'],
                    'subtotal' => $subtotal,
                ]);

                // Atualizar estoque
                if ($produto->estoque) {
                    $produto->estoque->quantidadeDisponivel -= $item['quantidade'];
                    $produto->estoque->save();
                }
            }

            $pedido->subtotal = $total;
            $pedido->save();

            session(['carrinho' => []]);
            DB::commit();

            return redirect()->route('pedidos.meus-pedidos')
                ->with('success', 'Pedido realizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao processar pedido: ' . $e->getMessage());
        }
    }

    public function show(Pedido $pedido)
    {
        // Verificar se o usuário tem permissão
        if (!Auth::user()->isAdmin() && $pedido->usuario_id !== Auth::id()) {
            abort(403);
        }

        $pedido->load(['usuario', 'itensPedido.produto', 'funcionarios']);
        $funcionarios = Funcionario::where('ativo', true)->orderBy('nome')->get();
        return view('pedidos.show', compact('pedido', 'funcionarios'));
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load(['usuario', 'itensPedido.produto', 'funcionarios']);
        $funcionarios = Funcionario::where('ativo', true)->orderBy('nome')->get();
        return view('pedidos.edit', compact('pedido', 'funcionarios'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'formaPagamento' => 'required|string',
            'dataEntrega' => 'required|date',
            'localEntrega' => 'required|string|max:255',
            'statusPagamento' => 'required|string|in:pendente,pago,cancelado',
        ]);

        $pedido->update($validated);

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido excluído com sucesso!');
    }

    public function associarFuncionario(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'funcionario_id' => 'required|exists:funcionarios,id',
            'funcao' => 'required|string|max:255',
        ]);

        // Verificar se já não está associado
        if ($pedido->funcionarios()->where('funcionario_id', $validated['funcionario_id'])->exists()) {
            return back()->with('error', 'Este funcionário já está associado a este pedido!');
        }

        $pedido->funcionarios()->attach($validated['funcionario_id'], [
            'funcao' => $validated['funcao']
        ]);

        return back()->with('success', 'Funcionário associado ao pedido com sucesso!');
    }

    public function atualizarFuncaoFuncionario(Request $request, Pedido $pedido, Funcionario $funcionario)
    {
        $validated = $request->validate([
            'funcao' => 'required|string|max:255',
        ]);

        $pedido->funcionarios()->updateExistingPivot($funcionario->id, [
            'funcao' => $validated['funcao']
        ]);

        return back()->with('success', 'Função do funcionário atualizada com sucesso!');
    }

    public function removerFuncionario(Pedido $pedido, Funcionario $funcionario)
    {
        $pedido->funcionarios()->detach($funcionario->id);

        return back()->with('success', 'Funcionário removido do pedido com sucesso!');
    }
}
