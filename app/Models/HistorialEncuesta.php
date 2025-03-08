<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialEncuesta extends Model
{
    protected $table = 'historial_encuestas';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class, 'id_encuesta');
    }
}
