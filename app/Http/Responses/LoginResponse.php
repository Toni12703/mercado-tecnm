<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        $redirect = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'cliente-comprador' => route('comprador'),
            'cliente-vendedor' => route('vendedor'),
            default => route('index'),
        };

        return redirect()->intended($redirect);
    }
}
