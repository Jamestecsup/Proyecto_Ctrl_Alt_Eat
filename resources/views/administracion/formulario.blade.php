@extends('layouts.sitio')
@section('title', ($registro ? 'Editar' : 'Crear').' · '.$configuracion['titulo'])
@section('content')
<div class="wrap">
    <a class="muted" href="{{ route('administracion.'.$recurso.'.listar') }}">← {{ $configuracion['titulo'] }}</a>
    <h1>{{ $registro ? 'Editar registro' : 'Nuevo registro' }}</h1>
    <form class="panel" method="POST" action="{{ $registro ? route('administracion.'.$recurso.'.actualizar', $registro->id) : route('administracion.'.$recurso.'.guardar') }}">
        @csrf
        @if($registro) @method('PUT') @endif
        @foreach($configuracion['campos'] as $campo => $etiqueta)
            <div class="field">
                <label for="{{ $campo }}">{{ $etiqueta }}</label>
                @if($campo === 'active')
                    <select name="active" id="active"><option value="1" @selected((string)old('active', $registro?->active ?? 1) === '1')>Activo</option><option value="0" @selected((string)old('active', $registro?->active ?? 1) === '0')>Inactivo</option></select>
                @elseif($campo === 'category_id')
                    <select name="category_id" id="category_id" required><option value="">Selecciona una categoría</option>@foreach($categorias as $opcion)<option value="{{ $opcion->id }}" @selected(old('category_id', $registro?->category_id) == $opcion->id)>{{ $opcion->name }}</option>@endforeach</select>
                @elseif($campo === 'establishment_id')
                    <select name="establishment_id" id="establishment_id" required><option value="">Selecciona un establecimiento</option>@foreach($establecimientos as $opcion)<option value="{{ $opcion->id }}" @selected(old('establishment_id', $registro?->establishment_id) == $opcion->id)>{{ $opcion->name }}</option>@endforeach</select>
                @elseif(in_array($campo, ['description', 'address', 'details']))
                    <textarea name="{{ $campo }}" id="{{ $campo }}" rows="3">{{ old($campo, $registro?->$campo) }}</textarea>
                @else
                    <input id="{{ $campo }}" name="{{ $campo }}" type="{{ $campo === 'pickup_until' ? 'datetime-local' : (str_ends_with($campo, 'price') ? 'number' : ($campo === 'stock' ? 'number' : 'text')) }}" @if(str_ends_with($campo, 'price')) step="0.01" min="0.01" @elseif($campo === 'stock') min="0" @endif value="{{ old($campo, $campo === 'pickup_until' ? $registro?->pickup_until?->format('Y-m-d\TH:i') : $registro?->$campo) }}" required>
                @endif
            </div>
        @endforeach
        <button class="btn">{{ $registro ? 'Guardar cambios' : 'Registrar' }}</button>
        <a class="btn secondary" href="{{ route('administracion.'.$recurso.'.listar') }}">Cancelar</a>
    </form>
</div>
@endsection
