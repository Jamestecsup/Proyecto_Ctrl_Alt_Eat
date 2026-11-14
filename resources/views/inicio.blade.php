@extends('layouts.sitio')
@section('title', 'Ctrl + Alt + Eat | Alimentos rescatados')
@section('content')
<div class="wrap home-wrap">
    <section class="hero home-hero">
        <div>
            <div class="eyebrow">Aprovecha más. Desperdicia menos.</div>
            <h1>Rescata comida,<br>evita el desperdicio.</h1>
            <p>Encuentra alimentos deliciosos de negocios cercanos a precios especiales. Reserva en línea y recógelos en el establecimiento.</p>
            <a class="btn" href="{{ route('ofertas.listar') }}">Ver ofertas&nbsp; →</a>
        </div>
        <img class="hero-art hero-photo" src="{{ asset('images/actions/hero-food.jpg') }}" alt="Bowl de arroz, verduras y huevo">
    </section>

    <section class="action-section">
        <div class="section-head"><div><div class="eyebrow">Únete a la comunidad</div><h2>¿Qué quieres hacer hoy?</h2></div></div>
        <div class="grid action-grid">
            <article class="action-card">
                <img class="action-image" src="{{ asset('images/actions/rescue-food.jpg') }}" alt="Canasta con alimentos frescos">
                <div><h3>Quiero rescatar comida</h3><p class="muted">Explora ofertas, reserva tus favoritas y recógelas en el negocio.</p><a class="text-link" href="{{ route('ofertas.listar') }}">Buscar ofertas&nbsp; →</a></div>
            </article>
            <article class="action-card">
                <img class="action-image" src="{{ asset('images/actions/establishment.jpg') }}" alt="Fachada de una cafetería">
                <div><h3>Soy un establecimiento</h3><p class="muted">Conoce cómo Ctrl + Alt + Eat ayuda a reducir el desperdicio de alimentos.</p><a class="text-link" href="{{ route('contacto') }}">Conocer más&nbsp; →</a></div>
            </article>
        </div>
    </section>

    <section>
        <div class="section-head"><div><div class="eyebrow">Sorpresas de hoy</div><h2>Ofertas para rescatar</h2></div><a class="text-link" href="{{ route('ofertas.listar') }}">Ver todas →</a></div>
        <div class="grid">
            @forelse(\App\Models\Oferta::with(['categoria', 'establecimiento'])->where('active', true)->where('stock', '>', 0)->where('pickup_until', '>', now())->latest()->take(3)->get() as $oferta)
                <article class="card offer-card">
                    @if($oferta->image)<img class="food-photo" src="{{ asset($oferta->image) }}" alt="{{ $oferta->name }}">@else<div class="food-icon">🥐</div>@endif
                    <span class="pill">{{ $oferta->categoria->name }}</span>
                    <h3>{{ $oferta->name }}</h3>
                    <p class="muted">{{ $oferta->establecimiento->name }} · {{ $oferta->stock }} disponibles</p>
                    <div><span class="price">S/ {{ number_format($oferta->sale_price, 2) }}</span><span class="old">S/ {{ number_format($oferta->regular_price, 2) }}</span></div>
                    <p><a class="btn small" href="{{ route('reservas.crear', ['oferta' => $oferta->id]) }}">Reservar</a></p>
                </article>
            @empty
                <div class="panel">Pronto publicaremos nuevas ofertas. Vuelve a visitarnos.</div>
            @endforelse
        </div>
    </section>

    <section class="how-section">
        <div class="section-head"><div><div class="eyebrow">Simple y conveniente</div><h2>¿Cómo funciona?</h2></div><a class="text-link" href="{{ route('como-funciona') }}">Ver detalles →</a></div>
        <div class="grid">
            <article class="card how-card"><span class="step-number">01</span><h3>Explora</h3><p class="muted">Encuentra alimentos disponibles en negocios asociados.</p></article>
            <article class="card how-card"><span class="step-number">02</span><h3>Reserva y paga</h3><p class="muted">Separa los productos que quieras y registra tu pago.</p></article>
            <article class="card how-card"><span class="step-number">03</span><h3>Recoge y califica</h3><p class="muted">Muestra tu código de recojo y comparte tu experiencia.</p></article>
        </div>
    </section>
</div>
@endsection
