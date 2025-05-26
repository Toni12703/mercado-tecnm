<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VentaValidadaVendedor;
use App\Mail\VentaValidadaComprador;
use Illuminate\Support\Facades\Auth;

class ValidacionVentaController extends Controller
{
    public function validar($id)
    {
        $venta = Venta::with(['producto.vendedor', 'comprador'])->findOrFail($id);

        // Solo el gerente puede validar
        if (Auth::user()->rol->nombre !== 'gerente') {
            abort(403, 'No tienes permisos para validar esta venta.');
        }

        // Marcar la venta como validada
        $venta->estado = 'validada';
        $venta->save();

        // Enviar correos
        Mail::to($venta->producto->vendedor->email)->send(new VentaValidadaVendedor($venta));
        Mail::to($venta->comprador->email)->send(new VentaValidadaComprador($venta));

        return redirect()->back()->with('success', 'Venta validada y correos enviados.');
    }
}
