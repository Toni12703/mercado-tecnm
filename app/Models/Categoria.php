<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'categoria_producto');
    }

    // Relación para el dashboard: Compradores más frecuentes por categoría
    public function compradores(): HasManyThrough
{
    return $this->hasManyThrough(
        Usuario::class,
        Venta::class,
        'producto_id',     // Foreign key en ventas
        'id_user',         // Clave primaria en users
        'id',              // Clave local en categoría (a través de productos)
        'comprador_id'     // Foreign key en ventas hacia users
    )->distinct();
}
}
