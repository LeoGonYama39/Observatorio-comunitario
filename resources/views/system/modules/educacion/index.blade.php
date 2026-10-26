{{--
Plantilla index común para educaciones.
$etiqueta: etiqueta para mostrar el tipo de educación, viene en minúsculas (ej. "educación básica")
$rutaCreate: ruta para crear un nuevo registro (ej. route('educ_basica.create'))
$inscripciones: lista de inscripciones educativas, cada elemento debe tener:
    - id: id de la inscripción
    - nombre: nombre de la persona
    - ap_pat: apellido paterno
    - ap_mat: apellido materno
    - curso: curso actual
    - avance: avance en el curso
    - estado: estado de la inscripción (ej. "activo", "inactivo")
    - url: ruta para ver los detalles de la inscripción (ej. route('educ_basica.show', $inscripcion['id']))
--}}

@extends('system.app')

@section('title', ucfirst($etiqueta))

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>
                {{ ucfirst($etiqueta) }}
            </h1>
            <p>
                Alumnos de cursos de {{ $etiqueta }}
            </p>
        </div>
        <a class="btn-new" data-url="{{ $rutaCreate }}" href="{{ $rutaCreate }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M12 5v14" />
                <path d="M5 12h14" />
            </svg>
            Nuevo registro
        </a>
    </div>
    <div class="table-toolbar">
        <div class="table-search">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input type="text" placeholder="Buscar por nombre…" />
        </div>
    <div class="filter-dropdown-container">
        <button class="btn-filter" type="button" id="filterDropdownBtn" onclick="toggleFilterDropdown(event)">
                <svg width="15" height="15" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16" />
                    <path d="M7 12h10" />
                    <path d="M10 18h4" />
                </svg>
                Filtro
                <span class="filter-badge-count" id="filterActiveCount" hidden>0</span>
                <svg width="13" height="13" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>
        <div class="filter-popover" id="filterPopover" hidden>
                <div class="filter-popover-header">
                    <h3>Filtrar para educación {{ $tipo }}</h3>
                    <button type="button" class="filter-clear-btn" onclick="clearClientFilters()">Borrar filtros</button>
                </div>

                <div class="filter-grid-layout">
                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Estado</label>
                            <div class="filter-checkbox-group">
                                @foreach ($estados as $estado)
                                    <div class="form-checkbox-row">
                                        <input type="checkbox" id="estado_{{ $estado }}" class="filter-cb" data-filter="estado" value="{{ $estado }}">
                                        <label for="estado_{{$estado}}">{{ ucfirst(str_replace('_', ' ', $estado)) }}</label>
                                    </div>
                                @endforeach
                                @switch($tipo)
                                    @case('básica')
                                        <div class="form-checkbox-row">
                                            <input type="checkbox" id="estado_en_basica" class="filter-cb" data-filter="estado" value="Registrado en educación media superior">
                                            <label for="estado_en_basica">Registrado en educación media superior</label>
                                        </div>
                                        @break

                                    @case('media_superior')
                                        <div class="form-checkbox-row">
                                            <input type="checkbox" id="estado_en_sup" class="filter-cb" data-filter="estado" value="Registrado en educación básica">
                                            <label for="estado_en_sup">Registrado en educación básica</label>
                                        </div>
                                        @break

                                    @default
                                        <div class="form-checkbox-row">
                                            <label><strong>Error: esto no debería verse. F5.</strong></label>
                                        </div>
                                @endswitch
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="estado_no" class="filter-cb" data-filter="estado" value="Sin curso registrado">
                                    <label for="estado_no">Sin curso registrado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Curso actual</label>
                            <div class="filter-checkbox-group filter-scrollable-list">
                                @foreach($cursos as $curso)
                                    <div class="form-checkbox-row">
                                        <input type="checkbox" id="curso_{{ $curso->id }}" class="filter-cb" data-filter="curso" value="{{ $curso->id }}">
                                        <label for="curso_{{ $curso->id }}">{{ $curso->nombre }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter-popover-footer">
                    <button type="button" class="btn-new filter-apply-btn" onclick="applyClientFilters()">
                        Aplicar filtros
                    </button>
                </div>
            </div>
    </div>
        <div class="table-pagination">
            <span class="table-pagination-info">
                1–20 de 25 personas
            </span>
            <div class="table-pagination-controls">
                <button type="button" class="table-pagination-btn" aria-label="Página anterior" disabled>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>
                <button type="button" class="table-pagination-btn" aria-label="Página siguiente">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Curso actual
                    </th>
                    <th>
                        Avance
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones as $inscripcion)
                    <tr data-url="{{ $inscripcion['url'] }}"
                        data-estado="{{ $inscripcion['estado'] }}"
                        data-curso="{{ $inscripcion['curso_id'] }}">
                        <td>
                            <div class="person-name">
                                {{ $inscripcion['nombre'] }}
                                {{ $inscripcion['ap_pat'] }}
                                {{ $inscripcion['ap_mat'] }}
                            </div>
                            <div class="person-role">
                                {{ ucfirst($inscripcion['estado']) }}
                            </div>
                        </td>
                        <td class="area-tag {{ $inscripcion['curso'] ? '' : 'empty' }}">
                            {{ $inscripcion['curso'] ?? '-' }}
                        </td>
                        <td class="area-tag {{ $inscripcion['avance'] ? '' : 'empty' }}">
                            {{ $inscripcion['avance'] ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
