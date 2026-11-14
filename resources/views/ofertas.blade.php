@extends('layouts.sitio')
@section('title', 'Ofertas | Ctrl + Alt + Eat')
@section('content')
<div class="wrap">
    <div class="eyebrow">Alimentos disponibles</div>
    <h1>Ofertas para rescatar</h1>
    <p class="muted">Elige productos disponibles y recógelos en el establecimiento.</p>
    <div class="grid">
        @forelse($ofertas as $oferta)
            <article class="card offer-card">
                @if($oferta->image)<img class="food-photo" src="{{ asset($oferta->image) }}" alt="{{ $oferta->name }}">@else<div class="food-icon">🥐</div>@endif
                <span class="pill">{{ $oferta->categoria->name }}</span>
                <h3>{{ $oferta->name }}</h3>
                <p class="muted">{{ $oferta->establecimiento->name }} · {{ $oferta->establecimiento->address }}</p>
                <p>{{ $oferta->description }}</p>
                <p>Recojo hasta {{ $oferta->pickup_until->format('d/m/Y H:i') }} · {{ $oferta->stock }} disponibles</p>
                <div><span class="price">S/ {{ number_format($oferta->sale_price, 2) }}</span><span class="old">S/ {{ number_format($oferta->regular_price, 2) }}</span></div>
                @auth
                    @if(auth()->user()->role === 'cliente')<p><a class="btn" href="{{ route('reservas.crear', ['oferta' => $oferta->id]) }}">Reservar</a></p>@else<p class="muted">Inicia como cliente para reservar.</p>@endif
                @else
                    <p><a class="btn" href="{{ route('login') }}">Ingresa para reservar</a></p>
                @endauth
            </article>
        @empty
            <div class="panel">No hay ofertas disponibles por el momento.</div>
        @endforelse
    </div>
</div>
@endsection
