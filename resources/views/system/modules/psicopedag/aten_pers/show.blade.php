@extends('system.app')

@section('title', $expediente ? 'Expediente Atención individual ' . $expediente->comunidad->nombre . ' ' .
    $expediente->comunidad->ap_pat . ' ' . $expediente->comunidad->ap_mat : 'Sin resultados')

@section('content')
    @if ($expediente)
        <div class="breadcrumb">
            <a href="{{ route('aten_pers.index') }}" data-url="{{ route('aten_pers.index') }}" class="return-index">
                Atención individual
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                {{ $expediente->comunidad->nombre }} {{ $expediente->comunidad->ap_pat }}
                {{ $expediente->comunidad->ap_mat ?? '' }}
            </span>
        </div>
        <div class="content-header">
            <div>
                <h1>
                    {{ $expediente->comunidad->nombre }} {{ $expediente->comunidad->ap_pat }}
                    {{ $expediente->comunidad->ap_mat ?? '' }}
                </h1>
                <p>
                    Ficha
                </p>
            </div>
            <div class="header-actions">
                <button class="btn-outline" onclick="location.href='#'">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Nuevo caso
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
                    Borrar expediente
                </button>
            </div>
        </div>

        <div class="case-switcher">
            <button type="button" class="case-nav-btn" id="casePrevBtn" onclick="changeCase(-1)" aria-label="Caso anterior"
                disabled>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            </button>
            <div class="case-switcher-label">
                <span class="case-switcher-title">Caso <span id="caseCurrentNum">1</span> de <span
                        id="caseTotalNum">2</span></span>
                <span class="case-switcher-sub" id="caseSubLabel">Psicoeducativa · Activo</span>
            </div>
            <button type="button" class="case-nav-btn" id="caseNextBtn" onclick="changeCase(1)"
                aria-label="Caso siguiente">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 18l6-6-6-6" />
                </svg>
            </button>
        </div>

        @foreach ($expediente->casos as $caso)
            <div class="case-block" data-case="{{ $loop->iteration }}"
                data-sub-label="{{ ucfirst(str_replace('_', ' ', $caso->tipo)) }} · {{ ucfirst(str_replace('_', ' ', $caso->estado)) }}"
                {{ $loop->iteration != 1 ? 'hidden' : '' }}>
                <div class="content-header">
                    <div><h1></h1><p></p></div>
                    <div class="header-actions">
                        <button class="btn-outline">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                            </svg>
                            Editar
                        </button>
                        <button class="btn-danger-subtle">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18" />
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                <path d="M10 11v6" />
                                <path d="M14 11v6" />
                            </svg>
                            Borrar caso
                        </button>
                    </div>
                </div>
                <div class="info-card" style="margin-bottom: 32px;">
                    <h3>
                        Información general
                    </h3>
                    <div class="info-grid">
                        <div class="info-field">
                            <label>
                                Fecha de apertura
                            </label>
                            <div class="value">
                                {{ $caso->fecha_formateada }}
                            </div>
                        </div>
                        <div class="info-field">
                            <label>
                                Estado
                            </label>
                            <span class="meta-badge {{ $caso->estado == 'activo' ? 'on' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $caso->estado)) }}
                            </span>
                        </div>
                        <div class="info-field">
                            <label>
                                Tipo
                            </label>
                            <div class="value">
                                {{ ucfirst(str_replace('_', ' ', $caso->tipo)) }}
                            </div>
                        </div>
                        <div class="info-field">
                            <label>
                                Motivos
                            </label>
                            <div class="simple-tag-list">
                                @forelse ($caso->motivos as $motivo)
                                    <span class="tag">
                                        {{ $motivo->nombre }}
                                    </span>
                                @empty
                                    <span class="text">Sin motivos registrados</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="info-field">
                            <label>Canalizado</label>
                            <div class="value {{ $caso->canalizado ? '' : 'empty' }}">
                                {{ $caso->canalizado ? $caso->canalizado_site : 'No' }}</div>
                        </div>
                        <div class="info-field">
                            <label>Contacto de emergencia</label>
                            <div class="value {{ $expediente->contacto_emergencia ? '' : 'empty' }}">
                                {{ $expediente->contacto_emergencia ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="doc-card" style="margin-bottom: 32px;">
                    <div class="doc-section">
                        <h3>Petición de la persona</h3>
                        <p style="white-space: pre-line;" class="{{ $caso->peticion ? '' : 'empty' }}">{{ $caso->peticion }}</p>
                    </div>
                </div>

                <div class="section-header">
                    <h3>
                        Tutor(es)
                    </h3>
                    <button class="btn-outline btn-small">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Agregar tutor
                    </button>
                </div>
                @forelse ($expediente->tutores as $tutor)
                    <div class="table-card" style="margin-bottom: 32px;">
                        <div style="padding: 6px 24px;">
                            <div class="related-row">
                                <span class="name">
                                    {{ $tutor->nombre }} {{ $tutor->ap_pat }} {{ $tutor->ap_mat }}
                                </span>
                                <span class="role-badge participante">
                                    {{ ucfirst($tutor->parentesco_normalizado ) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    
                @endforelse

                <div class="section-header">
                    <h3>
                        Historial
                    </h3>
                    <button class="btn-outline btn-small">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                        Nuevo seguimiento
                    </button>
                </div>
                <div class="timeline-card">
                    <div class="timeline">
                      @forelse ($caso->seguimientos as $seguimiento)
                        <div class="timeline-item">
                            <div class="timeline-dot">
                            </div>
                            <div class="timeline-date">
                                {{ $seguimiento->fecha_formateada }}
                            </div>
                            <p class="timeline-text">{{ $seguimiento->nota }}</p>
                            <div class="attendees">
                                <span class="mini-label">
                                    Atendido por
                                </span>
                                @forelse ($seguimiento->atendieron as $persona)
                                  <span class="attendee-chip">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                    </svg>
                                    {{ $persona['nombre'] }} {{ $persona['ap_pat'] }} {{ $persona['ap_mat'] }}
                                </span>
                                @empty
                                <span class="attendee-chip">
                                    Sin registros
                                </span>
                                @endforelse
                            </div>
                        </div>
                        @empty
                        <div class="timeline-item">
                            <div class="timeline-dot">
                            </div>
                            <div class="timeline-date"></div>
                            <p class="timeline-text">Sin historial registrado.</p>
                        </div>
                      @endforelse
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @include('system.parts.alerts.not_found', ['route' => route('aten_pers.index')])
    @endif
@endsection
