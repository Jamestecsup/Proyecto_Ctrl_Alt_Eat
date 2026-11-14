@extends('layouts.sitio')
@section('title', 'Mi cuenta | Ctrl + Alt + Eat')
@section('content')
<div class="wrap">
    <div class="eyebrow">Mi cuenta</div>
    <h1>Hola, {{ auth()->user()->name }}</h1>
    <p class="muted">Tu perfil: {{ ucfirst(auth()->user()->role) }}</p>
    @if(auth()->user()->role === 'cliente')
        <div class="section-head"><h2>Mis reservas</h2><a class="btn" href="{{ route('ofertas.listar') }}">Buscar ofertas</a></div>
        @forelse(auth()->user()->reservas()->with('oferta')->latest()->get() as $reserva)
            <div class="panel"><span class="pill">{{ ucfirst($reserva->status) }}</span><h3>{{ $reserva->oferta->name }}</h3><p>{{ $reserva->quantity }} porciones · S/ {{ number_format($reserva->total, 2) }}</p><a href="{{ route('reservas.ver', $reserva) }}">Ver comprobante →</a></div>
        @empty
            <div class="panel">Aún no tienes reservas. <a href="{{ route('ofertas.listar') }}">Explora las ofertas disponibles.</a></div>
        @endforelse
    @elseif(auth()->user()->role === 'establecimiento')
        <div class="panel"><h2>Espacio de establecimientos</h2><p>En esta entrega, la publicación de lotes se gestiona desde administración. El flujo del establecimiento para preparar pedidos se completa en la siguiente etapa del proyecto.</p><a href="{{ route('ofertas.listar') }}">Ver ofertas publicadas →</a></div>
    @endif
</div>
@endsection
