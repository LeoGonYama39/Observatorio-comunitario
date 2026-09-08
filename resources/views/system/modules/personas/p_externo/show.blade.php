@extends('system.app')

@section(
    'title',
    $externo
        ? $externo->nombre . ' ' . $externo->ap_pat . ' ' . $externo->ap_mat . ' · Ficha'
        : 'Sin resultados'
)

@section('content')

@if ($externo)
<div class="breadcrumb">
  <a href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}" class="return-index">
    Personas Externas
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    {{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      {{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}
    </h1>
    <p>
      Ficha de persona externa
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
<div class="info-card">
  <h3>
    Información general
  </h3>
  <div class="info-grid">
    @if($externo->correo)
    <div class="info-field">
      <label>
        Correo
      </label>
      <div class="value">
        {{ $externo->correo }}
      </div>
    </div>
    @endif
    <div class="info-field">
      <label>
        Tipo de participación
      </label>
      <div class="value">
        Servicio social
      </div>
    </div>
    @if($externo->universidad)
    <div class="info-field">
      <label>
        Universidad
      </label>
      <div class="value">
        {{ $externo->universidad }}
      </div>
    </div>
    @endif
    @if($externo->matricula)
    <div class="info-field">
      <label>
        Matrícula
      </label>
      <div class="value">
        {{ $externo->matricula }}
      </div>
    </div>
    @endif
    @if($externo->carrera)
    <div class="info-field">
      <label>
        Carrera
      </label>
      <div class="value">
        {{ $externo->carrera }}
      </div>
    </div>
    @endif
    <div class="info-field">
      <label>
        Área
      </label>
      <div class="value">
        Vinculación
      </div>
    </div>
  </div>
</div>
<div class="section-header">
  <h3>
    Participaciones
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nueva participación
  </button>
</div>

@if($participaciones->isNotEmpty())
<div class="participations-list">
  @foreach($participaciones as $participacion)
  <details class="participation-item" @if(($loop->iteration === 1) && ($participacion->activo)) open @endif>
    <summary class="participation-summary">
      <div>
        <span class="person-name">
          {{ ucfirst(str_replace('_', ' ', $participacion->tipo)) }}
          <span class="current-badge">
            @if(($loop->iteration === 1) && ($participacion->activo)) 
            Activo
            @else
            Concluido
            @endif
          </span>
        </span>
        <div class="person-role">
          {{ ucfirst($participacion->temporada) }} {{ $participacion->anio }}
        </div>
      </div>
      <svg class="chevron-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 9l6 6 6-6"/>
      </svg>
    </summary>
    <div class="participation-body">
      @if($participacion->aport)
      <label class="mini-label">
        Aportaciones
      </label>
      <p class="participation-text">
        {{ $participacion->aport}}
      </p>
      @endif
      <label class="mini-label">
        Proyectos
      </label>
      <div class="related-list">
        <div class="related-row">
          <span class="name">
            Diagnóstico Comunitario
          </span>
          <span class="role-badge participante">
            Participante
          </span>
        </div>
      </div>
    </div>
  </details>
  @endforeach
</div>
@else
<p>Sin participaciones.</p>
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
  <a type="button" class="btn-outline" href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/>
    </svg>
    Regresar
</a>
</div>
@endif

@endsection