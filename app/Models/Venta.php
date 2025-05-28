<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <- Importación necesaria
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Usuario;
use App\Models\Producto;

class Venta extends Model
{
    use HasFactory; // <- Importante para permitir factory

    protected $fillable = ['producto_id', 'comprador_id', 'imagen_ticket', 'estado'];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function comprador(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'comprador_id');
    }
}
