@extends('system.app')

@section(
    'title',
    $usuaria
        ? $usuaria->nombre . ' ' . $usuaria->ap_pat . ' ' . $usuaria->ap_mat . ' · Ficha'
        : 'Sin resultados'
)

@section('content')
    @if ($usuaria)
        @php
            $coloniaMostrar = $usuaria->colonia_otro ?: $usuaria->colonia;
            $alcaldiaMostrar = $usuaria->alcaldia_otro ?: $usuaria->alcaldia;
        @endphp
        <div class="breadcrumb">
            <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}" class="return-index">
                Personas usuarias
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
    {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat }}
  </span>
        </div>
        <div class="content-header">
            <div>
                <h1>
                    {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat }}
                </h1>
                <p>
                    Ficha de persona usuaria
                </p>
            </div>
            <div class="header-actions">
                <button class="btn-outline">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                    </svg>
                    Editar
                </button>
                <button class="btn-danger">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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

        <div class="info-card">
            <h3>Información general</h3>
            <div class="info-grid">
                <div class="info-field">
                    <label>Categoría</label>
                    <div class="value {{ $usuaria->categoria ? '' : 'empty' }}">
                        {{ $usuaria->categoria ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Edad</label>
                    <div class="value {{ $usuaria->edad ? '' : 'empty' }}">
                        {{ $usuaria->edad ? $usuaria->edad . ' años' : '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Género</label>
                    <div class="value {{ $usuaria->genero ? '' : 'empty' }}">
                        {{ $usuaria->genero ? ucfirst($usuaria->genero) : '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Estado civil</label>
                    <div class="value {{ $usuaria->estado_civil ? '' : 'empty' }}">
                        {{ $usuaria->estado_civil ? ucfirst(str_replace('_', ' ', $usuaria->estado_civil)) : '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Número de hijos</label>
                    <div class="value {{ $usuaria->num_hijos !== null ? '' : 'empty' }}">
                        {{ $usuaria->num_hijos ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Nivel escolar</label>
                    <div class="value {{ $usuaria->nv_escolar ? '' : 'empty' }}">
                        {{ $usuaria->nv_escolar ? ucfirst(str_replace('_', ' ', $usuaria->nv_escolar)) : '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Ocupación</label>
                    <div class="value {{ $usuaria->ocupacion ? '' : 'empty' }}">
                        {{ $usuaria->ocupacion ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="info-card" style="margin-top: 24px;">
            <h3>Domicilio y contacto</h3>
            <div class="info-grid">
                <div class="info-field">
                    <label>Dirección</label>
                    <div class="value {{ $usuaria->direccion ? '' : 'empty' }}">
                        {{ $usuaria->direccion ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Colonia</label>
                    <div class="value {{ $usuaria->colonia_mostrar ? '' : 'empty' }}">
                        {{ $usuaria->colonia_mostrar ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Alcaldía</label>
                    <div class="value {{ $usuaria->alcaldia_mostrar ? '' : 'empty' }}">
                        {{ $usuaria->alcaldia_mostrar ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Teléfono de casa</label>
                    <div class="value {{ $usuaria->telefono_casa ? '' : 'empty' }}">
                        {{ $usuaria->telefono_casa ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Teléfono celular</label>
                    <div class="value {{ $usuaria->telefono_celular ? '' : 'empty' }}">
                        {{ $usuaria->telefono_celular ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Correo</label>
                    <div class="value {{ $usuaria->correo ? '' : 'empty' }}">
                        {{ $usuaria->correo ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="info-card" style="margin-top: 24px;">
            <h3>Vivienda y economía</h3>
            <div class="info-grid">
                <div class="info-field">
                    <label>Ingreso mensual</label>
                    <div class="value {{ $usuaria->ingreso_mensual ? '' : 'empty' }}">
                        {{ $usuaria->ingreso_mensual ? str_replace('_', ' - ', $usuaria->ingreso_mensual) : '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Tipo de hogar</label>
                    <div class="value {{ $usuaria->tipo_hogar ? '' : 'empty' }}">
                        {{ $usuaria->tipo_hogar ? ucfirst($usuaria->tipo_hogar) : '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Tipo de vivienda</label>
                    <div class="value {{ $usuaria->tipo_vivienda ? '' : 'empty' }}">
                        {{ $usuaria->tipo_vivienda ? ucfirst($usuaria->tipo_vivienda) : '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Habitantes menores de 18</label>
                    <div class="value {{ $usuaria->habitantes_menos_18 !== null ? '' : 'empty' }}">
                        {{ $usuaria->habitantes_menos_18 ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Habitantes mayores de 18</label>
                    <div class="value {{ $usuaria->habitantes_mas_18 !== null ? '' : 'empty' }}">
                        {{ $usuaria->habitantes_mas_18 ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>Habitantes mayores de 60</label>
                    <div class="value {{ $usuaria->habitantes_mas_60 !== null ? '' : 'empty' }}">
                        {{ $usuaria->habitantes_mas_60 ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="info-card" style="margin-top: 24px;">
            <h3>Redes de apoyo y servicios</h3>
            <div class="info-grid">
                <div class="info-field full-width">
                    <label>¿Cómo se enteró del centro? (Difusión)</label>
                    @if($usuaria->difuciones->isNotEmpty())
                        <div class="tag-chip-list">
                            @foreach($usuaria->difuciones as $difucion)
                                <span class="attendee-chip">{{ $difucion->nombre }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="value empty">-</div>
                    @endif
                </div>

                <div class="info-field full-width">
                    <label>Parentesco de quien provee el sustento económico</label>
                    @if($usuaria->sustentos->isNotEmpty())
                        <div class="tag-chip-list">
                            @foreach($usuaria->sustentos as $sustento)
                                <span class="attendee-chip">{{ $sustento->nombre }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="value empty">-</div>
                    @endif
                </div>

                <div class="info-field full-width">
                    <label>En caso de no trabajar, ¿cómo obtiene sus ingresos?</label>
                    @if($usuaria->noTrabajos->isNotEmpty())
                        <div class="tag-chip-list">
                            @foreach($usuaria->noTrabajos as $no_trabaja)
                                <span class="attendee-chip">{{ $no_trabaja->nombre }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="value empty">-</div>
                    @endif
                </div>

                <div class="info-field full-width">
                    <label>Servicio médico al que recurre</label>
                    @if($usuaria->serviciosMedicos->isNotEmpty())
                        <div class="tag-chip-list">
                            @foreach($usuaria->serviciosMedicos as $servicio_medico)
                                <span class="attendee-chip">{{ $servicio_medico->nombre }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="value empty">-</div>
                    @endif
                </div>

                <div class="info-field full-width">
                    <label>¿Cuántas personas dependen de usted?</label>
                    @if($usuaria->personasDependen->isNotEmpty())
                        <div class="tag-chip-list">
                            @foreach($usuaria->personasDependen as $persona_dependen)
                                <span class="attendee-chip">{{ $persona_dependen->nombre }}</span>
                            @endforeach
                        </div>
                    @else
                        <div class="value empty">-</div>
                    @endif
                </div>
            </div>
        </div>

        @if($usuaria->saberes)
            <div class="doc-card" style="margin-top: 32px;">
                <div class="doc-section">
                    <h3>Directorio de saberes</h3>
                    <p>{{ $usuaria->saberes }}</p>
                </div>
            </div>
        @endif

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
            <a type="button" class="btn-outline" href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/>
                </svg>
                Regresar
            </a>
        </div>
    @endif

@endsection
