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
        'tipo',
    ];

    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
