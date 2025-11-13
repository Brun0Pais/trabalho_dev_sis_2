<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->senha, $usuario->senha)) {
            Auth::login($usuario);
            Session::put('usuario_tipo', $usuario->tipo);
            
            if ($usuario->isAdmin()) {
                return redirect()->route('dashboard.admin');
            } else {
                return redirect()->route('catalogo.index');
            }
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'cpf' => 'required|string|max:14|unique:usuarios,cpf',
            'telefone' => 'nullable|string|max:20',
            'senha' => 'required|string|min:6|confirmed',
        ]);

        $usuario = Usuario::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'cpf' => $validated['cpf'],
            'telefone' => $validated['telefone'] ?? null,
            'senha' => Hash::make($validated['senha']),
            'tipo' => 'cliente',
        ]);

        Auth::login($usuario);
        Session::put('usuario_tipo', 'cliente');

        return redirect()->route('catalogo.index')
            ->with('success', 'Cadastro realizado com sucesso! Bem-vindo!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }
}
