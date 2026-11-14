<?php

namespace App\Http\Controllers;

use App\Models\Establecimiento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EstablecimientoController extends Controller
{
    public function listar(): View
    {
        $registros = Establecimiento::latest()->paginate(12);
        $configuracion = ['titulo' => 'Establecimientos', 'campos' => ['name' => 'Nombre comercial', 'tax_id' => 'RUC', 'address' => 'Dirección', 'phone' => 'Teléfono', 'active' => 'Activo']];

        return view('administracion.indice', ['recurso' => 'establecimientos', 'configuracion' => $configuracion, 'registros' => $registros]);
    }

    public function mostrarFormularioNuevo(): View
    {
        $configuracion = ['titulo' => 'Establecimientos', 'campos' => ['name' => 'Nombre comercial', 'tax_id' => 'RUC', 'address' => 'Dirección', 'phone' => 'Teléfono', 'active' => 'Activo']];

        return view('administracion.formulario', ['recurso' => 'establecimientos', 'configuracion' => $configuracion, 'registro' => null, 'categorias' => [], 'establecimientos' => []]);
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'tax_id' => ['required', 'digits:11', 'unique:establishments,tax_id'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'active' => ['required', 'boolean'],
        ]);

        Establecimiento::create($datos);

        return redirect()->route('administracion.establecimientos.listar')->with('success', 'Establecimiento registrado correctamente.');
    }

    public function mostrarFormularioEditar(Establecimiento $establecimiento): View
    {
        $configuracion = ['titulo' => 'Establecimientos', 'campos' => ['name' => 'Nombre comercial', 'tax_id' => 'RUC', 'address' => 'Dirección', 'phone' => 'Teléfono', 'active' => 'Activo']];

        return view('administracion.formulario', ['recurso' => 'establecimientos', 'configuracion' => $configuracion, 'registro' => $establecimiento, 'categorias' => [], 'establecimientos' => []]);
    }

    public function actualizar(Request $request, Establecimiento $establecimiento): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'tax_id' => ['required', 'digits:11', Rule::unique('establishments', 'tax_id')->ignore($establecimiento->id)],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'active' => ['required', 'boolean'],
        ]);

        $establecimiento->update($datos);

        return redirect()->route('administracion.establecimientos.listar')->with('success', 'Establecimiento actualizado correctamente.');
    }

    public function desactivar(Establecimiento $establecimiento): RedirectResponse
    {
        $establecimiento->update(['active' => false]);

        return redirect()->route('administracion.establecimientos.listar')->with('success', 'Establecimiento desactivado.');
    }
}
