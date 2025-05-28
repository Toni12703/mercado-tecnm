<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Imagen extends Model
{
    protected $fillable = ['ruta', 'producto_id'];

    protected $table = 'imagenes';

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
