@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Dashboard Administrativo</h1>
    
    <ul class="space-y-2">
        <li><strong>Total de Usuarios:</strong> {{ $totalUsuarios }}</li>
        <li><strong>Vendedores:</strong> {{ $totalVendedores }}</li>
        <li><strong>Compradores:</strong> {{ $totalCompradores }}</li>
    </ul>

    <h2 class="mt-6 text-xl font-semibold">Productos por Categoría</h2>
    <ul>
        @foreach($productosPorCategoria as $cat)
            <li>{{ $cat->nombre }}: {{ $cat->productos_count }} productos</li>
        @endforeach
    </ul>

    <h2 class="mt-6 text-xl font-semibold">Producto Más Vendido</h2>
    <p>{{ $productoMasVendido->nombre ?? 'Ninguno' }}</p>

    <h2 class="mt-6 text-xl font-semibold">Comprador Más Frecuente por Categoría</h2>
    <ul>
        @foreach($compradorFrecuentePorCategoria as $dato)
            <li>{{ $dato['categoria'] }} - {{ $dato['comprador'] ?? 'Sin datos' }} ({{ $dato['compras'] }} compras)</li>
        @endforeach
    </ul>
</div>
@endsection
