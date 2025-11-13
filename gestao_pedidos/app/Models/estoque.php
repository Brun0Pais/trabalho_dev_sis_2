<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estoque extends Model
{
    use HasFactory;

    protected $fillable = [
        'produto_id',
        'quantidadeDisponivel',
    ];

    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class);
    }
}
