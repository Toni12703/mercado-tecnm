<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@include('components.header')

<div class="container mt-5">
    <h1>Ventas de mis productos</h1>

    @if($ventas->isEmpty())
        <div class="alert alert-info">
            No tienes ventas registradas aún.
        </div>
    @else
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Comprador</th>
                    <th>Estado</th>
                    <th>Ticket</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td>{{ $venta->comprador->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($venta->estado) }}</td>
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

    <a href="{{ route('productos.index') }}" class="btn btn-secondary mt-3">Volver a productos</a>
</div>

</body>
</html>

