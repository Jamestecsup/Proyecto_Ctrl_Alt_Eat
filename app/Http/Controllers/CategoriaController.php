<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function listar(): View
    {
        $registros = Categoria::latest()->paginate(12);
        $configuracion = ['titulo' => 'Categorías', 'campos' => ['name' => 'Nombre', 'description' => 'Descripción', 'active' => 'Activo']];

        return view('administracion.indice', ['recurso' => 'categorias', 'configuracion' => $configuracion, 'registros' => $registros]);
    }

    public function mostrarFormularioNuevo(): View
    {
        $configuracion = ['titulo' => 'Categorías', 'campos' => ['name' => 'Nombre', 'description' => 'Descripción', 'active' => 'Activo']];

        return view('administracion.formulario', ['recurso' => 'categorias', 'configuracion' => $configuracion, 'registro' => null, 'categorias' => [], 'establecimientos' => []]);
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:categorias,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'active' => ['required', 'boolean'],
        ]);

        Categoria::create($datos);

        return redirect()->route('administracion.categorias.listar')->with('success', 'Categoría registrada correctamente.');
    }

    public function mostrarFormularioEditar(Categoria $categoria): View
    {
        $configuracion = ['titulo' => 'Categorías', 'campos' => ['name' => 'Nombre', 'description' => 'Descripción', 'active' => 'Activo']];

        return view('administracion.formulario', ['recurso' => 'categorias', 'configuracion' => $configuracion, 'registro' => $categoria, 'categorias' => [], 'establecimientos' => []]);
    }

    public function actualizar(Request $request, Categoria $categoria): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categorias', 'name')->ignore($categoria->id)],
            'description' => ['nullable', 'string', 'max:1000'],
            'active' => ['required', 'boolean'],
        ]);

        $categoria->update($datos);

        return redirect()->route('administracion.categorias.listar')->with('success', 'Categoría actualizada correctamente.');
    }

    public function desactivar(Categoria $categoria): RedirectResponse
    {
        $categoria->update(['active' => false]);

        return redirect()->route('administracion.categorias.listar')->with('success', 'Categoría desactivada.');
    }
}
