@extends('system.app')

@section('title', 'Involucrados del ' . $nombreTipo)

@section('content')

    <div class="breadcrumb">
        <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="return-index">
            {{ $nombreTipo }}
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="return-index">
            {{ $entidad->nombre }}
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <span class="current">
            Involucrados
        </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Involucrados del {{ $nombreTipo }}</h1>
            <p>
                Selecciona a las personas o instituciones involucradas y asígnales un rol
            </p>
        </div>
    </div>

    <form method="POST" action="{{ $rutaUpdate }}">
        @csrf
        @method('PUT')

        <div class="entity-picker-grid" data-roles-proyecto="{{ json_encode($rolesOpciones) }}">

            @include('system.parts.forms.entity_picker', [
                'tipo' => 'centro',
                'label' => 'Personas del Centro',
                'options' => $personasCentro,
                'selected' => $seleccionados['centro'],
                'roles' => $rolesOpciones,
            ])

            @include('system.parts.forms.entity_picker', [
                'tipo' => 'externo',
                'label' => 'Personas Externas',
                'options' => $personasExterno,
                'selected' => $seleccionados['externo'],
                'roles' => $rolesOpciones,
            ])

            @include('system.parts.forms.entity_picker', [
                'tipo' => 'comunidad',
                'label' => 'Personas de la Comunidad',
                'options' => $personasComunidad,
                'selected' => $seleccionados['comunidad'],
                'roles' => $rolesOpciones,
            ])

            @include('system.parts.forms.entity_picker', [
                'tipo' => 'institucion',
                'label' => 'Instituciones',
                'options' => $instituciones,
                'selected' => $seleccionados['institucion'],
                'roles' => $rolesOpciones,
            ])
        </div>
        <div class="form-actions">
            <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="btn-outline">
                Cancelar
            </a>
            <button type="submit" class="btn-new">
                Guardar participantes
            </button>
        </div>
    </form>
@endsection
