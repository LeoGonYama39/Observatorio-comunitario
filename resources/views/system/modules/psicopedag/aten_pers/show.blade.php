@extends('system.app')

@section('title', $expediente ? 'Expediente · ' . $expediente->comunidad->nombre . ' ' . $expediente->comunidad->ap_pat : 'Sin resultados')

@section('content')
    @if ($expediente)
        <div class="breadcrumb">
            <a href="{{ route('aten_pers.index') }}" data-url="{{ route('aten_pers.index') }}" class="return-index">
                Atención individual
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                {{ $expediente->comunidad->nombre }} {{ $expediente->comunidad->ap_pat }} {{ $expediente->comunidad->ap_mat ?? '' }}
            </span>
        </div>

        @include('system.parts.alerts.alerts')

        <div class="content-header">
            <div>
                <h1>
                    {{ $expediente->comunidad->nombre }} {{ $expediente->comunidad->ap_pat }} {{ $expediente->comunidad->ap_mat ?? '' }}
                </h1>
                <p>Expediente clínico de atención psicopedagógica</p>
            </div>
            <div class="header-actions">
                <a class="btn-new" href="{{ route('aten_pers.caso.create', $expediente->id) }}" data-url="{{ route('aten_pers.caso.create', $expediente->id) }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Nuevo caso
                </a>
                <button type="button" class="btn-danger" onclick="document.getElementById('modalEliminarExpediente').showModal()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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

        <div class="info-card" style="margin-bottom: 32px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <h3 style="margin: 0;">Contacto de emergencia y Tutores</h3>
                <a class="btn-outline btn-small">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                    </svg>
                    Editar
                </a>
            </div>

            <div class="info-grid">
                <div class="info-field">
                    <label>Teléfono de emergencia</label>
                    <div class="value {{ $expediente->contacto_emergencia ? '' : 'empty' }}">
                        {{ $expediente->contacto_emergencia ?? 'Sin registrar' }}
                    </div>
                </div>

                <div class="info-field">
                    <label>Tutor(es) registrados</label>
                    @if ($expediente->tutores->isNotEmpty())
                        <div class="related-list">
                            @foreach ($expediente->tutores as $tutor)
                                <div class="related-row" style="padding: 6px 0;">
                                    <span class="name">
                                        {{ $tutor->nombre }} {{ $tutor->ap_pat }} {{ $tutor->ap_mat ?? '' }}
                                    </span>
                                    <span class="role-badge participante">
                                        {{ ucfirst($tutor->parentesco_normalizado ?? $tutor->pivot->parentesco ?? 'Tutor') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="value empty">Sin tutores vinculados</div>
                    @endif
                </div>
            </div>
        </div>

        @if ($expediente->casos->isNotEmpty())

            {{-- Selector de casos (sólo visible si hay casos) --}}
            <div class="case-switcher">
                <button type="button" class="case-nav-btn" id="casePrevBtn" onclick="changeCase(-1)" aria-label="Caso anterior" disabled>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6" />
                    </svg>
                </button>
                <div class="case-switcher-label">
                    <span class="case-switcher-title">
                        Caso <span id="caseCurrentNum">1</span> de <span id="caseTotalNum">{{ $expediente->casos->count() }}</span>
                    </span>
                    <span class="case-switcher-sub" id="caseSubLabel"></span>
                </div>
                <button type="button" class="case-nav-btn" id="caseNextBtn" onclick="changeCase(1)" aria-label="Caso siguiente" {{ $expediente->casos->count() <= 1 ? 'disabled' : '' }}>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                </button>
            </div>

            @foreach ($expediente->casos as $caso)
                <div class="case-block" 
                     data-case="{{ $loop->iteration }}"
                     data-sub-label="{{ ucfirst(str_replace('_', ' ', $caso->tipo)) }} · {{ ucfirst(str_replace('_', ' ', $caso->estado)) }}"
                     {{ $loop->iteration != 1 ? 'hidden' : '' }}>

                    <div class="content-header" style="margin-bottom: 16px;">
                        <div>
                            <h2 style="font-size: 18px; font-weight: 800; color: var(--ink);">
                                Caso #{{ $loop->iteration }}: {{ ucfirst(str_replace('_', ' ', $caso->tipo)) }}
                            </h2>
                            <p>Abierto el {{ $caso->fecha_formateada ?? $caso->init?->format('d/m/Y') }} · Temporada {{ ucfirst($caso->temporada) }}</p>
                        </div>
                        <div class="header-actions">
                            <a class="btn-outline">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                                </svg>
                                Editar caso
                            </a>
                            <button type="button" class="btn-danger-subtle" onclick="document.getElementById('modalEliminarCaso_{{ $caso->id }}').showModal()">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="9" y1="15" x2="15" y2="15"/>
                                </svg>
                                Borrar caso
                            </button>
                        </div>
                    </div>

                    <div class="info-card" style="margin-bottom: 24px;">
                        <h3>Información del caso</h3>
                        <div class="info-grid">
                            <div class="info-field">
                                <label>Fecha de apertura</label>
                                <div class="value">{{ $caso->fecha_formateada ?? $caso->init?->format('d/m/Y') }}</div>
                            </div>

                            <div class="info-field">
                                <label>Estado del caso</label>
                                <div>
                                    <span class="meta-badge {{ $caso->estado == 'activo' ? 'on' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $caso->estado)) }}
                                    </span>
                                </div>
                            </div>

                            <div class="info-field">
                                <label>Tipo de intervención</label>
                                <div class="value">{{ ucfirst(str_replace('_', ' ', $caso->tipo)) }}</div>
                            </div>

                            <div class="info-field">
                                <label>Canalización externa</label>
                                <div class="value {{ $caso->canalizado ? '' : 'empty' }}">
                                    {{ $caso->canalizado ? ($caso->canalizado_site ?: 'Sí (sin especificar sitio)') : 'No canalizado' }}
                                </div>
                            </div>

                            <div class="info-field full-width">
                                <label>Motivos de consulta / Problemáticas</label>
                                <div class="tag-chip-list" style="margin-top: 4px;">
                                    @forelse ($caso->motivos as $motivo)
                                        <span class="tag">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"/>
                                                <path d="m10 15 5-3-5-3v6Z"/>
                                            </svg>
                                            {{ $motivo->nombre }}
                                        </span>
                                    @empty
                                        <span class="value empty">Sin motivos registrados</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="doc-card" style="margin-bottom: 32px;">
                        <div class="doc-section">
                            <h3>Petición de la persona</h3>
                            <p class="{{ $caso->peticion ? 'text-multiline' : 'empty' }}">{{ trim($caso->peticion ?? 'Sin petición documentada.') }}</p>
                        </div>
                    </div>

                    <div class="section-header">
                        <h3>Historial y sesiones de seguimiento</h3>
                        <a class="btn-outline btn-small">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 5v14" />
                                <path d="M5 12h14" />
                            </svg>
                            Nueva sesión
                        </a>
                    </div>

                    <div class="timeline-card">
                        <div class="timeline">
                            @forelse ($caso->seguimientos as $seguimiento)
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-date">
                                        {{ $seguimiento->fecha_formateada ?? \Carbon\Carbon::parse($seguimiento->fecha)->format('d/m/Y') }}
                                    </div>
                                    <p class="timeline-text text-multiline">{{ trim($seguimiento->nota) }}</p>

                                    <div class="attendees">
                                        <span class="mini-label">Atendido por:</span>
                                        @forelse ($seguimiento->atendieron as $persona)
                                            <span class="attendee-chip">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                                    <circle cx="9" cy="7" r="4" />
                                                </svg>
                                                {{ $persona['nombre'] }} {{ $persona['ap_pat'] }}
                                            </span>
                                        @empty
                                            <span class="attendee-chip" style="opacity: 0.6;">Sin registro de personal</span>
                                        @endforelse
                                    </div>

                                    {{-- Botón para eliminar sesión individual usando tu estilo del timeline --}}
                                    <button type="button" 
                                            class="timeline-delete-btn" 
                                            title="Eliminar esta nota"
                                            onclick="document.getElementById('modalEliminarSeguimiento_{{ $seguimiento->id }}').showModal()">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>

                            @empty
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-date">—</div>
                                    <p class="timeline-text empty">No hay notas de seguimiento registradas en este caso.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            @endforeach

        @else
            <div class="empty-state" style="margin-top: 24px;">
                <div class="empty-state-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="12" y1="18" x2="12" y2="12" />
                        <line x1="9" y1="15" x2="15" y2="15" />
                    </svg>
                </div>
                <h2>Sin casos registrados</h2>
                <p>Este expediente no tiene procesos o intervenciones abiertas en este momento.</p>
                <a class="btn-new" href="{{ route('aten_pers.caso.create', $expediente->id) }}" data-url="{{ route('aten_pers.caso.create', $expediente->id) }}">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>
                    Abrir primer caso
                </a>
            </div>
        @endif

        {{-- Modal confirmación de borrado de TODO el expediente --}}
        @include('system.parts.alerts.confirm_delete', [
            'modalId' => 'modalEliminarExpediente',
            'titulo' => '¿Eliminar expediente completo?',
            'mensaje' => 'Esta acción destruirá todo el expediente, historial, tutores y casos asociados a :nombre.',
            'nombre' => $expediente->comunidad->nombre . ' ' . $expediente->comunidad->ap_pat,
            'ruta' => route('aten_pers.destroy', $expediente->id),
        ])
    @else
        @include('system.parts.alerts.not_found', ['route' => route('aten_pers.index')])
    @endif
@endsection