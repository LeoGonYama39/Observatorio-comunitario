@extends('system.app')

@section('title', 'Ejes del centro')

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>
                Ejes
            </h1>
            <p>
                Ejes del centro comuntiario meneses
            </p>
        </div>
        <a href="{{ route('ejes.create') }}" data-url="{{ route('ejes.create') }}" class="btn-new">
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
                    <h3>Filtrar ejes</h3>
                    <button type="button" class="filter-clear-btn" onclick="clearClientFilters()">Borrar filtros</button>
                </div>

                <div class="filter-grid-layout">
                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Estado</label>
                            <div class="filter-checkbox-group">
                                @foreach ($responsabilidades as $responsabilidad)
                                    <div class="form-checkbox-row">
                                    <input type="checkbox" id="resp_{{ $responsabilidad->id }}" class="filter-cb" data-filter="resp" value="{{ $responsabilidad->id }}">
                                    <label for="resp_{{ $responsabilidad->id }}">{{ $responsabilidad->nombre }}</label>
                                </div>
                                @endforeach
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="resp_no" class="filter-cb" data-filter="resp" value="-">
                                    <label for="resp_no">Sin responsabilidades ligadas</label>
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
                        Responsabilidad
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ejes as $eje)
                    <tr data-url="{{ route('ejes.show', $eje->id) }}"
                        data-resp="{{ $eje->responsabilidades_ids }}">
                        <td>
                            <div class="person-name">
                                {{ $eje->nombre }}
                            </div>
                        </td>
                        <td>
                            <span class="area-tag {{ $eje->responsabilidades_formato ? '' : 'empty' }}">
                                {{ $eje->responsabilidades_formato ?? '-' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
