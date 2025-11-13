<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Produto;
use App\Models\ItemPedido;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class RelatorioController extends Controller
{
    public function index()
    {
        // Gráfico de Vendas por Período (últimos 6 meses)
        $vendasPorMes = Pedido::selectRaw('DATE_FORMAT(dataPedido, "%Y-%m") as mes, SUM(subtotal) as total')
            ->where('dataPedido', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $meses = $vendasPorMes->pluck('mes')->map(function($mes) {
            return date('M/Y', strtotime($mes . '-01'));
        })->toArray();
        $valores = $vendasPorMes->pluck('total')->toArray();

        $chartVendas = (new LarapexChart)
            ->setType('line')
            ->setTitle('Vendas por Período (Últimos 6 Meses)')
            ->setLabels($meses)
            ->setDataset('Vendas (R$)', $valores)
            ->setColors(['#667eea']);

        // Gráfico de Produtos Mais Vendidos
        $produtosVendidos = ItemPedido::selectRaw('produto_id, SUM(quantidade) as total_vendido')
            ->with('produto')
            ->groupBy('produto_id')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        $nomesProdutos = $produtosVendidos->pluck('produto.nome')->toArray();
        $quantidades = $produtosVendidos->pluck('total_vendido')->toArray();

        $chartProdutos = (new LarapexChart)
            ->setType('bar')
            ->setTitle('Top 5 Produtos Mais Vendidos')
            ->setLabels($nomesProdutos)
            ->setDataset('Quantidade Vendida', $quantidades)
            ->setColors(['#764ba2']);

        return view('relatorios.index', compact('chartVendas', 'chartProdutos'));
    }

    public function pedidosPdf(Request $request)
    {
        $query = Pedido::with(['usuario', 'itensPedido.produto']);

        if ($request->has('data_inicio') && $request->data_inicio) {
            $query->whereDate('dataPedido', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim') && $request->data_fim) {
            $query->whereDate('dataPedido', '<=', $request->data_fim);
        }

        if ($request->has('status') && $request->status) {
            $query->where('statusPagamento', $request->status);
        }

        $pedidos = $query->orderBy('dataPedido', 'desc')->get();

        $total = $pedidos->sum('subtotal');

        $pdf = Pdf::loadView('relatorios.pedidos-pdf', compact('pedidos', 'total'));
        return $pdf->download('relatorio-pedidos-' . date('Y-m-d') . '.pdf');
    }

    public function produtosPdf()
    {
        $produtos = Produto::with('estoque')->orderBy('nome')->get();
        $totalProdutos = $produtos->count();
        $totalEstoque = $produtos->sum(function($produto) {
            return $produto->estoque ? $produto->estoque->quantidadeDisponivel : 0;
        });

        $pdf = Pdf::loadView('relatorios.produtos-pdf', compact('produtos', 'totalProdutos', 'totalEstoque'));
        return $pdf->download('relatorio-produtos-' . date('Y-m-d') . '.pdf');
    }
}
