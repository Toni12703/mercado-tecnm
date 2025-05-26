<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Categoria extends Model
{
    protected $fillable = ['nombre'];

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'categoria_producto');
    }

    // Relación para el dashboard: Compradores más frecuentes por categoría
    public function compradores(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Venta::class,
            'id_producto',     // Foreign key en ventas
            'id',              // Clave primaria en users
            'id',              // Clave local en categoría (a través de productos)
            'id_comprador'     // Foreign key en ventas hacia users
        )->distinct();
    }
}
