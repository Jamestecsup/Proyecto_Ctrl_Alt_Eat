<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Establecimiento;
use App\Models\Oferta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OfertaController extends Controller
{
    public function listar(): View
    {
        $registros = Oferta::with(['categoria', 'establecimiento'])->latest()->paginate(12);
        $configuracion = ['titulo' => 'Lotes y ofertas', 'campos' => ['name' => 'Alimento', 'category_id' => 'Categoría', 'establishment_id' => 'Establecimiento', 'description' => 'Descripción', 'stock' => 'Stock', 'regular_price' => 'Precio regular', 'sale_price' => 'Precio rebajado', 'pickup_until' => 'Recojo hasta', 'active' => 'Activo']];

        return view('administracion.indice', ['recurso' => 'ofertas', 'configuracion' => $configuracion, 'registros' => $registros]);
    }

    public function mostrarFormularioNuevo(): View
    {
        $configuracion = ['titulo' => 'Lotes y ofertas', 'campos' => ['name' => 'Alimento', 'category_id' => 'Categoría', 'establishment_id' => 'Establecimiento', 'description' => 'Descripción', 'stock' => 'Stock', 'regular_price' => 'Precio regular', 'sale_price' => 'Precio rebajado', 'pickup_until' => 'Recojo hasta', 'active' => 'Activo']];
        $categorias = Categoria::where('active', true)->orderBy('name')->get();
        $establecimientos = Establecimiento::where('active', true)->orderBy('name')->get();

        return view('administracion.formulario', ['recurso' => 'ofertas', 'configuracion' => $configuracion, 'registro' => null, 'categorias' => $categorias, 'establecimientos' => $establecimientos]);
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categorias,id'],
            'establishment_id' => ['required', 'exists:establecimientos,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'stock' => ['required', 'integer', 'min:0'],
            'regular_price' => ['required', 'numeric', 'gt:0'],
            'sale_price' => ['required', 'numeric', 'gt:0', 'lt:regular_price'],
            'pickup_until' => ['required', 'date', 'after:now'],
            'active' => ['required', 'boolean'],
        ]);

        Oferta::create($datos);

        return redirect()->route('administracion.ofertas.listar')->with('success', 'Oferta registrada correctamente.');
    }

    public function mostrarFormularioEditar(Oferta $oferta): View
    {
        $configuracion = ['titulo' => 'Lotes y ofertas', 'campos' => ['name' => 'Alimento', 'category_id' => 'Categoría', 'establishment_id' => 'Establecimiento', 'description' => 'Descripción', 'stock' => 'Stock', 'regular_price' => 'Precio regular', 'sale_price' => 'Precio rebajado', 'pickup_until' => 'Recojo hasta', 'active' => 'Activo']];
        $categorias = Categoria::where('active', true)->orderBy('name')->get();
        $establecimientos = Establecimiento::where('active', true)->orderBy('name')->get();

        return view('administracion.formulario', ['recurso' => 'ofertas', 'configuracion' => $configuracion, 'registro' => $oferta, 'categorias' => $categorias, 'establecimientos' => $establecimientos]);
    }

    public function actualizar(Request $request, Oferta $oferta): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categorias,id'],
            'establishment_id' => ['required', 'exists:establecimientos,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'stock' => ['required', 'integer', 'min:0'],
            'regular_price' => ['required', 'numeric', 'gt:0'],
            'sale_price' => ['required', 'numeric', 'gt:0', 'lt:regular_price'],
            'pickup_until' => ['required', 'date', 'after:now'],
            'active' => ['required', 'boolean'],
        ]);

        $oferta->update($datos);

        return redirect()->route('administracion.ofertas.listar')->with('success', 'Oferta actualizada correctamente.');
    }

    public function desactivar(Oferta $oferta): RedirectResponse
    {
        $oferta->update(['active' => false]);

        return redirect()->route('administracion.ofertas.listar')->with('success', 'Oferta desactivada.');
    }
}
