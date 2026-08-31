@extends('system.app')

@section('title', 'info · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('p_externo.index') }}" data-url="{{ route('p_externo.index') }}" class="return-index">
    Personas Externas
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Sofía Ramírez Duarte
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      Sofía Ramírez Duarte
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
    <div class="info-field">
      <label>
        Correo
      </label>
      <div class="value">
        sofiaramduar@gmail.com
      </div>
    </div>
    <div class="info-field">
      <label>
        Tipo de participación
      </label>
      <div class="value">
        Servicio social
      </div>
    </div>
    <div class="info-field">
      <label>
        Universidad
      </label>
      <div class="value">
        Universidad Iberoamericana
      </div>
    </div>
    <div class="info-field">
      <label>
        Matrícula
      </label>
      <div class="value">
        182345-4
      </div>
    </div>
    <div class="info-field">
      <label>
        Carrera
      </label>
      <div class="value">
        182345-4
      </div>
    </div>
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
<div class="participations-list">
  <details class="participation-item" open>
    <summary class="participation-summary">
      <div>
        <span class="person-name">
          Servicio social
          <span class="current-badge">
            Actual
          </span>
        </span>
        <div class="person-role">
          Otoño 2025
        </div>
      </div>
      <svg class="chevron-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 9l6 6 6-6"/>
      </svg>
    </summary>
    <div class="participation-body">
      <label class="mini-label">
        Aportaciones
      </label>
      <p class="participation-text">
        Apoyo en la elaboración del censo de colonias y sistematización de información para el diagnóstico comunitario.
      </p>
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
  <details class="participation-item">
    <summary class="participation-summary">
      <div>
        <span class="person-name">
          Materia de inmersión
        </span>
        <div class="person-role">
          Primavera 2025
        </div>
      </div>
      <svg class="chevron-icon" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M6 9l6 6 6-6"/>
      </svg>
    </summary>
    <div class="participation-body">
      <label class="mini-label">
        Aportaciones
      </label>
      <p class="participation-text">
        Apoyo logístico en la impartición del taller de alimentación saludable.
      </p>
      <label class="mini-label">
        Talleres
      </label>
      <div class="related-list">
        <div class="related-row">
          <span class="name">
            Alimentación Saludable
          </span>
        </div>
      </div>
    </div>
  </details>
</div>
@endsection