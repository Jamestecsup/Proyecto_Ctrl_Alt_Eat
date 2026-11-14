@extends('layouts.sitio')
@section('title', 'Administración | Ctrl + Alt + Eat')
@section('content')
<div class="wrap">
    <div class="eyebrow">Panel privado</div>
    <h1>Administración</h1>
    <p class="muted">Gestiona los catálogos que mantienen la plataforma en funcionamiento.</p>
    <div class="grid">
        @foreach(['categorias' => 'Categorías de alimentos', 'establecimientos' => 'Establecimientos', 'ofertas' => 'Lotes y ofertas', 'metodos-pago' => 'Métodos de pago'] as $recurso => $titulo)
            <a class="card" href="{{ route('administracion.'.$recurso.'.listar') }}">
                <span class="eyebrow">Mantenimiento</span>
                <h2>{{ $titulo }} →</h2>
                <p class="muted">Consultar, registrar, actualizar y desactivar.</p>
            </a>
        @endforeach
    </div>
</div>
@endsection
