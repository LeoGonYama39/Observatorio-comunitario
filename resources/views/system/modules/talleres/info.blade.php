@extends('system.app')

@section('title', 'Alimentación Saludable · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('talleres.index') }}" data-url="{{ route('talleres.index') }}" class="return-index">
    Talleres
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Alimentación Saludable
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      Alimentación Saludable
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
      <p>
        Brindar a las familias herramientas prácticas para mejorar su alimentación diaria con recursos accesibles, promoviendo hábitos saludables sostenibles en el tiempo.
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Alcance
      </h3>
      <p>
        Dirigido a personas adultas de las colonias cercanas al centro, con sesiones prácticas de cocina y pláticas sobre nutrición básica.
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Evaluación
      </h3>
      <p>
        Buena respuesta general de los asistentes; se identificó interés en ampliar el taller con un módulo sobre conservación de alimentos.
      </p>
    </div>
  </div>
  <div class="meta-card">
    <div class="meta-row">
      <label>
        Fecha de inicio
      </label>
      <div class="value">
        15 de marzo, 2025
      </div>
    </div>
    <div class="meta-row">
      <label>
        Estado
      </label>
      <span class="meta-badge on">
        Activo
      </span>
    </div>
    <div class="meta-row">
      <label>
        Generaciones
      </label>
      <div class="value">
        3
      </div>
    </div>
    <div class="meta-row">
      <label>
        Responsable
      </label>
      <div class="value">
        María Torres Salinas
      </div>
    </div>
    <div class="meta-row">
      <label>
        Población objetivo
      </label>
      <div class="value">
        3 - 65 años
      </div>
    </div>
    <div class="meta-row">
      <label>
        Áreas
      </label>
      <div class="simple-tag-list">
        <span class="tag">
          Nutrición Comunitaria
        </span>
      </div>
    </div>
    <div class="meta-row">
      <label>
        Ejes de acción
      </label>
      <div class="simple-tag-list">
        <span class="tag">
          Eje 1
        </span>
        <span class="tag">
          Eje 2
        </span>
      </div>
    </div>
    <div class="meta-row">
      <label>
        Repositorio
      </label>
      <a href="#" class="repo-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.5.5l2-2a5 5 0 0 0-7-7l-1.5 1.5"/>
          <path d="M14 11a5 5 0 0 0-7.5-.5l-2 2a5 5 0 0 0 7 7l1.5-1.5"/>
        </svg>
        Ver repositorio
      </a>
    </div>
    <div class="meta-row">
      <label>
        Auditable
      </label>
      <div class="value">
        Sí
      </div>
      <br>
      <a href="#" class="repo-link">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 13a5 5 0 0 0 7.5.5l2-2a5 5 0 0 0-7-7l-1.5 1.5"/>
          <path d="M14 11a5 5 0 0 0-7.5-.5l-2 2a5 5 0 0 0 7 7l1.5-1.5"/>
        </svg>
        Ver repositorio
      </a>
    </div>
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
<div class="table-card" style="margin-bottom: 32px;">
  <div style="padding: 6px 24px;">
    <div class="related-row">
      <span class="name">
        María Torres Salinas
      </span>
      <span class="role-badge lider">
        Resp. Meneses
      </span>
    </div>
    <div class="related-row">
      <span class="name">
        Hospital ABC
      </span>
      <span class="role-badge participante">
        Planeación de temas
      </span>
    </div>
  </div>
</div>
<div class="section-header">
  <h3>
    Generaciones
  </h3>
  <button class="btn-outline btn-small">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nueva generación
  </button>
</div>
<div class="generations-list">
  <div class="generation-card">
    <div class="generation-top">
      <span class="generation-period">
        Febrero 2026 — Julio 2026
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
        Febrero 2026 — Mayo 2026
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
        Enero 2025 — Junio 2025
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
<script>
  function toggleBreakdown(btn) {
      const panel = btn.nextElementSibling;
      if (panel.hasAttribute('hidden')) {
        panel.removeAttribute('hidden');
        btn.classList.add('open');
      } else {
        panel.setAttribute('hidden', '');
        btn.classList.remove('open');
      }
    }
</script>
@endsection