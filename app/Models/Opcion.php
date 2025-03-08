<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'options';
    protected $primaryKey = 'id_option';
    public $timestamps = true;

    protected $fillable = ['id_question', 'text_option'];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class, 'id_question');
    }
}
