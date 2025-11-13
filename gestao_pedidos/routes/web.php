<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

// Rotas de Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas Protegidas (após login)
Route::middleware(['auth'])->group(function () {
    // CRUD Usuários
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
    Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // CRUD Produtos
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produtos.show');
    Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');

    // CRUD Pedidos
    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/create', [PedidoController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{pedido}', [PedidoController::class, 'show'])->name('pedidos.show');
    Route::get('/pedidos/{pedido}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
    Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');

    // CRUD Estoques
    Route::get('/estoques', [EstoqueController::class, 'index'])->name('estoques.index');
    Route::get('/estoques/create', [EstoqueController::class, 'create'])->name('estoques.create');
    Route::post('/estoques', [EstoqueController::class, 'store'])->name('estoques.store');
    Route::get('/estoques/{estoque}', [EstoqueController::class, 'show'])->name('estoques.show');
    Route::get('/estoques/{estoque}/edit', [EstoqueController::class, 'edit'])->name('estoques.edit');
    Route::put('/estoques/{estoque}', [EstoqueController::class, 'update'])->name('estoques.update');
    Route::delete('/estoques/{estoque}', [EstoqueController::class, 'destroy'])->name('estoques.destroy');
});
