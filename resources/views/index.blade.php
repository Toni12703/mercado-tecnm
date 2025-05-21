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

<main>
    <section class="text-center container">
        <div class="row py-lg-2">
            <div class="col-lg-12 col-md-12 mx-auto">
                <h1 class="fw-light">404 DEVS Market</h1>
                <p class="lead text-body-secondary">
                    Compra y vende productos fácilmente con tu cuenta de TECNM.
                </p>
            </div>
        </div>
    </section>

    <div class="container mt-4">
        <h2 class="text-center">Bienvenido a tu tienda universitaria</h2>
        <p class="text-center">Muy pronto podrás ver productos, ofertas, vendedores y mucho más.</p>

        <div class="row justify-content-center">
            @auth
                <a href="/dashboard" class="btn btn-primary col-md-3 m-2">Ir al panel</a>
            @else
                <a href="/login" class="btn btn-primary col-md-3 m-2">Iniciar sesión</a>
                <a href="/register" class="btn btn-outline-primary col-md-3 m-2">Registrarse</a>
            @endauth
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>