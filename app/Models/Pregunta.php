<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Encuesta;
use App\Models\Opcion;
use App\Models\Respuesta;

class Pregunta extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'id_question';
    public $timestamps = true;

    protected $fillable = ['id_survey', 'text_question', 'answer_type','attributes'];

    protected $casts = [
        'attributes' => 'array', // Esto le permite trabajar con el campo como un array
    ];

    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class, 'id_survey');
    }
    

    public function opciones()
    {
        return $this->hasMany(Opcion::class, 'id_question');
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'id_question');
    }
}
