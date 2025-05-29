@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Ventas para Validar</h1>

    @if(session('success'))
        <div class="bg-green-200 p-2 mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-2 py-1">ID</th>
                <th class="border border-gray-300 px-2 py-1">Comprador</th>
                <th class="border border-gray-300 px-2 py-1">Producto</th>
                <th class="border border-gray-300 px-2 py-1">Estado</th>
                <th class="border border-gray-300 px-2 py-1">Ticket</th>
                <th class="border border-gray-300 px-2 py-1">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td class="border border-gray-300 px-2 py-1">{{ $venta->id }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $venta->comprador->name }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $venta->producto->nombre }}</td>
                    <td class="border border-gray-300 px-2 py-1">{{ $venta->estado }}</td>
                    <td class="border border-gray-300 px-2 py-1">
                        <a href="{{ route('gerente.ventas.ticket', $venta) }}" target="_blank" class="text-blue-500 underline">Ver Ticket</a>
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        @if($venta->estado !== 'validada')
                            <form action="{{ route('gerente.ventas.validar', $venta) }}" method="POST" onsubmit="return confirm('¿Confirmar validación de venta?')">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Validar</button>
                            </form>
                        @else
                            <span class="text-green-600 font-semibold">Validada</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
