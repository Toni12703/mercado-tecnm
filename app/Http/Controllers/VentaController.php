<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;

class VentaController extends Controller
{
    public function index()
    {
        // Obtener las ventas donde los productos pertenecen al vendedor actual
        $ventas = Venta::whereHas('producto', function($query) {
            $query->where('id_user', auth()->id());
        })->with('producto', 'comprador')->get();

        return view('ventas.index', compact('ventas'));
    }
}
