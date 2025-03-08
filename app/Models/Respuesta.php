<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Survey;
use App\Models\Usuario;
use App\Models\Pregunta;
use App\Models\Opcion;


class Respuesta extends Model
{
    protected $table = 'answers';
    protected $primaryKey = 'id_answer';
    public $timestamps = true;
    
    
    protected $fillable = ['id_user', 'id_question', 'id_survey', 'id_option', 'answer_text', 'answer_date'];

    // Si id_user puede ser nulo, asegúrate de que esté correctamente configurado en la base de datos
    protected $casts = [
        'id_user' => 'integer', // Aseguramos que se caste correctamente si es necesario
    ];

    public function encuesta()
    {
        return $this->belongsTo(Survey::class, 'id_survey');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_user');
    }

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_question');
    }

    public function opcion()
    {
        return $this->belongsTo(Opcion::class, 'id_option');
    }
}
