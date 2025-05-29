@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Registrar nuevo Gerente</h2>

    <form action="{{ route('admin.gerentes.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar gerente</button>
    </form>
</div>
@endsection
