<?php

use App\Models\Usuario;
use App\Models\Venta;

class VentaPolicy
{
    public function viewTicket(User $user, Venta $venta)
    {
        return $user->id === $venta->id_comprador || $user->hasRole('gerente');
    }

    public function validateVenta(User $user, Venta $venta)
    {
        return $user->hasRole('gerente');
    }

    public function viewAllBouchers(User $user)
    {
        return $user->hasRole('gerente');
    }

}
