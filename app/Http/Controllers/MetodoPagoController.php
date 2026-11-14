<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MetodoPagoController extends Controller
{
    public function listar(): View
    {
        $registros = MetodoPago::latest()->paginate(12);
        $configuracion = ['titulo' => 'Métodos de pago', 'campos' => ['name' => 'Nombre', 'details' => 'Detalle', 'active' => 'Activo']];

        return view('administracion.indice', ['recurso' => 'metodos-pago', 'configuracion' => $configuracion, 'registros' => $registros]);
    }

    public function mostrarFormularioNuevo(): View
    {
        $configuracion = ['titulo' => 'Métodos de pago', 'campos' => ['name' => 'Nombre', 'details' => 'Detalle', 'active' => 'Activo']];

        return view('administracion.formulario', ['recurso' => 'metodos-pago', 'configuracion' => $configuracion, 'registro' => null, 'categorias' => [], 'establecimientos' => []]);
    }

    public function guardar(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:payment_methods,name'],
            'details' => ['nullable', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ]);

        MetodoPago::create($datos);

        return redirect()->route('administracion.metodos-pago.listar')->with('success', 'Método de pago registrado correctamente.');
    }

    public function mostrarFormularioEditar(MetodoPago $metodoPago): View
    {
        $configuracion = ['titulo' => 'Métodos de pago', 'campos' => ['name' => 'Nombre', 'details' => 'Detalle', 'active' => 'Activo']];

        return view('administracion.formulario', ['recurso' => 'metodos-pago', 'configuracion' => $configuracion, 'registro' => $metodoPago, 'categorias' => [], 'establecimientos' => []]);
    }

    public function actualizar(Request $request, MetodoPago $metodoPago): RedirectResponse
    {
        $datos = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('payment_methods', 'name')->ignore($metodoPago->id)],
            'details' => ['nullable', 'string', 'max:255'],
            'active' => ['required', 'boolean'],
        ]);

        $metodoPago->update($datos);

        return redirect()->route('administracion.metodos-pago.listar')->with('success', 'Método de pago actualizado correctamente.');
    }

    public function desactivar(MetodoPago $metodoPago): RedirectResponse
    {
        $metodoPago->update(['active' => false]);

        return redirect()->route('administracion.metodos-pago.listar')->with('success', 'Método de pago desactivado.');
    }
}
