<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome para las estrellas -->
</head>
<body>
@include('components.header')

<div class="container container-encuestas">
    <div class="mb-3 header-form shadow">
        <center>    
            <h1>Encuesta: {{ $encuesta->title }}</h1>
            <p>{{ $encuesta->description }}</p>
        </center>
    </div>
    <div class="content-form shadow-sm">
        <form action="{{ route('respuestas.store', $encuesta->id_survey) }}" method="POST">
            @csrf
            <input type="hidden" name="id_survey" value="{{ $encuesta->id_survey }}">
            <input type="hidden" name="id_user" value="{{ Auth::check() ? Auth::id() : '' }}">

            @foreach($encuesta->preguntas as $pregunta)
                <div class="mb-3">
                    <h4>{{ $pregunta->text_question }}</h4>
                    
                    @php
                        $atributos = json_decode($pregunta->attributes);
                    @endphp

                    @if($pregunta->answer_type == 'text')
                        <!-- Campo de texto con altura dinámica -->
                        <!-- Campo de texto con altura dinámica y transformación de texto -->
                        <textarea 
                            name="respuestas[{{ $pregunta->id_question }}]" 
                            class="form-control dynamic-height" 
                            @if(isset($atributos->charLimit)) maxlength="{{ $atributos->charLimit }}" @endif  
                            required
                            oninput="formatText(this, '{{ isset($atributos->uppercase) && $atributos->uppercase ? 'uppercase' : (isset($atributos->lowercase) && $atributos->lowercase ? 'lowercase' : '') }}')">
                        </textarea>
                        <!-- Script para ajustar la altura del textarea -->
                        <script>
                            const textarea = document.querySelector('textarea[name="respuestas[{{ $pregunta->id_question }}]"]');
                            const maxLength = {{ $atributos->charLimit ?? 100 }};
                            textarea.style.height = Math.min(Math.max(maxLength / 2, 38), 200) + 'px'; // Ajustar altura
                        </script>

                    @elseif($pregunta->answer_type == 'multiple')
                        <!-- Pregunta de opción múltiple -->
                        <div>
                            @foreach($pregunta->opciones as $opcion)
                                <label>
                                    <input type="radio" 
                                        name="respuestas[{{ $pregunta->id_question }}]" 
                                        value="{{ $opcion->id_option }}" 
                                        required> {{ $opcion->text_option }}
                                </label><br>
                            @endforeach
                        </div>

                    @elseif($pregunta->answer_type == 'rate')
                        <!-- Sistema de calificación con estrellas -->
                        <div class="star-rating">
                            @php
                                $rateCount = $atributos->rateCount ?? 5; // Número de estrellas (3 o 5)
                            @endphp
                            @for($i = $rateCount; $i >= 1; $i--)
                                <input type="radio" 
                                    name="respuestas[{{ $pregunta->id_question }}]" 
                                    id="star{{ $i }}_{{ $pregunta->id_question }}" 
                                    value="{{ $i }}" 
                                    required>
                                <label for="star{{ $i }}_{{ $pregunta->id_question }}">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                    @endif
                </div>
            @endforeach

            <hr class="line mt-5">
            <button type="submit" class="btn btn-primary mt-3">Enviar Respuestas</button>
        </form>
    </div>
</div>

<script>
    function formatText(element, format) {
        if (format === 'uppercase') {
            element.value = element.value.toUpperCase();
        } else if (format === 'lowercase') {
            element.value = element.value.toLowerCase();
        }
    }
</script>

</body>

</html>