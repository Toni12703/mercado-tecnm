<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Boucher;

class BoucherPolicy
{
    public function viewAny(Usuario $user)
    {
        return $user->rol->nombre === 'gerente';
    }
    
    // Puedes agregar otros métodos según necesidades
}