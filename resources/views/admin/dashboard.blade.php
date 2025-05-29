@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Administrativo</h1>
        <a href="{{ route('admin.gerentes.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Crear Usuario Gerente
        </a>
    </div>

    <!-- Row: Gráfica de Usuarios -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header">Usuarios por Rol</div>
                <div class="card-body">
                    <canvas id="usuariosChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row: Productos por Categoría -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">Productos por Categoría</div>
                <div class="card-body">
                    <canvas id="productosChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Producto más vendido -->
        <div class="col-md-6 mb-4">
            <div class="card shadow">
                <div class="card-header">Producto Más Vendido</div>
                <div class="card-body">
                    <h5 class="text-primary">{{ $productoMasVendido->nombre ?? 'Ninguno' }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Comprador más frecuente por categoría -->
    <div class="card shadow mb-4">
        <div class="card-header">Comprador Más Frecuente por Categoría</div>
        <div class="card-body">
            <canvas id="compradoresChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Usuarios por Rol
    const usuariosCtx = document.getElementById('usuariosChart');
    new Chart(usuariosCtx, {
        type: 'bar',
        data: {
            labels: ['Usuarios', 'Vendedores', 'Compradores'],
            datasets: [{
                label: 'Cantidad',
                data: [{{ $totalUsuarios }}, {{ $totalVendedores }}, {{ $totalCompradores }}],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc']
            }]
        }
    });

    // Productos por Categoría
    const productosCtx = document.getElementById('productosChart');
    new Chart(productosCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($productosPorCategoria->pluck('nombre')) !!},
            datasets: [{
                label: 'Productos',
                data: {!! json_encode($productosPorCategoria->pluck('productos_count')) !!},
                backgroundColor: ['#f6c23e', '#e74a3b', '#36b9cc', '#1cc88a', '#4e73df']
            }]
        }
    });

    // Comprador Más Frecuente por Categoría
    const compradoresCtx = document.getElementById('compradoresChart');
    new Chart(compradoresCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(collect($compradorFrecuentePorCategoria)->pluck('categoria')) !!},
            datasets: [{
                label: 'Compras',
                data: {!! json_encode(collect($compradorFrecuentePorCategoria)->pluck('compras')) !!},
                backgroundColor: '#36b9cc'
            }]
        }
    });
</script>
@endsection
