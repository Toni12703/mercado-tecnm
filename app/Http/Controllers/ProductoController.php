<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::with('categorias', 'imagenes', 'vendedor')->get();
        return view('productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'vendedor_id' => auth()->id(),
        ]);

        $producto->categorias()->attach($request->categorias);

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('productos', 'public');
                $producto->imagenes()->create(['ruta' => $ruta]);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto->load('categorias', 'imagenes', 'vendedor');
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categorias = Categoria::all();
        $producto->load('categorias', 'imagenes');

        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
    ]);

        $producto->categorias()->sync($request->categorias);

        if ($request->hasFile('imagenes')) {
            // Puedes borrar imágenes anteriores si lo deseas
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('productos', 'public');
                $producto->imagenes()->create(['ruta' => $ruta]);
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
}
