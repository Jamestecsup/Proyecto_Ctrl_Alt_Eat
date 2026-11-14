@extends('layouts.sitio')
@section('title', 'Comprobante de reserva')
@section('content')
<div class="wrap">
    <div class="steps"><span>1 · Reserva</span><span>2 · Pago</span><span class="active">3 · Recogida</span></div>
    <h1>Tu comprobante</h1>
    <div class="panel">
        <span class="pill">{{ ucfirst($reserva->status) }}</span>
        <h2>{{ $reserva->oferta->name }}</h2>
        <p>{{ $reserva->oferta->establecimiento->name }} · {{ $reserva->oferta->establecimiento->address }}</p>
        <p>{{ $reserva->quantity }} porciones · Total S/ {{ number_format($reserva->total, 2) }}</p>
        @if($reserva->pickup_code)
            <div class="panel" style="text-align:center">
                <div class="eyebrow">Código de recojo</div>
                <div style="font:800 32px Manrope;letter-spacing:.18em;margin:16px">{{ $reserva->pickup_code }}</div>
                <p class="muted">Presenta este código en el establecimiento.</p>
            </div>
        @endif
        @if($reserva->status === 'pagado')
            <form method="POST" action="{{ route('reservas.confirmar-recepcion', $reserva) }}">
                @csrf
                <div class="field"><label for="codigo_recojo">Ingresa el código presentado al recoger</label><input type="text" id="codigo_recojo" name="codigo_recojo" autocomplete="off" required></div>
                <div class="field"><label for="calificacion">Califica tu experiencia</label><select id="calificacion" name="calificacion" required><option value="">Selecciona</option>@foreach(range(5, 1) as $numero)<option value="{{ $numero }}">{{ $numero }} estrellas</option>@endforeach</select></div>
                <div class="field"><label for="resena">Reseña (opcional, máximo 300 caracteres)</label><textarea name="resena" id="resena" maxlength="300"></textarea></div>
                <button class="btn">Confirmar recepción y calificar</button>
            </form>
        @elseif($reserva->status === 'recibido')
            <p>Recepción confirmada. Gracias por ayudar a aprovechar los alimentos.</p>
        @endif
    </div>
</div>
@endsection
