<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\RelatorioController;

Route::get('/', function () {
    return redirect('/login');
});

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas Protegidas (após login)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.admin');
        }
        return redirect()->route('catalogo.index');
    })->name('dashboard');

    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->name('dashboard.admin')->middleware('admin');

    // Catálogo (Clientes)
    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
    Route::post('/catalogo/{produto}/adicionar', [CatalogoController::class, 'adicionarCarrinho'])->name('catalogo.adicionar');
    Route::delete('/catalogo/{produtoId}/remover', [CatalogoController::class, 'removerCarrinho'])->name('catalogo.remover');
    Route::put('/catalogo/{produtoId}/atualizar', [CatalogoController::class, 'atualizarCarrinho'])->name('catalogo.atualizar');
    Route::delete('/catalogo/limpar', [CatalogoController::class, 'limparCarrinho'])->name('catalogo.limpar');
    // CRUD Usuários - Rotas públicas (edit e update podem ser acessadas pelo próprio usuário)
    Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    
    // CRUD Usuários - Rotas administrativas
    Route::middleware('admin')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });

    // CRUD Produtos - Rotas públicas
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    
    // CRUD Produtos - Rotas administrativas (rotas específicas primeiro para evitar conflito)
    Route::middleware('admin')->group(function () {
        Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
        Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
        Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
        Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
        Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
    });
    
    // Rota pública de visualização (deve vir depois das rotas específicas)
    Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');

    // CRUD Pedidos
    Route::get('/pedidos/meus-pedidos', [PedidoController::class, 'meusPedidos'])->name('pedidos.meus-pedidos');
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    
    // Rotas administrativas de pedidos
    Route::middleware('admin')->group(function () {
        Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
        Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update');
        Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');
    });

    // Relatórios - Apenas admin
    Route::middleware('admin')->group(function () {
        Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
        Route::get('/relatorios/pedidos/pdf', [RelatorioController::class, 'pedidosPdf'])->name('relatorios.pedidos.pdf');
        Route::get('/relatorios/produtos/pdf', [RelatorioController::class, 'produtosPdf'])->name('relatorios.produtos.pdf');
    });

    // CRUD Estoques - Apenas admin
    Route::middleware('admin')->group(function () {
        Route::get('/estoques', [EstoqueController::class, 'index'])->name('estoques.index');
        Route::get('/estoques/create', [EstoqueController::class, 'create'])->name('estoques.create');
        Route::post('/estoques', [EstoqueController::class, 'store'])->name('estoques.store');
        Route::get('/estoques/{estoque}', [EstoqueController::class, 'show'])->name('estoques.show');
        Route::get('/estoques/{estoque}/edit', [EstoqueController::class, 'edit'])->name('estoques.edit');
        Route::put('/estoques/{estoque}', [EstoqueController::class, 'update'])->name('estoques.update');
        Route::delete('/estoques/{estoque}', [EstoqueController::class, 'destroy'])->name('estoques.destroy');
    });
});
