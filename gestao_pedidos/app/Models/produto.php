<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'ingredientesPrincipais',
        'precoUnidade',
        'imagem',
        'categoria_id',
    ];

    public function estoque()
    {
        return $this->hasOne(Estoque::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'itens_pedido')
            ->withPivot(['quantidade', 'valor_unitario', 'subtotal']);
    }
}
