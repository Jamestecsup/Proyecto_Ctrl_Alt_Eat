@extends('layouts.sitio')
@section('title', $configuracion['titulo'].' | Administración')
@section('content')
<div class="wrap">
    <a class="muted" href="{{ route('administracion.inicio') }}">← Administración</a>
    <div class="section-head">
        <div><div class="eyebrow">Mantenimiento</div><h1>{{ $configuracion['titulo'] }}</h1></div>
        <a class="btn" href="{{ route('administracion.'.$recurso.'.crear') }}">+ Nuevo registro</a>
    </div>
    <div class="panel">
        <table class="table">
            <thead><tr>@foreach($configuracion['campos'] as $etiqueta)<th>{{ $etiqueta }}</th>@endforeach<th>Acciones</th></tr></thead>
            <tbody>
                @forelse($registros as $registro)
                    <tr>
                        @foreach(array_keys($configuracion['campos']) as $campo)
                            <td>
                                @if($campo === 'category_id'){{ $registro->categoria->name }}
                                @elseif($campo === 'establishment_id'){{ $registro->establecimiento->name }}
                                @elseif($campo === 'active')<span class="pill">{{ $registro->active ? 'Activo' : 'Inactivo' }}</span>
                                @elseif($campo === 'description'){{ \Illuminate\Support\Str::limit($registro->$campo, 55) ?: '—' }}
                                @elseif($campo === 'pickup_until'){{ $registro->$campo->format('d/m/Y H:i') }}
                                @elseif(str_ends_with($campo, 'price'))S/ {{ number_format($registro->$campo, 2) }}
                                @else{{ $registro->$campo ?? '—' }}@endif
                            </td>
                        @endforeach
                        <td>
                            <div class="actions">
                                <a class="btn secondary small" href="{{ route('administracion.'.$recurso.'.editar', $registro->id) }}">Editar</a>
                                <form method="POST" action="{{ route('administracion.'.$recurso.'.desactivar', $registro->id) }}" onsubmit="return confirm('¿Desactivar este registro?')">
                                    @csrf @method('DELETE')
                                    <button class="btn small" type="submit">Desactivar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ count($configuracion['campos']) + 1 }}" class="muted">Todavía no hay registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $registros->links() }}
</div>
@endsection
