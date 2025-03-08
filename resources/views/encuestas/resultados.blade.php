<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la Encuesta</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- FontAwesome para las estrellas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
@include('components.header')

<div class="container mt-4">
    <section class="container-results">
        <div class="resultados-header shadow">
            <h2>Resultados de la Encuesta: {{ $encuesta->title }}</h2>
            <p class="card-text description-truncated">{{ $encuesta->description }}</p>
            <a href="{{ url('/encuestas') }}" class="btn btn-primary mt-4">Volver a Encuestas</a>
        </div>
        <div class="resultados-content shadow-sm">
            @php
                $contadorPreguntas = 1; // Inicializamos el contador de preguntas
            @endphp
            @foreach($resultados as $pregunta => $datos)
                <div class="resultados-card">
                    <!-- Mostramos el contador de preguntas -->
                    <h4>Pregunta {{ $contadorPreguntas }}</h4>
                    <h5>{{ $pregunta}}</h5>
                    @php
                        $contadorPreguntas++; // Incrementamos el contador
                    @endphp

                    @if($datos['type'] == 'text')
                        <!-- Preguntas de tipo "text": Mostrar tabla con DataTables -->
                        <table id="table-{{ Str::slug($pregunta) }}" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Respuesta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datos['respuestas'] as $respuesta)
                                    <tr>
                                        <td>{{ $respuesta }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                $('#table-{{ Str::slug($pregunta) }}').DataTable();
                            });
                        </script>

                    @elseif($datos['type'] == 'multiple')
                        <!-- Preguntas de tipo "multiple": Mostrar gráficos de barras y pastel -->
                        <div class="row">
                            <div class="row-md-6 mb-4">
                                <canvas id="chart-{{ Str::slug($pregunta) }}"></canvas>
                            </div>
                            
                            <div class="pastel">
                                <canvas id="pie-chart-{{ Str::slug($pregunta) }}"></canvas>
                            </div>
                        </div>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Gráfico de barras
                                var ctxBar = document.getElementById("chart-{{ Str::slug($pregunta) }}").getContext("2d");
                                new Chart(ctxBar, {
                                    type: 'bar',
                                    data: {
                                        labels: {!! json_encode($datos['labels']) !!},
                                        datasets: [{
                                            label: 'Respuestas',
                                            data: {!! json_encode($datos['data']) !!},
                                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: { beginAtZero: true }
                                        }
                                    }
                                });

                                // Gráfico de pastel
                                var ctxPie = document.getElementById("pie-chart-{{ Str::slug($pregunta) }}").getContext("2d");
                                new Chart(ctxPie, {
                                    type: 'pie',
                                    data: {
                                        labels: {!! json_encode($datos['labels']) !!},
                                        datasets: [{
                                            label: 'Respuestas',
                                            data: {!! json_encode($datos['data']) !!},
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.6)',
                                                'rgba(54, 162, 235, 0.6)',
                                                'rgba(255, 206, 86, 0.6)',
                                                'rgba(75, 192, 192, 0.6)',
                                                'rgba(153, 102, 255, 0.6)',
                                                'rgba(255, 159, 64, 0.6)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true
                                    }
                                });
                            });
                        </script>
                        @elseif($datos['type'] == 'rate')
                            <div class="star-rating">
                                @php
                                    $promedio = $datos['promedio']; // Valor promedio de las respuestas
                                    $maxRate = $datos['maxRate']; // Número máximo de estrellas
                                    $etiquetaCalidad = '';
                                    if ($maxRate == 5) {
                                        if ($promedio >= 4.5) {
                                            $etiquetaCalidad = 'Excelente';
                                        } elseif ($promedio >= 3.5) {
                                            $etiquetaCalidad = 'Bueno';
                                        } elseif ($promedio >= 2.5) {
                                            $etiquetaCalidad = 'Intermedio';
                                        } elseif ($promedio >= 1.5) {
                                            $etiquetaCalidad = 'Marginal';
                                        } else {
                                            $etiquetaCalidad = 'Deficiente';
                                        }
                                    } elseif ($maxRate == 3) {
                                        if ($promedio >= 2.5) {
                                            $etiquetaCalidad = 'Bueno';
                                        } elseif ($promedio >= 1.5) {
                                            $etiquetaCalidad = 'Intermedio';
                                        } else {
                                            $etiquetaCalidad = 'Marginal';
                                        }
                                    }
                                @endphp
                                @for($i = $maxRate; $i >= 1; $i--)
                                    <i class="fas fa-star {{ $i <= $promedio ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                                <span class="ms-2">{{ number_format($promedio, 1) }} / {{ $maxRate }} ({{ $etiquetaCalidad }})</span>
                            </div>
                        @endif
                </div>
                <hr class="line mt-5">
            @endforeach
        </div>
    </section>
</div>

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>
</html>