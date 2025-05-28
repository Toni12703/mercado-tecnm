<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Ventas del Vendedor</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
@include('components.header')

<div class="container mt-4">
    <h1>Ventas de tus productos</h1>

    @if($ventas->isEmpty())
        <p>No tienes ventas registradas aún.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Comprador</th>
                    <th>Estado</th>
                    <th>Ticket</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td>{{ $venta->comprador->name ?? 'Desconocido' }}</td>
                        <td>{{ $venta->estado }}</td>
                        <td>
                            @if($venta->imagen_ticket)
                                <a href="{{ asset('storage/' . $venta->imagen_ticket) }}" target="_blank">Ver ticket</a>
                            @else
                                Sin ticket
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('productos.index') }}" class="btn btn-primary mt-3">Volver a productos</a>
</div>

</body>
</html>
