<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Añadir esta línea
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imagen extends Model
{
    use HasFactory; // <-- Añadir esta línea

    protected $fillable = ['ruta', 'producto_id'];

    protected $table = 'imagenes';

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
