<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index(Request $request)
    {
        $libros = Libro::orderBy('titulo')->get();

        $libroEditar = $request->filled('editar')
            ? Libro::findOrFail($request->query('editar'))
            : null;

        return view('libros', compact('libros', 'libroEditar'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'genero' => 'nullable|string|max:100',
            'anio' => 'nullable|integer|min:1000|max:2100',
            'descripcion' => 'nullable|string|max:2000',
        ]);

        Libro::create($datos);

        return redirect()->route('libros.index')
            ->with('mensaje', 'Libro agregado correctamente.');
    }

    public function update(Request $request, Libro $libro)
    {
        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'genero' => 'nullable|string|max:100',
            'anio' => 'nullable|integer|min:1000|max:2100',
            'descripcion' => 'nullable|string|max:2000',
        ]);

        $libro->update($datos);

        return redirect()->route('libros.index')
            ->with('mensaje', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        $libro->delete();

        return redirect()->route('libros.index')
            ->with('mensaje', 'Libro eliminado correctamente.');
    }
}