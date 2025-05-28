<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- Agregado
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Venta;
use App\Models\Imagen;

class Producto extends Model
{
    use HasFactory; // <-- Agregado

    protected $fillable = ['nombre', 'descripcion', 'precio', 'id_user'];

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_user');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'producto_id');
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(Imagen::class, 'producto_id');
    }
}
