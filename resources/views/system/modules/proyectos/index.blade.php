@extends('system.app')

@section('title', 'Proyectos')

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>
                Proyectos
            </h1>
            <p>
                Proyectos comunitarios
            </p>
        </div>
        @if ($otros->tipo === 'centro')
            <a href="{{ route('proyectos.create') }}" data-url="{{ route('proyectos.create') }}" class="btn-new">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>
                Nuevo registro
            </a>
        @endif
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
                    <h3>Filtrar proyectos</h3>
                    <button type="button" class="filter-clear-btn" onclick="clearClientFilters()">Borrar filtros</button>
                </div>

                <div class="filter-grid-layout">
                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">
                                Prioritario
                                <svg class="star-icon" width="13" height="13" viewBox="0 0 24 24" fill="#111111"
                                     stroke="#111111" stroke-width="1.5" stroke-linejoin="round">
                                    <path d="M12 2.5l2.9 6.3 6.8.7-5.1 4.6 1.5 6.7L12 17.6l-6.1 3.2 1.5-6.7-5.1-4.6 6.8-.7Z"/>
                                </svg>
                            </label>
                            <div class="filter-checkbox-group">
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="prior_1" class="filter-cb" data-filter="prior" value="1">
                                    <label for="prior_1">Prioritario</label>
                                </div>
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="prior_0" class="filter-cb" data-filter="prior" value="0">
                                    <label for="prior_0">No prioritario</label>
                                </div>
                            </div>
                        </div>

                        <hr class="form-separator">

                        <div class="filter-section">
                            <label class="filter-section-title">Estado</label>
                            <div class="filter-checkbox-group">
                                @foreach ($estados as $estado)
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="estado_{{ $estado }}" class="filter-cb" data-filter="estado" value="{{ $estado }}">
                                    <label for="estado_{{ $estado }}">{{ ucfirst(str_replace('_', ' ', $estado)) }}</label>
                                </div>  
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Área</label>
                            <div class="filter-checkbox-group filter-scrollable-list">
                                @foreach($areas as $area)
                                    <div class="form-checkbox-row">
                                        <input type="checkbox" id="area_{{ $area->id }}" class="filter-cb" data-filter="areas" value="{{ $area->id }}">
                                        <label for="area_{{ $area->id }}">{{ $area->nombre }}</label>
                                    </div>
                                @endforeach
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="area_no" class="filter-cb" data-filter="areas" value="-">
                                    <label for="area_no">Sin áreas</label>
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
                <th>
                    Nombre
                </th>
                <th>
                    Áreas
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($proyectos as $proyecto)
                <tr data-url="{{ route('proyectos.show', $proyecto->id) }}"
                    data-prior="{{ $proyecto->prioritario ? 1 : 0}}"
                    data-estado="{{ $proyecto->estado }}"
                    data-areas="{{ $proyecto->areas->pluck('id')->join(',') ?: '-' }}">
                    <td>
                        <div class="person-name">
                            @if($proyecto->prioritario)
                                <svg class="star-icon" width="13" height="13" viewBox="0 0 24 24" fill="#111111"
                                     stroke="#111111" stroke-width="1.5" stroke-linejoin="round">
                                    <path d="M12 2.5l2.9 6.3 6.8.7-5.1 4.6 1.5 6.7L12 17.6l-6.1 3.2 1.5-6.7-5.1-4.6 6.8-.7Z"/>
                                </svg>
                            @endif
                            {{ ucfirst($proyecto->nombre) }}
                        </div>
                        <div class="person-role">
                            {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
                        </div>
                    </td>
                    <td>
            <span class="area-tag {{ $proyecto->areas->isEmpty() ? 'empty' : '' }}">
                {{ $proyecto->areas->pluck('nombre')->join(' · ') ?: '-' }}
            </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
