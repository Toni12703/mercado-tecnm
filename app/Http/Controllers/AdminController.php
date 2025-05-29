<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Hash;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    public function createGerente()
    {
        return view('admin.usuarios.create-gerente');
    }

    public function storeGerente(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Usuario::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'gerente',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Gerente creado correctamente');
    }
    
    public function index()
    {
        // Total de usuarios
        $totalUsuarios = Usuario::count();

        // Total de vendedores (usuarios que tienen productos)
        $totalVendedores = Usuario::has('productos')->count();

        // Total de compradores (usuarios que tienen ventas)
        $totalCompradores = Usuario::has('ventasComoComprador')->count();

        // Productos por categoría (usamos withCount)
        $productosPorCategoria = Categoria::withCount('productos')->get();

        // Producto más vendido (por cantidad de ventas)
        $productoMasVendido = Producto::withCount('ventas')
            ->orderByDesc('ventas_count')
            ->first();

        // Comprador más frecuente por categoría
        $compradorFrecuentePorCategoria = Categoria::with(['productos.ventas.comprador'])->get()->map(function ($categoria) {
            $compradores = [];

            foreach ($categoria->productos as $producto) {
                foreach ($producto->ventas as $venta) {
                    $id = $venta->id_comprador;
                    $compradores[$id] = ($compradores[$id] ?? 0) + 1;
                }
            }

            arsort($compradores);
            $compradorId = array_key_first($compradores);
            $comprador = $compradorId ? Usuario::find($compradorId) : null;

            return [
                'categoria' => $categoria->nombre,
                'comprador' => $comprador?->name,
                'compras' => $compradores[$compradorId] ?? 0
            ];
        });

        return view('admin.dashboard', compact(
            'totalUsuarios',
            'totalVendedores',
            'totalCompradores',
            'productosPorCategoria',
            'productoMasVendido',
            'compradorFrecuentePorCategoria'
        ));
    }
}
