<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'surveys';
    protected $primaryKey = 'id_survey';
    public $timestamps = true; // Las migraciones tienen created_at y updated_at

    protected $fillable = ['code', 'title', 'description', 'id_user'];

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'id_survey');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_user');
    }   
}