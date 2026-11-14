<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use App\Models\Oferta;
use App\Models\Reserva;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReservaController extends Controller
{
    public function listarOfertas(): View
    {
        $ofertas = Oferta::with(['categoria', 'establecimiento'])
            ->where('active', true)
            ->where('stock', '>', 0)
            ->where('pickup_until', '>', now())
            ->latest()
            ->get();

        return view('ofertas', compact('ofertas'));
    }

    public function mostrarFormularioReserva(Request $request): View
    {
        abort_unless($request->user()->role === 'cliente', 403);

        $oferta = Oferta::with(['categoria', 'establecimiento'])->findOrFail($request->input('oferta'));
        abort_unless($oferta->active && $oferta->stock > 0 && $oferta->pickup_until->isFuture(), 404);

        $metodos = MetodoPago::where('active', true)->orderBy('name')->get();

        return view('reservas.crear', compact('oferta', 'metodos'));
    }

    public function guardarReserva(Request $request): RedirectResponse
    {
        abort_unless($request->user()->role === 'cliente', 403);

        $datos = $request->validate([
            'oferta_id' => ['required', 'exists:ofertas,id'],
            'cantidad' => ['required', 'integer', 'min:1'],
            'metodo_pago_id' => ['required', 'exists:metodos_pago,id'],
        ]);

        $oferta = Oferta::findOrFail($datos['oferta_id']);
        abort_unless($oferta->active && $oferta->pickup_until->isFuture(), 422, 'La oferta ya no está disponible.');
        abort_unless($datos['cantidad'] <= $oferta->stock, 422, 'Ya no hay stock suficiente para esa cantidad.');

        $oferta->decrement('stock', $datos['cantidad']);

        $reserva = Reserva::create([
            'user_id' => $request->user()->id,
            'offer_id' => $oferta->id,
            'payment_method_id' => $datos['metodo_pago_id'],
            'quantity' => $datos['cantidad'],
            'total' => $oferta->sale_price * $datos['cantidad'],
            'status' => 'reservado',
        ]);

        return redirect()->route('reservas.pago', $reserva)->with('success', 'Reserva registrada. Continúa para confirmar el pago.');
    }

    public function mostrarPago(Reserva $reserva): View
    {
        abort_unless($reserva->user_id === auth()->id(), 403);
        abort_unless($reserva->status === 'reservado', 404);

        $reserva->load(['oferta.establecimiento', 'metodoPago']);

        return view('reservas.pago', compact('reserva'));
    }

    public function confirmarPago(Reserva $reserva): RedirectResponse
    {
        abort_unless($reserva->user_id === auth()->id(), 403);
        abort_unless($reserva->status === 'reservado', 404);

        $reserva->update([
            'status' => 'pagado',
            'pickup_code' => Str::upper(Str::random(8)),
        ]);

        return redirect()->route('reservas.ver', $reserva)->with('success', 'Pago registrado. Presenta tu código al recoger el pedido.');
    }

    public function mostrarReserva(Reserva $reserva): View
    {
        abort_unless($reserva->user_id === auth()->id(), 403);

        $reserva->load(['oferta.establecimiento', 'metodoPago']);

        return view('reservas.ver', compact('reserva'));
    }

    public function confirmarRecepcion(Request $request, Reserva $reserva): RedirectResponse
    {
        abort_unless($reserva->user_id === auth()->id(), 403);

        $datos = $request->validate([
            'codigo_recojo' => ['required', 'string'],
            'calificacion' => ['required', 'integer', 'between:1,5'],
            'resena' => ['nullable', 'string', 'max:300'],
        ]);

        abort_unless($reserva->status === 'pagado' && $reserva->pickup_code === $datos['codigo_recojo'], 422, 'El código no es válido o el pedido ya fue recibido.');

        $reserva->update([
            'status' => 'recibido',
            'rating' => $datos['calificacion'],
            'review' => $datos['resena'] ?? null,
        ]);

        return redirect()->route('reservas.ver', $reserva)->with('success', 'Recepción confirmada. Gracias por calificar.');
    }
}
