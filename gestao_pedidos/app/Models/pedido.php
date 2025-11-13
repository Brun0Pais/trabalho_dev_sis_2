<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'formaPagamento',
        'dataPedido',
        'dataEntrega',
        'localEntrega',
        'statusPagamento',
        'subtotal',
    ];

    protected $casts = [
        'dataPedido' => 'datetime',
        'dataEntrega' => 'date',
        'subtotal' => 'decimal:2',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }

    public function itensPedido()
    {
        return $this->hasMany(ItemPedido::class);
    }

    public function calcularTotal()
    {
        return $this->itensPedido->sum('subtotal');
    }
}
