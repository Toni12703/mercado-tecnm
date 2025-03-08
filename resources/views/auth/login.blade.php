<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
    
<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Inicio de sesión</p>

                <form method="POST" action="{{ route('login') }}">
        @csrf
          

          <div class="divider d-flex align-items-center my-4">
            <p class="text-center fw-bold mx-3 mb-0">Iniciar Sesión</p>
          </div>

          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="form3Example3" class="form-control form-control-lg" name="email" :value="old('email')" required autofocus autocomplete="username"
              placeholder="Ingresa un Correo Valido" />
            <x-label for="email" value="{{ __('Correo Electrónico') }}"/>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-3">
          <input type="password" id="form3Example4" class="form-control form-control-lg" name="password" required autocomplete="current-password" 
          placeholder="Ingresar Contraseña" />
          <x-label for="password" value="{{ __('Contraseña') }}" />
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" class="form-check-input me-2" value=""  name="remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recuérdame') }}</span>
                </label>
            </div>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button  class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;">{{ __('Iniciar Sesión') }}</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">No has creado una cuenta? <a href="/register"
                class="link-danger">Registrar</a></p>
          </div>

        </form>

              </div>
              <div class="col-md-9 col-lg-6 col-xl-6">
                <img class='logo404' src="{{ asset('images/404logo.png') }}" alt="logo404devs">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    
</body>
</html>
