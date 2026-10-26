@extends('system.app')

@section('title', 'Personas del centro')

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>
                Personas del Centro
            </h1>
            <p>
                Personal que trabaja directamente en el centro comunitario
            </p>
        </div>
        <a href="{{ route('personas-centro.create') }}" data-url="{{ route('personas-centro.create') }}" class="btn-new">
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
                    <h3>Filtrar personas del centro</h3>
                    <button type="button" class="filter-clear-btn" onclick="clearClientFilters()">Borrar filtros</button>
                </div>

                <div class="filter-grid-layout">
                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Cargo</label>
                            <div class="filter-checkbox-group">
                                @foreach ($cargos as $cargo)
                                    <div class="form-checkbox-row">
                                        <input type="checkbox" id="cargo_{{ $cargo }}" class="filter-cb" data-filter="cargo" value="{{ $cargo }}">
                                        <label for="cargo_{{ $cargo }}">{{ ucfirst(str_replace('_', ' ', $cargo)) }}</label>
                                    </div>
                                @endforeach
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="cargo_no" class="filter-cb" data-filter="cargo" value="-">
                                    <label for="cargo_no">Sin cargo especificado</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">A cargo de</label>
                            <div class="filter-checkbox-group">
                                {{-- Áreas --}}
                                @foreach ($areas as $area)
                                    <div class="form-checkbox-row">
                                        <input type="checkbox" id="area_{{ $area->id }}" class="filter-cb" data-filter="areas" value="a_{{ $area->id }}">
                                        <label for="area_{{ $area->id }}"><strong>{{ $area->nombre }}</strong></label>
                                    </div>
                                    @foreach ($area->responsabilidades as $resp)
                                        <div class="form-checkbox-row" style="padding-left: 14px;">
                                            <input type="checkbox" id="resp_{{ $resp->id }}" class="filter-cb" data-filter="areas" value="r_{{ $resp->id }}">
                                            <label for="resp_{{ $resp->id }}">{{ $resp->nombre }}</label>
                                        </div>
                                    @endforeach
                                @endforeach
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="area_ninguna" class="filter-cb" data-filter="areas" value="-">
                                    <label for="area_ninguna">Sin área ni responsabilidad</label>
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
                        A cargo de
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($centros as $centro)
                    <tr data-url="{{ route('personas-centro.show', $centro->id) }}"
                        data-cargo="{{ $centro->cargo ?? '-' }}"
                        data-areas="{{ $centro->areas_ids }}">
                        <td>
                            <div class="person-name">
                                {{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}
                            </div>
                            <div class="person-role">
                                {{ ucfirst(str_replace('_', ' ', $centro->cargo ?? 'Sin cargo especificado')) }}
                            </div>
                        </td>
                        <td>
                            <span class="area-tag {{ $centro->a_cargo_de ? '' : 'empty' }}">
                                {{ $centro->a_cargo_de ?? '-' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
