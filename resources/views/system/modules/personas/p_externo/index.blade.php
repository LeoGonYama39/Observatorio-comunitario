@extends('system.app')

@section('title', 'Personas de externas')

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>Personas Externas</h1>
            <p>
                Servicio social, prácticas profesionales, voluntariado y proyectos de
                inversión
            </p>
        </div>
        <a href="{{ route('personas-externo.create') }}" data-url="{{ route('personas-externo.create') }}"
           class="btn-new">
            <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke-width="2.2"
                    stroke-linecap="round"
                    stroke-linejoin="round">
                <path d="M12 5v14"/>
                <path d="M5 12h14"/>
            </svg>
            Nuevo registro
        </a>
    </div>

    <div class="table-toolbar">
        <div class="table-search">
            <svg width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
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
                    <h3>Filtrar personas externas</h3>
                    <button type="button" class="filter-clear-btn" onclick="clearClientFilters()">Borrar filtros</button>
                </div>

                <div class="filter-grid-layout">
                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Última participación</label>
                            <div class="filter-checkbox-group">
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="filtro_activo" class="filter-cb" data-filter="activo" value="activo">
                                    <label for="filtro_activo">Servicio Social</label>
                                </div>
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="filtro_inactivo" class="filter-cb" data-filter="activo" value="inactivo">
                                    <label for="filtro_inactivo">Prácticas profecionales</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Universidad</label>
                            <div class="filter-checkbox-group filter-scrollable-list">

                                    <div class="form-checkbox-row">
                                        <input type="checkbox" id="colonia_{{ 1 }}" class="filter-cb" data-filter="colonia" value="{{ 1 }}">
                                        <label for="colonia_{{ 1 }}">{{ 1 }}</label>
                                    </div>

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
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </button>
                <button type="button" class="table-pagination-btn" aria-label="Página siguiente">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="table-card">
        <table>
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Universidad</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($externos as $externo)
                <tr data-url="{{ route('personas-externo.show', $externo->id) }}"
                    data-tipo="{{ $externo->ultima_participacion->tipo_categ ?? 'sin_participacion' }}">
                    <td>
                        <div class="person-name">
                            {{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}
                        </div>
                        <div class="person-role">{{ $externo->ultima_participacion->tipo_formateado ?? 'Sin participación'}}</div>
                    </td>
                    <td>
                    <span class="area-tag {{ $externo->universidad ? '' : 'empty' }}">
                        {{ $externo->universidad->nombre ?? '—' }}
                    </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
