<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'id_usuario'];

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }

    public function ventas(): HasMany
    {
        return $this->hasMany(Venta::class, 'id_producto');
    }
}
