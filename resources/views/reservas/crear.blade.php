@extends('layouts.sitio')
@section('title', 'Reservar alimentos')
@section('content')
<div class="wrap">
    <div class="steps"><span class="active">1 · Reserva</span><span>2 · Pago</span><span>3 · Recogida</span></div>
    <h1>Reservar alimentos</h1>
    <div class="row">
        <article class="card">
            @if($oferta->image)<img class="food-photo" src="{{ asset($oferta->image) }}" alt="{{ $oferta->name }}">@else<div class="food-icon">🥗</div>@endif
            <span class="pill">{{ $oferta->categoria->name }}</span>
            <h2>{{ $oferta->name }}</h2>
            <p>{{ $oferta->establecimiento->name }} · {{ $oferta->establecimiento->address }}</p>
            <p>{{ $oferta->description }}</p>
            <p>Recojo hasta {{ $oferta->pickup_until->format('d/m/Y H:i') }}</p>
            <span class="price">S/ {{ number_format($oferta->sale_price, 2) }}</span>
            <span class="old">S/ {{ number_format($oferta->regular_price, 2) }}</span>
            <p>{{ $oferta->stock }} porciones disponibles</p>
        </article>
        <form class="panel" method="POST" action="{{ route('reservas.guardar') }}">
            @csrf
            <input type="hidden" name="oferta_id" value="{{ $oferta->id }}">
            <h2>Tu reserva</h2>
            <div class="field"><label for="cantidad">Cantidad de porciones</label><input id="cantidad" type="number" name="cantidad" min="1" max="{{ $oferta->stock }}" value="{{ old('cantidad', 1) }}" required></div>
            <div class="field"><label for="metodo_pago_id">Método de pago</label><select name="metodo_pago_id" id="metodo_pago_id" required><option value="">Elige una opción</option>@foreach($metodos as $metodo)<option value="{{ $metodo->id }}">{{ $metodo->name }}</option>@endforeach</select></div>
            <p class="muted">El stock se descuenta al reservar. El pedido se confirma cuando registras el pago.</p>
            <button class="btn">Continuar al pago →</button>
        </form>
    </div>
</div>
@endsection
