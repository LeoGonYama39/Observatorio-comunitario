@extends('system.app')

@section('title', 'Involucrados del proyecto')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="return-index">
            Proyectos
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <a href="{{ route('proyectos.show', $proyecto->id) }}" data-url="{{ route('proyectos.show', $proyecto->id) }}" class="return-index">
            {{ $proyecto->nombre }}
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <span class="current">
    Involucrados
  </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Involucrados del proyecto</h1>
            <p>Selecciona a las personas o instituciones involucradas y asígnales un rol</p>
        </div>
    </div>

    @if (session('error'))
        <div class="form-card" style="border-color:#b3261e; margin-bottom: 16px;">
            <p style="color:#b3261e; margin:0;">{{ session('error') }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="form-card" style="border-color:#b3261e; margin-bottom: 16px;">
            <ul style="margin:0; padding-left: 18px; color:#b3261e;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('proyectos.participantes.update', $proyecto->id) }}">
        @csrf
        @method('PUT')

        <div class="entity-picker-grid" data-roles-proyecto="{{ json_encode($rolesOpciones) }}">
            @include('system.parts.entity_picker', [
                    'tipo' => 'centro',
                    'label' => 'Personas del Centro',
                    'options' => $personasCentro,
                    'selected' => $seleccionados['centro'],
                    'roles' => $rolesOpciones,
                ])

            @include('system.parts.entity_picker', [
                'tipo' => 'externo',
                'label' => 'Personas Externas',
                'options' => $personasExterno,
                'selected' => $seleccionados['externo'],
                'roles' => $rolesOpciones,
            ])

            @include('system.parts.entity_picker', [
                'tipo' => 'comunidad',
                'label' => 'Personas de la Comunidad',
                'options' => $personasComunidad,
                'selected' => $seleccionados['comunidad'],
                'roles' => $rolesOpciones,
            ])

            @include('system.parts.entity_picker', [
                'tipo' => 'institucion',
                'label' => 'Instituciones',
                'options' => $instituciones,
                'selected' => $seleccionados['institucion'],
                'roles' => $rolesOpciones,
            ])
        </div>

        <div class="form-actions">
            <a href="{{ route('proyectos.show', $proyecto->id) }}" data-url="{{ route('proyectos.show', $proyecto->id) }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Guardar participantes</button>
        </div>
    </form>
@endsection
