@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Crear Usuario</h2>

    <form action="{{ route('admin.usuarios.store') }}" method="POST">
        @csrf

        <input type="text" name="name" placeholder="Nombre" class="w-full mb-3 p-2 border rounded" required>
        <input type="email" name="email" placeholder="Correo electrónico" class="w-full mb-3 p-2 border rounded" required>
        <input type="password" name="password" placeholder="Contraseña" class="w-full mb-3 p-2 border rounded" required>
        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="w-full mb-3 p-2 border rounded" required>

        <select name="role" class="w-full mb-3 p-2 border rounded" required>
            <option value="">Selecciona un rol</option>
            <option value="gerente">Gerente</option>
            <option value="vendedor">Vendedor</option>
            <option value="comprador">Comprador</option>
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Crear Usuario</button>
    </form>
</div>
@endsection
