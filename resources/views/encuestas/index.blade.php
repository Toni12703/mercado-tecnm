<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuestas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
@include('components.header')
    <div class="container mt-5">
        <center>
            <h2>Lista de Encuestas</h2>
        </center>
        <div class="mt-3 container-encuestas ">
            @foreach ($encuestas as $encuesta)
            <div class="encuesta-card shadow" style="height: 350px;">
                <p class="text-center text-muted">
                    <strong>Código:</strong> <span class="encuesta-code">{{ $encuesta->code }}</span>
                    <button class="copyCodeButton btn btn-sm btn-outline-secondary ml-2">
                        Copiar
                    </button>
                </p>

                <script>
                     document.querySelectorAll('.copyCodeButton').forEach(button => {
        button.addEventListener('click', function (event) {
            const button = event.target; // Botón que se hizo clic
            const codeElement = button.parentElement.querySelector('.encuesta-code'); // Obtener el elemento del código
            const code = codeElement.textContent.trim(); // Obtener el código

            // Copiar al portapapeles
            navigator.clipboard.writeText(code)
                .then(() => {
                    // Cambiar el texto del botón a "Copiado!"
                    button.innerHTML = "Copiado!";

                    // Restaurar el texto original después de 2 segundos
                    setTimeout(() => {
                        button.innerHTML = "Copiar";
                    }, 2000); // 2000 milisegundos = 2 segundos
                })
                .catch((err) => {
                    console.error('Error al copiar el código: ', err);
                    button.innerHTML = "Error"; // Cambiar el texto a "Error" si falla
                    setTimeout(() => {
                        button.innerHTML = "Copiar";
                    }, 2000); // Restaurar el texto original después de 2 segundos
                });
        });
    });

                </script>

                <h4 class="mb-3 description-truncated">Url: <a href="{{ url('/encuestas/encuesta/' . $encuesta->code) }}" class="link">{{ url('/encuestas/encuesta/' . $encuesta->code) }}</a></h4>
                <a href="{{ route('encuestas.resultados', $encuesta->id_survey) }}" class="list-group-item list-group-item-action" style="height: 150px;">
                    <h5 class="mb-1">Titulo: {{ $encuesta->title }}</h5>
                    <li class="card-text description-truncated">{{ $encuesta->description }}</li>
                    <small>Creada por: {{ $encuesta->usuario->name ?? 'Usuario no disponible' }}</small> <!-- Asumiendo que hay una relación con el modelo User -->
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
