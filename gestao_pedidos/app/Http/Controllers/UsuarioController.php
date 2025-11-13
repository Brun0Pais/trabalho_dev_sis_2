<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::query();

        if ($request->has('search') && $request->search) {
            $query->where('nome', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $usuarios = $query->orderBy('nome')->paginate(15);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'cpf' => 'required|string|max:14|unique:usuarios,cpf',
            'telefone' => 'nullable|string|max:20',
            'senha' => 'required|string|min:6',
            'tipo' => 'required|in:cliente,admin',
        ]);

        $validated['senha'] = Hash::make($validated['senha']);

        Usuario::create($validated);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('pedidos');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        // Usuário só pode editar seu próprio perfil, exceto admin
        if (!Auth::user()->isAdmin() && Auth::id() !== $usuario->id) {
            abort(403);
        }

        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        // Usuário só pode editar seu próprio perfil, exceto admin
        if (!Auth::user()->isAdmin() && Auth::id() !== $usuario->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'cpf' => 'required|string|max:14|unique:usuarios,cpf,' . $usuario->id,
            'telefone' => 'nullable|string|max:20',
            'senha' => 'nullable|string|min:6',
            'tipo' => Auth::user()->isAdmin() ? 'required|in:cliente,admin' : 'prohibited',
        ]);

        if (isset($validated['senha']) && $validated['senha']) {
            $validated['senha'] = Hash::make($validated['senha']);
        } else {
            unset($validated['senha']);
        }

        $usuario->update($validated);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(Usuario $usuario)
    {
        if ($usuario->id === Auth::id()) {
            return back()->with('error', 'Você não pode excluir seu próprio usuário!');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário excluído com sucesso!');
    }
}
