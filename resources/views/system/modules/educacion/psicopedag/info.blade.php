@extends('system.app')

@section('title', 'Rosa Elena Camposeco Vidal · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('psicopedag.index') }}" data-url="{{ route('psicopedag.index') }}" class="return-index">
    Atención psicopedagógica
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Rosa Elena Camposeco Vidal
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      Rosa Elena Camposeco Vidal
    </h1>
    <p>
      Ficha
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
        15 de marzo, 2026
      </div>
    </div>
    <div class="info-field">
      <label>
        Estado
      </label>
      <span class="meta-badge on">
        Activo
      </span>
    </div>
    <div class="info-field">
      <label>
        Tipo
      </label>
      <div class="value">
        Socioemocional
      </div>
    </div>
    <div class="info-field">
      <label>
        Motivos
      </label>
      <div class="simple-tag-list">
        <span class="tag">
          Depresión
        </span>
        <span class="tag">
          Ansiedad
        </span>
      </div>
    </div>
  </div>
</div>
<div class="section-header">
  <h3>
    Historial
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nuevo seguimiento
  </button>
</div>
<div class="timeline-card">
  <div class="timeline">
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        22 de julio, 2026
      </div>
      <p class="timeline-text">
        Reunión con los padres.
      </p>
      <div class="attendees">
        <span class="mini-label">
          Atendido por
        </span>
        <span class="attendee-chip">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
          </svg>
          Emilio Vargas Núñez
        </span>
        <span class="attendee-chip">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
          </svg>
          María Torres Salinas
        </span>
      </div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        10 de junio, 2026
      </div>
      <p class="timeline-text">
        Seguimiento del caso.
      </p>
      <div class="attendees">
        <span class="mini-label">
          Atendido por
        </span>
        <span class="attendee-chip">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
          </svg>
          Emilio Vargas Núñez
        </span>
      </div>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        15 de marzo, 2026
      </div>
      <p class="timeline-text">
        Primera consulta.
      </p>
      <div class="attendees">
        <span class="mini-label">
          Atendido por
        </span>
        <span class="attendee-chip">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
          </svg>
          Emilio Vargas Núñez
        </span>
      </div>
    </div>
  </div>
</div>
@endsection