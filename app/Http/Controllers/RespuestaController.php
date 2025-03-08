<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\Encuesta;


class RespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $surveyId)
    {
        // Validar que todas las respuestas se envíen correctamente
        $validated = $request->validate([
            'respuestas.*' => 'required', // Validamos que cada respuesta esté presente
            'id_user' => 'nullable|exists:users,id_user', // Validar el id_user si está presente
            'id_survey' => 'required|exists:surveys,id_survey', // Validar que id_survey sea válido
        ]);
    
        // Obtener la encuesta
        $encuesta = Encuesta::findOrFail($surveyId);
    
        // Verificar si el usuario está logueado
        $userId = auth()->check() ? auth()->id() : null; // Usar auth para obtener el id del usuario si está logueado
    
        // Si no hay un usuario logueado, usar el id_user del request (en caso de ser un invitado)
        $userId = $userId ?? $request->input('id_user');
    
        // Procesar las respuestas
        foreach ($encuesta->preguntas as $pregunta) {
            $respuesta = $request->input('respuestas.' . $pregunta->id_question);
            $atributos = json_decode($pregunta->attributes, true);
    
            // Validación y procesamiento según tipo de respuesta
            if ($pregunta->answer_type == 'multiple') {
                // Para preguntas múltiples (pero con radio, solo una opción seleccionada)
                Respuesta::create([
                    'id_user' => $userId,
                    'id_survey' => $surveyId,
                    'id_question' => $pregunta->id_question,
                    'id_option' => $respuesta, // Guardamos el id de la opción seleccionada
                    'answer_text' => null, // No es necesario para respuestas múltiples
                    'answer_date' => now(),
                ]);
    
            } elseif ($pregunta->answer_type == 'rate') {
                // Para preguntas de tipo "rate", guardamos un número entre 1 y el máximo permitido
                $maxRate = $atributos['rateCount'] ?? 5; // Rango por defecto es de 1 a 5
                $respuesta = (int)$respuesta;
    
                // Validación para asegurarnos de que la respuesta esté dentro del rango
                if ($respuesta < 1 || $respuesta > $maxRate) {
                    return back()->withErrors(['respuestas.' . $pregunta->id_question => 'La calificación debe estar entre 1 y ' . $maxRate . '.']);
                }
    
                // Guardar el valor de la calificación (número)
                Respuesta::create([
                    'id_user' => $userId,
                    'id_survey' => $surveyId,
                    'id_question' => $pregunta->id_question,
                    'id_option' => null, // No es necesario para respuestas de tipo rate
                    'answer_text' => $respuesta, // Guardamos la calificación numérica
                    'answer_date' => now(),
                ]);
    
            } else {
                // Para preguntas de tipo "text", guardamos el texto proporcionado
                Respuesta::create([
                    'id_user' => $userId,
                    'id_survey' => $surveyId,
                    'id_question' => $pregunta->id_question,
                    'id_option' => null, // No es necesario para respuestas de tipo texto
                    'answer_text' => $respuesta, // Guardamos el texto proporcionado por el usuario
                    'answer_date' => now(),
                ]);
            }
        }
        return redirect()->route('index')->with('success', 'Respuestas enviadas correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
