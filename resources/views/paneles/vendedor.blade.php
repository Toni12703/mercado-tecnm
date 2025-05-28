<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendedor</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome para las estrellas -->
</head>
<body>
@include('components.header')

  <h1>Bienvenido Vendedor</h1>
  <p>Aquí puedes gestionar tus productos y ver ventas.</p>
    <a href="{{ route('ventas.index') }}" class="btn btn-success mb-3">Ver mis ventas</a>
    
<h2>Agregar nuevo producto</h2>
<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-center">
  @csrf

  <div class="col-md-3">
    <label for="nombre" class="form-label">Nombre:</label>
    <input type="text" name="nombre" id="nombre" class="form-control" required>
  </div>

  <div class="col-md-4">
    <label for="descripcion" class="form-label">Descripción:</label>
    <textarea name="descripcion" id="descripcion" class="form-control" rows="2" required></textarea>
  </div>

  <div class="col-md-2">
    <label for="precio" class="form-label">Precio:</label>
    <input type="number" step="1.00" name="precio" id="precio" class="form-control" required>
  </div>


  <div class="col-12">
    <button type="submit" class="btn btn-primary mt-3">Agregar producto</button>
  </div>
</form>

  <h2>Mis productos</h2>

  @foreach($productos as $producto)
    <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
      <strong>{{ $producto->nombre }}</strong><br>
      {{ $producto->descripcion }}<br>
      Precio: ${{ number_format($producto->precio, 2) }}<br>

      <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Eliminar</button>
      </form>

      <a href="{{ route('productos.edit', $producto->id) }}">Editar</a>
    </div>
  @endforeach

</body>
</html>
