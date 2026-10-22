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
        <div class="filter-dropdown-container" style="position: relative;">
            <button class="btn-filter" type="button" id="filterDropdownBtn" onclick="toggleFilterDropdown()">
                <svg width="15" height="15" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.8"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16" />
                    <path d="M7 12h10" />
                    <path d="M10 18h4" />
                </svg>
                Filtro
                <svg width="13" height="13" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9l6 6 6-6" />
                </svg>
            </button>

            <!-- Menú desplegable flotante de filtros -->
            <div class="filter-popover" id="filterPopover" hidden>
                <form method="GET" action="{{ route('personas-usuarias.index') }}" id="filterForm">
                    
                    <div class="filter-popover-header">
                        <h3>Filtrar personas usuarias</h3>
                        <button type="button" class="filter-clear-btn" onclick="clearFilters()">Borrar filtros</button>
                    </div>

                    <!-- 1. ESTADO (Checkbox cuadrado) -->
                    <div class="filter-section">
                        <label class="filter-section-title">Estado</label>
                        <div class="filter-checkbox-group">
                            <div class="form-checkbox-row">
                                <input type="checkbox" id="filtro_activo_1" name="estado[]" value="activo" {{ in_array('activo', request('estado', [])) ? 'checked' : '' }}>
                                <label for="filtro_activo_1">Registro activo</label>
                            </div>
                            <div class="form-checkbox-row">
                                <input type="checkbox" id="filtro_activo_0" name="estado[]" value="inactivo" {{ in_array('inactivo', request('estado', [])) ? 'checked' : '' }}>
                                <label for="filtro_activo_0">Registro inactivo</label>
                            </div>
                        </div>
                    </div>

                    <hr class="form-separator">

                    <!-- 2. EDAD (Rango de 0 a 99 con el estilo del range-slider de proyectos) -->
                    <div class="filter-section">
                        <label class="filter-section-title">Rango de edad</label>
                        <div class="range-slider" style="padding-top: 15px;">
                            <div class="range-values">
                                <span id="edadLowLabel">{{ request('edad_min', 0) }}</span> años — <span id="edadHighLabel">{{ request('edad_max', 99) }}</span> años
                            </div>
                            <div class="range-slider-track">
                                <div class="range-slider-fill" id="edadRangeFill"></div>
                                <input type="range" id="edadRangeLow" min="0" max="99" value="{{ request('edad_min', 0) }}" oninput="updateEdadRange()">
                                <input type="range" id="edadRangeHigh" min="0" max="99" value="{{ request('edad_max', 99) }}" oninput="updateEdadRange()">
                            </div>
                            <!-- Inputs hidden reales que viajan en el GET -->
                            <input type="hidden" name="edad_min" id="edadObjLow" value="{{ request('edad_min', 0) }}">
                            <input type="hidden" name="edad_max" id="edadObjHigh" value="{{ request('edad_max', 99) }}">
                        </div>
                    </div>

                    <hr class="form-separator">

                    <!-- 3. COLONIA (Checkbox cuadrado múltiple) -->
                    <div class="filter-section">
                        <label class="filter-section-title">Colonia</label>
                        <div class="filter-checkbox-group">
                            @foreach(['La Mexicana', 'Cuevitas', 'Pueblo Nuevo'] as $colonia)
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="colonia_{{ Str::slug($colonia) }}" name="colonia[]" value="{{ $colonia }}" {{ in_array($colonia, request('colonia', [])) ? 'checked' : '' }}>
                                    <label for="colonia_{{ Str::slug($colonia) }}">{{ $colonia }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="form-separator">

                    <!-- 4. CATEGORÍA (Checkbox cuadrado múltiple) -->
                    <div class="filter-section">
                        <label class="filter-section-title">Categoría</label>
                        <div class="filter-checkbox-group">
                            @foreach(['usuario/a' => 'Usuario/a', 'Directorio de Saberes' => 'Directorio de Saberes', 'Líder comunitario' => 'Líder comunitario'] as $key => $labelCat)
                                <div class="form-checkbox-row">
                                    <input type="checkbox" id="cat_{{ Str::slug($key) }}" name="categoria[]" value="{{ $key }}" {{ in_array($key, request('categoria', [])) ? 'checked' : '' }}>
                                    <label for="cat_{{ Str::slug($key) }}">{{ $labelCat }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn-new" style="width: 100%; justify-content: center; margin-top: 20px;">Aplicar filtros</button>
                    </div>

                </form>
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
                    <tr data-url="{{ route('personas-usuarias.show', $usuaria->id) }}" data-edad="{{ $usuaria->edad }}"
                        data-colonia="{{ $usuaria->colonia }}" data-categ="{{ $usuaria->categ_categ }}">
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
