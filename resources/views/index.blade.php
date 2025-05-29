<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 DEVS Market</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
@include('components.header')
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Productos disponibles</h1>

    {{-- Filtro por categoría --}}
<form method="GET" action="{{ route('index') }}" class="mb-6">
        <label for="categoria" class="block mb-2 font-semibold">Filtrar por categoría:</label>
        <select name="categoria" id="categoria" onchange="this.form.submit()" class="border rounded px-3 py-2">
            <option value="">-- Todas --</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- Productos --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($productos as $producto)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
<img src="https://picsum.photos/seed/{{ $producto->id }}/300/200" alt="Producto aleatorio">
                <div class="p-4">
                    <h2 class="text-lg font-bold">{{ $producto->nombre }}</h2>
                    <p class="text-sm text-gray-600 mb-2">{{ $producto->descripcion }}</p>
                    <p class="text-blue-600 font-semibold mb-4">$ {{ number_format($producto->precio, 2) }}</p>

                    @if(auth()->check ())
                        <a href="{{ route('comprar.producto', $producto->id) }}"
                           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Comprar / Subir Ticket
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400">
                            Inicia sesión para comprar
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-3">No hay productos disponibles.</p>
        @endforelse
    </div>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>