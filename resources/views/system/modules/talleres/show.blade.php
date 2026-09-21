@extends('system.app')

@section('title', $taller
  ? $taller->nombre . ' · Ficha'
  : 'Sin resultados')

@section('content')
@if($taller)
<div class="breadcrumb">
  <a href="{{ route('talleres.index') }}" data-url="{{ route('talleres.index') }}" class="return-index">
    Talleres
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    {{ $taller->nombre }}
  </span>
</div>

@include('system.parts.alerts')

<div class="content-header">
  <div>
    <h1>
      {{ $taller->nombre }}
    </h1>
    <p>
      Ficha de taller
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
        Objetivos
      </h3>
      <p class="{{ $taller->objetivos ? '' : 'empty'}}">
        {{ $taller->objetivos ?? '-'}}
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Alcance
      </h3>
      <p class="{{ $taller->alcance ? '' : 'empty'}}">
        {{ $taller->alcance ?? '-'}}
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Evaluación
      </h3>
      <p class="{{ $taller->evaluacion ? '' : 'empty'}}">
        {{ $taller->evaluacion ?? '-'}}
      </p>
    </div>
  </div>
  <div class="meta-card">
    <div class="meta-row">
      <label>
        Estado
      </label>
      <span class="meta-badge {{ $taller->estado === 'activo' ? 'on' : '' }}">
        {{ ucfirst(str_replace('_', ' ', $taller->estado)) }}
      </span>
    </div>
    <div class="meta-row">
      <label>
        Generaciones
      </label>
      <div class="value">
        {{ $generaciones->count() }}
      </div>
    </div>
    @if($taller->pobl_obj)
    <div class="meta-row">
      <label>
        Población objetivo
      </label>
      <div class="value">
        {{ $taller->pobl_obj }}
      </div>
    </div>
    @endif
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
        Ejes de acción
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
    @if($taller->repo)
    <div class="meta-row">
      <label>
        Repositorio
      </label>
      <a href="{{ $taller->repo }}" class="repo-link" target="_blank">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.5.5l2-2a5 5 0 0 0-7-7l-1.5 1.5"/>
          <path d="M14 11a5 5 0 0 0-7.5-.5l-2 2a5 5 0 0 0 7 7l1.5-1.5"/>
        </svg>
        Ver repositorio
      </a>
    </div>
    @endif
    @if($taller->auditable)
    <div class="meta-row">
      <label>
        Auditable
      </label>
      <a href="{{ $taller->auditable }}" class="repo-link" target="_blank">
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
    <p style="margin-bottom: 32px; color: var(--steel); font-size: 14px;">Sin involucrados registrados</p>
@endif
<div class="section-header">
  <h3>
    Grupos
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nuevo grupo
  </button>
</div>
@if($generaciones->isNotEmpty())
<div class="generations-list">
  @foreach($generaciones as $generacion)
    @php
      $metricas = $generacion->metricas;
      $talleristas = $generacion->talleristas;
    @endphp
    <div class="generation-card">
      <div class="generation-top">
        <span class="generation-period">
          {{ ucfirst($generacion->temporada) }} {{ $generacion->anio }}
        </span>
        <span class="meta-badge {{ $generacion->activo ? 'on' : '' }}">
          {{ $generacion->activo ? 'En curso' : 'Finalizada' }}
        </span>
      </div>
      <div class="attendees">
        <span class="mini-label">
          Impartido por
        </span>
        @if($talleristas->isNotEmpty())
          @foreach($talleristas as $tallerista)
            <span class="attendee-chip">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
              </svg>
              {{ $tallerista['nombre_completo'] }}
            </span>
          @endforeach
        @else
          <span style="color: var(--steel); font-size: 13px;">Sin talleristas asignados</span>
        @endif
      </div>
      <div class="participants-count">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        {{ $metricas['total'] }} {{ $metricas['total'] === 1 ? 'participante' : 'participantes' }}
      </div>
      <button type="button" class="breakdown-toggle" onclick="toggleBreakdown(this)">
        Ver desglose de participantes
        <svg class="chevron-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 9l6 6 6-6"/>
        </svg>
      </button>
      <div class="generation-breakdown" hidden>
        <div class="breakdown-row">
          <span class="mini-label">
            Género
          </span>
          <div class="simple-tag-list">
            <span class="tag">
              {{ $metricas['genero']['femenino'] }} {{ $metricas['genero']['femenino'] === 1 ? 'mujer' : 'mujeres' }}
            </span>
            <span class="tag">
              {{ $metricas['genero']['masculino'] }} {{ $metricas['genero']['masculino'] === 1 ? 'hombre' : 'hombres' }}
            </span>
            @if(($metricas['genero']['no_binario'] ?? 0) > 0)
              <span class="tag">
                {{ $metricas['genero']['no_binario'] }} no binario
              </span>
            @endif
          </div>
        </div>
        <div class="breakdown-row">
          <span class="mini-label">
            Colonias
          </span>
          @if(!empty($metricas['colonias']))
            <div class="simple-tag-list">
              @foreach($metricas['colonias'] as $colonia => $conteo)
                <span class="tag">
                  {{ $colonia }} ({{ $conteo }})
                </span>
              @endforeach
            </div>
          @else
            <span class="empty" style="font-size: 13px; color: var(--steel);">Sin registro</span>
          @endif
        </div>
        <div class="breakdown-row">
          <span class="mini-label">
            Rangos de edad
          </span>
          @php
            $edadesConDatos = array_filter($metricas['rangos_edad'], fn($c) => $c > 0);
          @endphp
          @if(!empty($edadesConDatos))
            <div class="simple-tag-list">
              @foreach($edadesConDatos as $rango => $conteo)
                <span class="tag">
                  {{ $rango }} años ({{ $conteo }})
                </span>
              @endforeach
            </div>
          @else
            <span class="empty" style="font-size: 13px; color: var(--steel);">Sin registro</span>
          @endif
        </div>
        <div class="breakdown-row">
          <span class="mini-label">
            Bajas
          </span>
          <div class="simple-tag-list">
            <span class="tag">
              Bajas ({{ $metricas['bajas'] }})
            </span>
          </div>
        </div>
      </div>
      <div class="generation-eval">
        <span class="mini-label">
          Evaluación
        </span>
        @if(!empty($generacion->evaluacion))
          <p>
            {{ $generacion->evaluacion }}
          </p>
        @else
          <p class="empty">
            — aún sin evaluación registrada{{ $generacion->activo ? ', el grupo sigue en curso' : '' }}
          </p>
        @endif
      </div>
    </div>
  @endforeach
</div>
@else
  <p style="color: var(--steel); font-size: 14px; margin-top: 10px;">Sin grupos registrados</p>
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
  <a type="button" class="btn-outline" href="{{ route('talleres.index') }}" data-url="{{ route('talleres.index') }}">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/>
    </svg>
    Regresar
  </a>
</div>
@endif
@endsection
