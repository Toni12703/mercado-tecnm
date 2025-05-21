<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        $redirect = match ($user->role) {
            'administrador' => '/admin',
            'gerente' => '/gerente',
            'cliente-comprador' => '/comprador',
            'cliente-vendedor' => '/vendedor',
            default => '/',
        };

        return redirect()->intended($redirect);
    }
}