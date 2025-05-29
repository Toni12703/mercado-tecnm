<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;

class ClienteCompradorController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with('categorias');

        if ($request->filled('categoria')) {
            $query->whereHas('categorias', function ($q) use ($request) {
                $q->where('id', $request->categoria);
            });
        }

        return view('cliente_comprador', [
            'productos' => $query->get(),
            'categorias' => Categoria::all(),
        ]);
    }
}
