<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'senha',
        'telefone',
        'tipo',
    ];

    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function isAdmin()
    {
        return $this->tipo === 'admin';
    }

    public function isCliente()
    {
        return $this->tipo === 'cliente';
    }
}
