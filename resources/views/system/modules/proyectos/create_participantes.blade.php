@extends('system.app')

@section('title', 'Vincular participantes al proyecto')

@section('content')
    @if($proyecto)
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
    Agregar participantes
  </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Agregar participantes a {{ $proyecto->nombre }}</h1>
            <p>Selecciona a las personas o instituciones involucradas y asígnales un rol</p>
        </div>
    </div>

    <form method="POST" action="#">
        @csrf

        <div class="area-block">
            <h3 class="form-section-title">Personas del Centro</h3>

            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th style="width: 32px;"></th>
                        <th>Nombre</th>
                        <th>Cargo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$centros)
                        <p>No se encontraron personas del centro</p>
                    @else
                        @foreach($centros as $centro)
                            <tr class="selectable-row" data-tipo="centro" data-id="{{ $centro->id }}"
                                data-nombre="{{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}"
                                data-subtitle="{{ $centro->cargo ? ucfirst(str_replace('_', ' ', $centro->cargo)) : '' }}"
                                onclick="toggleEntitySelection(this)">
                                <td class="select-check-cell">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>
                                </td>
                                <td>{{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}</td>
                                <td>{{ $centro->cargo ? ucfirst(str_replace('_', ' ', $centro->cargo)) : '-' }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="selected-entity-list" id="selected-centro"></div>
        </div>

        {{-- ================= PERSONAS EXTERNAS ================= --}}
        <div class="area-block">
            <h3 class="form-section-title">Personas Externas</h3>

            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th style="width: 32px;"></th>
                        <th>Nombre</th>
                        <th>Universidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$externos)
                        <p>No se encontraron personas externas</p>
                    @else
                        @foreach($externos as $externo)
                            {{-- data-id es el id de la PARTICIPACIÓN más reciente de este externo, no el id de p_externo --}}
                            <tr class="selectable-row" data-tipo="externo" data-id="{{ $externo->participacion_reciente_id }}"
                                data-nombre="{{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}"
                                data-subtitle="{{ $externo->universidad ?? '' }}"
                                onclick="toggleEntitySelection(this)">
                                <td class="select-check-cell">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>
                                </td>
                                <td>{{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}</td>
                                <td>{{ $externo->universidad ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="selected-entity-list" id="selected-externo"></div>
        </div>

        {{-- ================= PERSONAS DE LA COMUNIDAD ================= --}}
        <div class="area-block">
            <h3 class="form-section-title">Personas de la Comunidad (líderes de comunidad)</h3>

            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th style="width: 32px;"></th>
                        <th>Nombre</th>
                        <th>Colonia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$usuarias)
                        <p>No se encontraron líderes comunitarios</p>
                    @else
                        @foreach($usuarias as $usuaria)
                            <tr class="selectable-row" data-tipo="comunidad" data-id="{{ $usuaria->id }}"
                                data-nombre="{{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat }}"
                                data-subtitle="{{ $usuaria->colonia ?? '' }}"
                                onclick="toggleEntitySelection(this)">
                                <td class="select-check-cell">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>
                                </td>
                                <td>{{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat }}</td>
                                <td>{{ $usuaria->colonia->nombre ?? '-' }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="selected-entity-list" id="selected-comunidad"></div>
        </div>

        {{-- ================= INSTITUCIONES ================= --}}
        <div class="area-block">
            <h3 class="form-section-title">Instituciones</h3>

            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th style="width: 32px;"></th>
                        <th>Nombre</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!$instituciones)
                        <p>No se encontraron instituciones</p>
                    @else
                        @foreach($instituciones as $institucion)
                            <tr class="selectable-row" data-tipo="institucion" data-id="{{ $institucion->id }}"
                                data-nombre="{{ $institucion->nombre }}"
                                data-subtitle=""
                                onclick="toggleEntitySelection(this)">
                                <td class="select-check-cell">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>
                                </td>
                                <td>{{ $institucion->nombre }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <div class="selected-entity-list" id="selected-institucion"></div>
        </div>

        <div class="form-actions">
            <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Guardar participantes</button>
        </div>
    </form>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m21 21-4.3-4.3"/>
                    <path d="M9 9l4 4"/>
                    <path d="M13 9l-4 4"/>
                </svg>
            </div>
            <h2>No se encontró ningún resultado</h2>
            <p>No hay información que coincida con lo que buscas.</p>
            <a type="button" class="btn-outline" href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/>
                </svg>
                Regresar
            </a>
        </div>
    @endif
@endsection
