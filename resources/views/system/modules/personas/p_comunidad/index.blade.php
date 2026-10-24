@extends('system.app')

@section('title', 'Personas usuarias')

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>Personas usuarias</h1>
            <p>Personas de la comunidad</p>
        </div>
        <a href="{{ route('personas-usuarias.create') }}" data-url="{{ route('personas-usuarias.create') }}" class="btn-new">
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
                    <h3>Filtrar personas usuarias</h3>
                    <button type="button" class="filter-clear-btn" onclick="clearClientFilters()">Borrar filtros</button>
                </div>

                <div class="filter-grid-layout">
                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Estado</label>
                            <div class="filter-checkbox-group">
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="filtro_activo" class="filter-cb" data-filter="activo" value="activo">
                                    <label for="filtro_activo">Registro activo</label>
                                </div>
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="filtro_inactivo" class="filter-cb" data-filter="activo" value="inactivo">
                                    <label for="filtro_inactivo">Registro inactivo</label>
                                </div>
                            </div>
                        </div>

                        <hr class="form-separator">

                        <div class="filter-section">
                            <label class="filter-section-title">Rango de edad</label>
                            <div class="range-slider">
                                <div class="range-values">
                                    <span id="edadLowLabel">0</span> — <span id="edadHighLabel">99</span> años
                                </div>
                                <div class="range-slider-track">
                                    <div class="range-slider-fill" id="edadRangeFill" style="left: 0%; width: 100%;"></div>
                                    <input type="range" id="edadRangeLow" min="0" max="99" value="0" oninput="updateFilterEdadRange()">
                                    <input type="range" id="edadRangeHigh" min="0" max="99" value="99" oninput="updateFilterEdadRange()">
                                </div>
                            </div>
                        </div>

                        <hr class="form-separator">

                        <div class="filter-section">
                            <label class="filter-section-title">Categoría</label>
                            <div class="filter-checkbox-group">
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="cat_usuario" class="filter-cb" data-filter="categ" value="usuario">
                                    <label for="cat_usuario">Usuarios/as</label>
                                </div>
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="cat_lider" class="filter-cb" data-filter="categ" value="lider">
                                    <label for="cat_lider">Líder comunitario</label>
                                </div>
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="cat_saberes" class="filter-cb" data-filter="categ" value="saberes">
                                    <label for="cat_saberes">Directorio de saberes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="filter-col">
                        <div class="filter-section">
                            <label class="filter-section-title">Colonia</label>
                            <div class="filter-checkbox-group filter-scrollable-list">
                                @foreach($colonias as $colonia)
                                    <div class="form-checkbox-row">
                                        <input type="checkbox" id="colonia_{{ $colonia->id }}" class="filter-cb" data-filter="colonia" value="{{ $colonia->nombre }}">
                                        <label for="colonia_{{ $colonia->id }}">{{ $colonia->nombre }}</label>
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
                    <th>Edad</th>
                    <th>Colonia</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarias as $usuaria)
                    <tr data-url="{{ route('personas-usuarias.show', $usuaria->id) }}" 
                        data-edad="{{ $usuaria->edad ?? '' }}"
                        data-colonia="{{ $usuaria->colonia_mostrar ?? '' }}" 
                        data-categ="{{ $usuaria->categ_categ ?? '' }}"
                        data-activo="{{ $usuaria->activo ? 'activo' : 'inactivo' }}">
                        <td>
                            <div class="person-name">
                                {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat ?? '' }}
                            </div>
                            <div class="person-role">
                                {{ $usuaria->activo ? 'Registro activo' : 'Registro inactivo' }}
                            </div>
                        </td>
                        <td>
                            <span class="area-tag {{ $usuaria->edad ? '' : 'empty' }}">
                                {{ $usuaria->edad ? $usuaria->edad . ' años' : '—' }}
                            </span>
                        </td>
                        <td>
                            <span class="area-tag {{ !$usuaria->colonia && !$usuaria->colonia_otro ? 'empty' : '' }}">
                                {{ $usuaria->colonia_mostrar }}
                            </span>
                        </td>
                        <td>
                            <span class="area-tag">
                                {{ $usuaria->categoria }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
