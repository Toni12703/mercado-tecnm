<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Venta extends Model
{
    protected $fillable = ['id_producto', 'id_comprador', 'imagen_ticket', 'estado'];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function comprador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_comprador');
    }
}