@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Bienvenido Vendedor</h1>
    <p>Aquí puedes gestionar tus productos y ver ventas.</p>

    <hr>

    {{-- Lista de productos --}}
    <h2>Mis productos</h2>

    @foreach ($productos as $producto)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $producto->nombre }}</h5>
                <p>{{ $producto->descripcion }}</p>
                <p><strong>Precio:</strong> ${{ $producto->precio }}</p>
                <p><strong>Categorías:</strong> {{ $producto->categorias->pluck('nombre')->join(', ') }}</p>

                {{-- Imágenes --}}
                <div class="mb-2">
                    @foreach($producto->imagenes as $img)
                        <img src="{{ asset('storage/' . $img->ruta) }}" width="100" class="me-2 mb-2">
                    @endforeach
                </div>

                {{-- Botón para editar --}}
                <form action="{{ route('productos.edit', $producto) }}" method="GET" style="display: inline-block">
                    <button class="btn btn-sm btn-warning">Editar</button>
                </form>

                {{-- Eliminar producto --}}
                <form action="{{ route('productos.destroy', $producto) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"
                        onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                </form>
            </div>
        </div>
    @endforeach

    <hr>

    {{-- Formulario de creación de producto --}}
    <h2>Crear nuevo producto</h2>

    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Descripción:</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Precio:</label>
            <input type="number" name="precio" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Categorías:</label>
            <select name="categorias[]" class="form-control" multiple required>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Imágenes:</label>
            <input type="file" name="imagenes[]" class="form-control" multiple accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Guardar producto</button>
    </form>
</div>
@endsection
