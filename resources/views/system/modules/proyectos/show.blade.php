@extends('system.app')

@section('title', $proyecto
? $proyecto->nombre . ' · Ficha'
: 'Sin resultados')

@section('content')
@if($proyecto)
<div class="breadcrumb">
  <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="return-index">
    Proyectos
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    {{ $proyecto->nombre }}
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      <svg class="star-icon" width="18" height="18" viewBox="0 0 24 24" fill="#111111" stroke="#111111" stroke-width="1.5" stroke-linejoin="round">
        <path d="M12 2.5l2.9 6.3 6.8.7-5.1 4.6 1.5 6.7L12 17.6l-6.1 3.2 1.5-6.7-5.1-4.6 6.8-.7Z"/>
      </svg>
      {{ $proyecto->nombre }}
    </h1>
    <p>
      Ficha de proyecto
    </p>
  </div>
  <div class="header-actions">
    <button class="btn-outline">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 20h9"/>
        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
      </svg>
      Editar
    </button>
    <button class="btn-danger">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 6h18"/>
        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
        <path d="M10 11v6"/>
        <path d="M14 11v6"/>
      </svg>
      Borrar
    </button>
  </div>
</div>
<div class="doc-layout">
  <div class="doc-card">
    <div class="doc-section">
      <h3>
        Antecedentes
      </h3>
      <p class="{{ $proyecto->antecedentes ? '' : 'empty'}}">
        {{ $proyecto->antecedentes ?? '-'}}
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Objetivos
      </h3>
      <p class="{{ $proyecto->objetivos ? '' : 'empty'}}">
        {{ $proyecto->objetivos ?? '-'}}
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Alcance
      </h3>
      <p class="{{ $proyecto->alcance ? '' : 'empty'}}">
        {{ $proyecto->alcance ?? '-'}}
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Evaluación
      </h3>
      <p class="{{ $proyecto->evaluacion ? '' : 'empty'}}">
        {{ $proyecto->evaluacion ?? '-'}}
      </p>
    </div>
  </div>
  <div class="meta-card">
    <div class="meta-row">
      <label>
        Fecha de inicio
      </label>
      <div class="value">
        {{ $proyecto->fecha_form_inicio }}
      </div>
    </div>
    @if($proyecto->fecha_fin)
    <div class="meta-row">
      <label>
        Fecha de fin
      </label>
      <div class="value">
        {{ $proyecto->fecha_form_fin }}
      </div>
    </div>
    @endif
    <div class="meta-row">
      <label>
        Estado
      </label>
      <span class="meta-badge on">
        {{ ucfirst(str_replace('_', ' ', $proyecto->estado)) }}
      </span>
    </div>
    @if($proyecto->pobl_obj)
    <div class="meta-row">
      <label>
        Población objetivo
      </label>
      <div class="value">
        {{ $proyecto->pobl_obj }}
      </div>
    </div>
    @endif
    <div class="meta-row">
      <label>
        Colonias
      </label>
        @if($colonias->isNotEmpty())
            <div class="simple-tag-list">
                @foreach($colonias as $colonia)
                    <span class="tag">
                        {{ $colonia->nombre }}
                    </span>
                @endforeach
            </div>
        @else
            <div class="value">
                Colonias no registradas
            </div>
        @endif
    </div>
    <div class="meta-row">
      <label>
        Áreas
      </label>
        @if($areas->isNotEmpty())
            <div class="simple-tag-list">
                @foreach($areas as $area)
                    <span class="tag">
                        {{ $area->nombre }}
                    </span>
                @endforeach
            </div>
        @else
            <div class="value">
                Áreas no registradas
            </div>
        @endif
    </div>
    <div class="meta-row">
      <label>
        Actividades
      </label>
        @if($responsabilidades->isNotEmpty())
            <div class="simple-tag-list">
                @foreach($responsabilidades as $responsabilidad)
                    <span class="tag">
                        {{ $responsabilidad->nombre }}
                    </span>
                @endforeach
            </div>
        @else
            <div class="value">
                Ejes no registrados
            </div>
        @endif
    </div>
    <div class="meta-row">
          <label>
              Ejes
          </label>
          @if($ejes->isNotEmpty())
              <div class="simple-tag-list">
                  @foreach($ejes as $eje)
                      <span class="tag">
                        {{ $eje->nombre }}
                    </span>
                  @endforeach
              </div>
          @else
              <div class="value">
                  Ejes no registrados
              </div>
          @endif
      </div>
    <div class="meta-row">
      <label>
        Problemáticas
      </label>
        @if($problematicas->isNotEmpty())
            <div class="simple-tag-list">
                @foreach($problematicas as $problematica)
                    <span class="tag">
                        {{ $problematica->nombre }}
                    </span>
                @endforeach
            </div>
        @else
            <div class="value">
                Problemáticas no registradas
            </div>
        @endif
    </div>
    @if($proyecto->repo)
    <div class="meta-row">
      <label>
        Repositorio
      </label>
     <a href="{{ $proyecto->repo }}" class="repo-link" target="_blank">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.5.5l2-2a5 5 0 0 0-7-7l-1.5 1.5"/>
          <path d="M14 11a5 5 0 0 0-7.5-.5l-2 2a5 5 0 0 0 7 7l1.5-1.5"/>
        </svg>
        Ver repositorio
      </a>
    </div>
    @endif
    @if($proyecto->auditable)
    <div class="meta-row">
      <label>
        Auditable
      </label>
      <a href="{{ $proyecto->auditable }}" class="repo-link" target="_blank">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.5.5l2-2a5 5 0 0 0-7-7l-1.5 1.5"/>
          <path d="M14 11a5 5 0 0 0-7.5-.5l-2 2a5 5 0 0 0 7 7l1.5-1.5"/>
        </svg>
        Ver archivos/evidencia
      </a>
    </div>
    @endif
  </div>
</div>
<div class="section-header">
  <h3>
    Involucrados
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Agregar involucrado
  </button>
</div>
@if($involucrados->isNotEmpty())
    <div class="table-card" style="margin-bottom: 32px;">
        <div style="padding: 6px 24px;">
            @foreach($involucrados as $involucrado)
                <div class="related-row">
            <span class="name">
                {{ $involucrado['nombre'] }}
                {{ $involucrado['ap_pat'] }}
                {{ $involucrado['ap_mat'] }}
            </span>
                    <span class="role-badge {{ in_array($involucrado['rol'], ['responsable_en_meneses', 'docente']) ? 'lider' : '' }}">
                {{ $involucrado['rol'] === 'otro'
                    ? $involucrado['otros']
                    : ucfirst(str_replace('_', ' ', $involucrado['rol'])) }}
            </span>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p>Sin involucrados registrados</p>
@endif
<div class="section-header">
  <h3>
    Historial
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nuevo reporte
  </button>
</div>
<div class="timeline-card">
  <div class="timeline">
    @if($historial->isNotEmpty())
        @foreach($historial as $historia)
              <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-date">
                      {{ $historia->fecha_formateada ?? '-' }}
                  </div>
                  <p class="timeline-text">
                      {{ $historia->comentario ?? '-' }}
                  </p>
              </div>
        @endforeach
    @else
        <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-date">
                --------
            </div>
                <p class="timeline-text">
                    Sin registros
                </p>
        </div>
    @endif
  </div>
</div>
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
