@extends('system.app')

@section('title', $inscripcion ? $comunidad->nombre . ' ' . $comunidad->ap_pat . ' ' . $comunidad->ap_mat . ' · Ficha
    educativa' : 'Sin resultados')

@section('content')
    @if ($inscripcion)
        <div class="breadcrumb">
            <a href="{{ route('educ_basica.index') }}" data-url="{{ route('educ_basica.index') }}" class="return-index">
                Educación básica
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                {{ $comunidad->nombre }} {{ $comunidad->ap_pat }} {{ $comunidad->ap_mat ?? '' }}
            </span>
        </div>
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
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                    </svg>
                    Editar
                </button>
                <button class="btn-danger">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
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
                        {{ $comunidad->colonia->nombre }}
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
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
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
                                <path d="M3 6h18" />
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
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
                            <div class="materia-box {{ $materia['acreditada'] ? 'done' : '' }}" onclick="toggleMateria(this)">
                                <div class="check-circle">
                                    @if($materia['acreditada'])
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 6 9 17l-5-5" />
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
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m21 21-4.3-4.3" />
                    <path d="M9 9l4 4" />
                    <path d="M13 9l-4 4" />
                </svg>
            </div>
            <h2>No se encontró ningún resultado</h2>
            <p>No hay información que coincida con lo que buscas.</p>
            <a type="button" class="btn-outline" href="{{ route('educ_basica.index') }}"
               data-url="{{ route('educ_basica.index') }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5" />
                    <path d="M11 18l-6-6 6-6" />
                </svg>
                Regresar
            </a>
        </div>
    @endif
@endsection
