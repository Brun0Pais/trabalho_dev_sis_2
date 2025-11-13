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
        'subtotal',
    ];

    protected $casts = [
        'dataPedido' => 'datetime',
        'subtotal' => 'decimal:2',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class);
    }
}
