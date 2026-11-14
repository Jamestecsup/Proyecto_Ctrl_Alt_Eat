@extends('layouts.sitio')
@section('title', 'Realizar pago')
@section('content')
<div class="wrap">
    <div class="steps"><span>1 · Reserva</span><span class="active">2 · Pago</span><span>3 · Recogida</span></div>
    <h1>Realizar pago</h1>
    <div class="panel">
        <h2>{{ $reserva->oferta->name }}</h2>
        <p>{{ $reserva->quantity }} porciones · {{ $reserva->oferta->establecimiento->name }}</p>
        <p>Método elegido: <strong>{{ $reserva->metodoPago->name }}</strong></p>
        <p class="price">Total: S/ {{ number_format($reserva->total, 2) }}</p>
        <form method="POST" action="{{ route('reservas.confirmar-pago', $reserva) }}">@csrf<button class="btn">Confirmar pago</button></form>
    </div>
</div>
@endsection
