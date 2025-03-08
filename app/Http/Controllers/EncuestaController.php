<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Pregunta;
use App\Models\Opcion;
use App\Models\Respuesta;

class EncuestaController extends Controller
{
    
    public function index()
    {
        // Obtener solo las encuestas que corresponden al usuario con id_user = 1
        $encuestas = Encuesta::where('id_user', auth()->id())->get();


        // Retornar la vista con las encuestas filtradas
        return view('encuestas.index', compact('encuestas'));
    }

    public function showindex(){
        $encuestas = Encuesta::where('id_user', auth()->id())->get();
        return view('index', compact('encuestas'));
    }


    public function create()
    {
        $initialCode = $this->generateUniqueCode();  // Genera el código único
        return view('encuestas.crear', compact('initialCode'));
    }
    
    private function generateUniqueCode()
    {
        do {
            $code = Str::random(10);
        } while (Encuesta::where('code', $code)->exists());
    
        return $code;
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_user' => 'required|exists:users,id_user',
            'questions' => 'required|json',
        ]);

        // Usamos DB::transaction para guardar todo o nada
        DB::transaction(function () use ($request) {
            // 1. Guardar la encuesta
            $encuesta = Encuesta::create([
                'code' => $request->code,
                'title' => $request->title,
                'description' => $request->description,
                'id_user' => $request->id_user,
            ]);

            // 2. Guardar preguntas
            $questions = json_decode($request->questions, true);

            foreach ($questions as $q) {
                $pregunta = Pregunta::create([
                    'id_survey' => $encuesta->id_survey,
                    'text_question' => $q['text'],
                    'answer_type' => $q['type'],
                    'attributes' => json_encode($q['attributes']) // Guardamos los atributos como JSON
                ]);

                // 3. Guardar opciones si es Multiple o Rate
                if ($q['type'] == 'multiple' || $q['type'] == 'rate') {
                    foreach ($q['attributes']['options'] ?? [] as $option) {
                        Opcion::create([
                            'id_question' => $pregunta->id_question,
                            'text_option' => $option
                        ]);
                    }
                }
            }
        });

        return redirect()->route('encuestas.index')->with('success', 'Encuesta creada correctamente');
    }




    // EncuestaController.php

    public function show($code)
    {
        // Obtener la encuesta utilizando el código único
        $encuesta = Encuesta::with('preguntas.opciones')->where('code', $code)->firstOrFail();
        // Retornar la vista con la encuesta y sus preguntas
        return view('encuestas.encuesta', compact('encuesta'));
    }
    
    public function destroy($id)
    {
        Encuesta::destroy($id);

        return redirect()->route('encuestas.index')->with('success', 'Encuesta eliminada correctamente');
    }

    
    public function verResultados($id) {
        // Obtener la encuesta
        $encuesta = Encuesta::with('preguntas.opciones', 'preguntas.respuestas')->findOrFail($id);
    
        // Validar que el usuario autenticado sea el propietario de la encuesta
        if ($encuesta->id_user !== auth()->id()) {
            return redirect('/')->with('error', 'No tienes permiso para ver los resultados de esta encuesta.');
        }
    
        // Obtener respuestas agrupadas por pregunta
        $resultados = [];
        foreach ($encuesta->preguntas as $pregunta) {
            if ($pregunta->answer_type == 'multiple') {
                // Contar respuestas de opción múltiple
                $conteoRespuestas = Respuesta::where('id_question', $pregunta->id_question)
                            ->select('id_option', DB::raw('count(*) as total'))
                            ->groupBy('id_option')
                            ->pluck('total', 'id_option');
    
                // Obtener opciones de respuesta
                $opciones = $pregunta->opciones->pluck('text_option', 'id_option');
    
                // Formato de datos para gráfico
                $resultados[$pregunta->text_question] = [
                    'type' => 'multiple', // Tipo de pregunta
                    'labels' => $opciones->values(), // Etiquetas para el gráfico
                    'data' => $opciones->map(fn($opcion, $id) => $conteoRespuestas[$id] ?? 0)->values(), // Datos para el gráfico
                ];
            } elseif ($pregunta->answer_type == 'rate') {
                // Promedio de las calificaciones
                $promedio = Respuesta::where('id_question', $pregunta->id_question)->avg('answer_text');
    
                $resultados[$pregunta->text_question] = [
                    'type' => 'rate', // Tipo de pregunta
                    'promedio' => round($promedio, 2), // Valor promedio
                    'maxRate' => json_decode($pregunta->attributes)->rateCount ?? 5, // Número máximo de estrellas
                ];
            } elseif ($pregunta->answer_type == 'text') {
                // Respuestas de tipo texto
                $respuestas = Respuesta::where('id_question', $pregunta->id_question)
                            ->pluck('answer_text');
    
                $resultados[$pregunta->text_question] = [
                    'type' => 'text', // Tipo de pregunta
                    'respuestas' => $respuestas, // Lista de respuestas
                ];
            }
        }
    
        return view('encuestas.resultados', compact('encuesta', 'resultados'));
    }
}
