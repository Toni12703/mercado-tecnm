<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class GerenteController extends Controller
{
    public function ventas()
    {
        // Carga las relaciones necesarias
        $ventas = Venta::with(['producto', 'comprador'])->get();

        // Envía la variable a la vista
        return view('gerente.ventas', compact('ventas'));
    }

    public function showTicket(Venta $venta)
    {
        $this->authorize('viewTicket', $venta);

        // Retornar la imagen desde disco privado
        return response()->file(storage_path('app/private/' . $venta->ticket));
    }

    public function validarVenta(Request $request, Venta $venta)
    {
        $this->authorize('validateVenta', $venta);

        $venta->estado = 'validada';
        $venta->save();

        // Aquí puedes disparar las notificaciones por correo

        return redirect()->back()->with('success', 'Venta validada correctamente.');
    }
}

