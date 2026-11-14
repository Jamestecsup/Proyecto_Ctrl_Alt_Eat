@extends('layouts.sitio')

@section('title', 'Nosotros | Ctrl + Alt + Eat')

@section('content')
    <div class="wrap">
        <div class="eyebrow">Nuestra razón de ser</div>
        <h1>Una mejor salida para los alimentos del día.</h1>

        <div class="panel">
            <p>
                Ctrl + Alt + Eat conecta establecimientos que tienen alimentos aptos sin vender al cierre
                con personas que buscan opciones ricas a un precio menor. Ayudamos a convertir excedentes
                en nuevas comidas y en ingresos para los negocios.
            </p>
            <p>
                Creemos que aprovechar mejor los alimentos beneficia a los comercios, a las familias y a nuestra ciudad.
            </p>
        </div>

        <a class="btn" href="{{ route('ofertas.listar') }}">Ver ofertas</a>
    </div>
@endsection
