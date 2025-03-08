<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <img class="bi me-2" width="100" height="100" src="{{ asset('images/404logo.png') }}" alt="logo404devs">
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/" class="nav-link px-2 text-secondary">404DEV's Forms</a></li>
            </ul>
            <div class="text-end">
                @if(Auth::check())
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-warning">Registrarse</a>
                @endif
            </div>
        </div>
    </div>
</header>
