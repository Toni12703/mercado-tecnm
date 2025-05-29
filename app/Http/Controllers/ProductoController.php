<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Imagen;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::where('id_user', auth()->id())->get(); // O Producto::all() si no filtras
        return view('paneles.vendedor', compact('productos'));
    
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
            'id_user' => auth()->id(),  
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
        $producto = Producto::with('categorias')->findOrFail($id);

        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación opcional
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'categorias' => 'array',
        ]);

        // Obtener el producto
        $producto = Producto::findOrFail($id);

        // Actualizar datos del producto
        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        // Actualizar categorías si existen
        if ($request->has('categorias')) {
            $producto->categorias()->sync($request->categorias);
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $producto = Producto::findOrFail($id); // Buscar el producto
    $producto->delete();                   // Eliminarlo

    return redirect()->route('productos.index')->with('success', 'Producto eliminado.');

    }

    public function mostrarPublicamente(Request $request)
{
    $productos = Producto::with('categorias');

    if ($request->filled('categoria')) {
        $productos->whereHas('categorias', function ($query) use ($request) {
            $query->where('categorias.id', $request->categoria); // 🟢 Aquí es clave
        });
    }

    return view('index', [
        'productos' => $productos->get(),
        'categorias' => Categoria::all(),
    ]);
}



}
