<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'telefone',
        'cargo',
        'dataAdmissao',
        'ativo',
    ];

    protected $casts = [
        'dataAdmissao' => 'date',
        'ativo' => 'boolean',
    ];

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'funcionarios_pedidos')
            ->withPivot('funcao')
            ->withTimestamps();
    }
}
