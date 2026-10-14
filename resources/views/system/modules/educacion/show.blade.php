{{--
Plantilla show común para educaciones.
$etiqueta: etiqueta para mostrar el tipo de educación, viene en minúsculas (ej. "educación básica")
$rutaIndex: ruta para ir al index de la educación (ej. route('educ_basica.index'))
$inscripcion: objeto de la inscripción educativa, debe tener:
    - id: id de la inscripción
    - rfe: RFE de la persona
    - curp: CURP de la persona
$comunidad: objeto de la persona de la comunidad, debe tener:
    - nombre: nombre de la persona
    - ap_pat: apellido paterno
    - ap_mat: apellido materno
    - edad: edad de la persona
    - genero: género de la persona
    - colonia: objeto de la colonia, debe tener:
        - nombre: nombre de la colonia
    - colonia_otro: nombre de la colonia si no está en el catálogo
    - telefono: teléfono de la persona
$cursos: lista de cursos de la persona, cada elemento debe tener:
    - nombre: nombre del curso
    - estado: estado del curso (ej. "activo", "inactivo")
    - fecha_ingreso: fecha de ingreso al curso
    - acreditadas: número de materias acreditadas
    - total: número total de materias del curso
    - materias: lista de materias del curso, cada elemento debe tener:
        - nombre: nombre de la materia
        - acreditada: booleano que indica si la materia está acreditada
--}}

@extends('system.app')

@section('title', $inscripcion ? $comunidad->nombre . ' ' . $comunidad->ap_pat . ' ' . $comunidad->ap_mat . ' · Ficha
    educativa' : 'Sin resultados')

@section('content')
    @if ($inscripcion)
        <div class="breadcrumb">
            <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="return-index">
                {{ ucfirst($etiqueta) }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <span class="current">
                {{ $comunidad->nombre }} {{ $comunidad->ap_pat }} {{ $comunidad->ap_mat ?? '' }}
            </span>
        </div>
        @include('system.parts.alerts.alerts')
        <div class="content-header">
            <div>
                <h1>
                    {{ $comunidad->nombre }} {{ $comunidad->ap_pat }} {{ $comunidad->ap_mat ?? '' }}
                </h1>
                <p>
                    Ficha académica
                </p>
            </div>
            <div class="header-actions">
                <button class="btn-outline">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                    </svg>
                    Editar
                </button>
                <button class="btn-danger">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/>
                        <path d="M14 11v6"/>
                    </svg>
                    Borrar
                </button>
            </div>
        </div>
        <div class="info-card" style="margin-bottom: 24px;">
            <h3>
                Información general
            </h3>
            <div class="info-grid">
                <div class="info-field">
                    <label>
                        RFE
                    </label>
                    <div class="value {{ $inscripcion->rfe ? '' : 'empty' }}">
                        {{ $inscripcion->rfe ?? '-' }}
                    </div>
                </div>
                @if ($comunidad->edad)
                    <div class="info-field">
                        <label>
                            Edad
                        </label>
                        <div class="value">
                            {{ $comunidad->edad }} años
                        </div>
                    </div>
                @endif
                <div class="info-field">
                    <label>
                        CURP
                    </label>
                    <div class="value {{ $inscripcion->curp ? '' : 'empty' }}">
                        {{ $inscripcion->curp ?? '-' }}
                    </div>
                </div>
                @if ($comunidad->genero)
                    <div class="info-field">
                        <label>
                            Genero
                        </label>
                        <div class="value">
                            {{ ucfirst($comunidad->genero) }}
                        </div>
                    </div>
                @endif
                <div class="info-field">
                    <label>
                        Colonia
                    </label>
                    <div class="value">
                        {{ $comunidad->colonia->nombre ?? $comunidad->colonia_otro }}
                    </div>
                </div>
                @if ($comunidad->telefono)
                    <div class="info-field">
                        <label>
                            Teléfono
                        </label>
                        <div class="value">
                            {{ $comunidad->telefono }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="section-header">
            <h3>
                Cursos
            </h3>
            <button class="btn-outline btn-small">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>
                Nueva inscripción
            </button>
        </div>

        @if ($cursos->isEmpty())
            <p>Sin cursos registrados</p>
        @else
            @foreach ($cursos as $curso)
                <div class="progress-card">
                    <div class="progress-top">
                        <h3>
                            {{ $curso['nombre'] }}
                        </h3>
                        <span class="meta-badge on">
                            {{ ucfirst($curso['estado']) }}
                        </span>
                        <button class="btn-danger btn-small">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"/>
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                <path d="M10 11v6"/>
                                <path d="M14 11v6"/>
                            </svg>
                            Eliminar
                        </button>
                    </div>
                    <p class="progress-meta">
                        Ingreso: {{ $curso['fecha_ingreso'] ?? 'No registrada' }}
                    </p>
                    <div class="progress-summary">
                        <span class="count">
                            {{ $curso['acreditadas'] }} de {{ $curso['total'] }} materias
                        </span>
                        <div class="progress-bar-track">
                            <div class="progress-bar-fill"
                                 style="width: {{ ((int) $curso['acreditadas'] / (int) $curso['total']) * 100 }}%;">
                            </div>
                        </div>
                    </div>
                    <div class="materias-grid">
                        @foreach($curso['materias'] as $materia)
                            <div class="materia-box {{ $materia['acreditada'] ? 'done' : '' }}"
                                 onclick="toggleMateria(this)">
                                <div class="check-circle">
                                    @if($materia['acreditada'])
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 6 9 17l-5-5"/>
                                        </svg>
                                    @endif
                                </div>
                                <span>
                                    {{ $materia['nombre'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    @else
        @include('system.parts.alerts.not_found', ['route' => $rutaIndex])
    @endif
@endsection
