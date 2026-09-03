@extends('system.app')

@section('title', 'Ciclio I · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('proc_grup.index') }}" data-url="{{ route('proc_grup.index') }}" class="return-index">
    Procesos grupales
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Ciclio I
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      Ciclio I
    </h1>
    <p>
      Ficha del proceso grupal
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
        Periodo
      </label>
      <div class="value">
        Otoño 2026 - Otoño 2028
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
        No. de talleres
      </label>
      <div class="value">
        4
      </div>
    </div>
  </div>
</div>

<div class="section-header">
  <h3>
    Talleres
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nuevo taller
  </button>
</div>
<div class="generations-list">
  <div class="generation-card">
    <div class="generation-top">
      <span class="generation-period">
        Nombre-taller · Otoño 2026
      </span>
      <span class="meta-badge on">
        En curso
      </span>
    </div>
    <div class="attendees">
      <span class="mini-label">
        Impartido por
      </span>
      <span class="attendee-chip">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
        </svg>
        María Torres Salinas
      </span>
    </div>
    <div class="participants-count">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      14 participantes
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
            8 mujeres
          </span>
          <span class="tag">
            6 hombres
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Colonias
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Colonia 1 (5)
          </span>
          <span class="tag">
            Colonia 2 (4)
          </span>
          <span class="tag">
            Colonia 3 (5)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Rangos de edad
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            12–17 años (3)
          </span>
          <span class="tag">
            18–25 años (6)
          </span>
          <span class="tag">
            26–40 años (5)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Bajas
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Bajas (2)
          </span>
        </div>
      </div>
    </div>
    <div class="generation-eval">
      <span class="mini-label">
        Evaluación
      </span>
      <p class="empty">
        — aún sin evaluación registrada, el grupo sigue en curso
      </p>
    </div>
  </div>
  <div class="generation-card">
    <div class="generation-top">
      <span class="generation-period">
        Nombre-taller · Primavera 2027
      </span>
      <span class="meta-badge">
        A impartir
      </span>
    </div>
    <div class="attendees">
      <span class="mini-label">
        Impartido por
      </span>
      <span class="attendee-chip">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
        </svg>
        María Torres Salinas
      </span>
    </div>
    <div class="participants-count">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      14 participantes
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
            8 mujeres
          </span>
          <span class="tag">
            6 hombres
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Colonias
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Colonia 1 (5)
          </span>
          <span class="tag">
            Colonia 2 (4)
          </span>
          <span class="tag">
            Colonia 3 (5)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Rangos de edad
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            12–17 años (3)
          </span>
          <span class="tag">
            18–25 años (6)
          </span>
          <span class="tag">
            26–40 años (5)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Bajas
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Bajas (2)
          </span>
        </div>
      </div>
    </div>
    <div class="generation-eval">
      <span class="mini-label">
        Evaluación
      </span>
      <p class="empty">
        — aún sin evaluación registrada, el grupo sigue en curso
      </p>
    </div>
  </div>
  <div class="generation-card">
    <div class="generation-top">
      <span class="generation-period">
        Nombre-taller · Otoño 2027
      </span>
      <span class="meta-badge on">
        A impartir
      </span>
    </div>
    <div class="attendees">
      <span class="mini-label">
        Impartido por
      </span>
      <span class="attendee-chip">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
        </svg>
        Sofía Ramírez Duarte
      </span>
    </div>
    <div class="participants-count">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      9 participantes
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
            8 mujeres
          </span>
          <span class="tag">
            1 hombres
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Colonias
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Colonia 1 (5)
          </span>
          <span class="tag">
            Colonia 2 (4)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Rangos de edad
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            12–17 años (3)
          </span>
          <span class="tag">
            26–40 años (6)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Bajas
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Bajas (5)
          </span>
        </div>
      </div>
    </div>
    <div class="generation-eval">
      <span class="mini-label">
        Evaluación
      </span>
      <p class="empty">
        — aún sin evaluación registrada, el grupo sigue en curso
      </p>
    </div>
  </div>
  <div class="generation-card">
    <div class="generation-top">
      <span class="generation-period">
        Nombre-taller · Primavera 2028  
      </span>
      <span class="meta-badge">
        Finalizada
      </span>
    </div>
    <div class="attendees">
      <span class="mini-label">
        Impartido por
      </span>
      <span class="attendee-chip">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
        </svg>
        María Torres Salinas
      </span>
    </div>
    <div class="participants-count">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
        <circle cx="9" cy="7" r="4"/>
        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
      </svg>
      11 participantes
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
            3 mujeres
          </span>
          <span class="tag">
            8 hombres
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Colonias
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Colonia 1 (5)
          </span>
          <span class="tag">
            Colonia 2 (4)
          </span>
          <span class="tag">
            Colonia 3 (2)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Rangos de edad
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            12–17 años (3)
          </span>
          <span class="tag">
            18–25 años (6)
          </span>
          <span class="tag">
            26–40 años (2)
          </span>
        </div>
      </div>
      <div class="breakdown-row">
        <span class="mini-label">
          Bajas
        </span>
        <div class="simple-tag-list">
          <span class="tag">
            Bajas (0)
          </span>
        </div>
      </div>
    </div>
    <div class="generation-eval">
      <span class="mini-label">
        Evaluación
      </span>
      <p>
        Buena participación y asistencia constante; varias familias solicitaron una segunda edición del taller.
      </p>
    </div>
  </div>
</div>
@endsection