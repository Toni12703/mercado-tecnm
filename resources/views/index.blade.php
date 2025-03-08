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

<main>
    <section class="text-center container">
        <div class="row py-lg-2">
            <div class="col-lg-12 col-md-12 mx-auto">
                <h1 class="fw-light">404 DEVS FORMS</h1>
                <p class="lead text-body-secondary">Crea formularios para realizar encuestas de manera sencilla y prácticas con 404DEVS Forms</p>
            </div>
        </div>
    </section>

    <!-- Pestañas -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" id="creados-tab" href="#">Formularios Creados</a>
        </li>
    </ul>

    <!-- Contenido de pestañas -->
    <div class="container mt-2">
        <!-- Sección Formularios Creados -->
        <div id="creados-content" style="display: block;">
            <div class="album">
                <div class="container">
                    <h2>Mis formularios creados</h2>
                    @auth
                        <!-- <a href="/encuestas/create" class="btn btn-primary my-2">Crear formulario</a> -->
                    @else
                        <a href="/login" class="btn btn-primary my-2">Crear formulario</a>
                    @endauth
                    <!-- Botón Administrar mis formularios -->
                    @auth
                        <a href="/encuestas" class="btn btn-primary my-2">Administrar mis formularios</a>
                    @else
                        <a href="/login" class="btn btn-primary my-2">Administrar mis formularios</a>
                    @endauth

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                        <div class="col">
                            <div class="card shadow-sm" style="height: 350px;">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center h-100">
                                    <!-- Icono de plus con un enlace a la página de creación de encuestas -->
                                    <h5>Crear Encuesta</h5>
                                    @auth
                                        <a href="/encuestas/create" class="d-flex align-items-center justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="80" height="80" stroke-width="2">
                                                <path d="M9 12h6"></path>
                                                <path d="M12 9v6"></path>
                                                <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="/login" class="d-flex align-items-center justify-content-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="80" height="80" stroke-width="2">
                                                <path d="M9 12h6"></path>
                                                <path d="M12 9v6"></path>
                                                <path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path>
                                            </svg>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        @foreach($encuestas as $encuesta)
                            <div class="col">
                                <div class="card shadow-sm" style="height: 350px;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-center">{{ $encuesta->title }}</h5>
                                        <p class="text-center text-muted">
                                            <strong>Código:</strong> <span class="encuesta-code">{{ $encuesta->code }}</span>
                                            <button class="copyCodeButton btn btn-sm btn-outline-secondary ml-2">
                                                Copiar
                                            </button>
                                        </p>
                                        <!-- Aquí se aplica el truncado de texto a 3 líneas -->
                                        <p class="card-text description-truncated">{{ $encuesta->description ?? 'Sin descripción' }}</p>
                                        <p class="mb-3">Url: <a href="{{ url('/encuestas/encuesta/' . $encuesta->code) }}" class="link">{{ url('/encuestas/encuesta/' . $encuesta->code) }}</a></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="btn-group">
                                                <a href="{{ route('encuestas.resultados', $encuesta->id_survey) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                                <!-- Formulario para eliminar con confirmación -->
                                                <form action="{{ route('encuestas.destroy', $encuesta->id_survey) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta encuesta?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                                </form>
                                            </div>
                                            <small class="text-body-secondary">
                                                @if($encuesta->created_at)
                                                    {{ $encuesta->created_at->diffForHumans() }}
                                                @else
                                                    Fecha no disponible
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($encuestas->isEmpty())
                        <p class="text-center mt-3">No has creado encuestas aún.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const creadosTab = document.getElementById("creados-tab");
        const creadosContent = document.getElementById("creados-content");

        // Mostrar solo la pestaña de "Formularios Creados"
        creadosTab.classList.add("active");
        creadosContent.style.display = "block";
    });

    // Función para copiar el código de la encuesta
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>