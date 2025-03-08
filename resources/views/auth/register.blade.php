<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Registro de sesión</p>

                <form method="POST" action="{{ route('register') }}" class="mx-1 mx-md-4">
                @csrf

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <x-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                      <x-label for="name" value="{{ __('Nombre') }}" />
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <x-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                      <x-label for="email" value="{{ __('Email') }}" />
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <x-input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                      <x-label for="password" value="{{ __('Contraseña') }}" />
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                      <x-input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
                      <x-label for="password_confirmation" value="{{ __('Repite tu contraseña') }}" />
                    </div>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button class="btn btn-primary btn-lg"> {{ __('Registro') }}</button>
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