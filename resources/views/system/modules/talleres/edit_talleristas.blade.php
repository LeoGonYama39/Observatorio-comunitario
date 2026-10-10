@extends('system.app')

@section('title', 'Talleristas del periodo x')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('talleres.index') }}" data-url="{{ route('talleres.index') }}" class="return-index">
        Talleres
    </a>
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M9 6l6 6-6 6"/>
    </svg>
    <a href="{{ route('talleres.show', $grupo->taller->id) }}" data-url="{{ route('talleres.show', $grupo->taller->id) }}" class="return-index">
        {{ $grupo->taller->nombre }}
    </a>
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M9 6l6 6-6 6"/>
    </svg>
    <a href="{{ route('talleres.show', $grupo->taller->id) }}" data-url="{{ route('talleres.show', $grupo->taller->id) }}" class="return-index">
        {{ ucfirst($grupo->temporada) }} {{ $grupo->anio }}
    </a>
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
         stroke-linejoin="round">
        <path d="M9 6l6 6-6 6"/>
    </svg>
    <span class="current">
            Talleristas
    </span>
</div>

<div class="content-header">
    <div>
        <h1>Talleristas del grupo </h1>
        <p>
            Selecciona a los talleristas del grupo {{ ucfirst($grupo->temporada) }} {{ $grupo->anio }}
        </p>
    </div>
</div>

<form method="POST" action="{{ route('talleres.talleristas.update', $grupo->id) }}">
    @csrf
    @method('PUT')

    <div class="entity-picker-grid" style="grid-template-columns: repeat(3, minmax(0, 1fr))">
        @include('system.parts.forms.entity_picker', [
        'tipo' => 'centro',
        'label' => 'Personas del Centro',
        'options' => $personasCentro,
        //'selected' => $seleccionados['centro'],
        ])

        @include('system.parts.forms.entity_picker', [
        'tipo' => 'externo',
        'label' => 'Personas Externas',
        'options' => $personasExterno,
        //'selected' => $seleccionados['externo'],
        ])

        @include('system.parts.forms.entity_picker', [
        'tipo' => 'comunidad',
        'label' => 'Personas de la Comunidad',
        'options' => $personasComunidad,
        //'selected' => $seleccionados['comunidad'],
        ])
    </div>
    <div class="form-actions">
        <a href="{{ route('talleres.show', $grupo->taller->id) }}" data-url="{{ route('talleres.show', $grupo->taller->id) }}" class="btn-outline">
            Cancelar
        </a>
        <button type="submit" class="btn-new">
            Guardar talleristas
        </button>
    </div>
</form>
@endsection
