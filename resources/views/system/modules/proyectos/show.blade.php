@extends('system.app')

@section('title', 'Huertos Comunitarios · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="return-index">
    Proyectos
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Huertos Comunitarios
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      <svg class="star-icon" width="18" height="18" viewBox="0 0 24 24" fill="#111111" stroke="#111111" stroke-width="1.5" stroke-linejoin="round">
        <path d="M12 2.5l2.9 6.3 6.8.7-5.1 4.6 1.5 6.7L12 17.6l-6.1 3.2 1.5-6.7-5.1-4.6 6.8-.7Z"/>
      </svg>
      Huertos Comunitarios
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
      <p>
        Varias colonias del Pueblo Santa Fe reportaron falta de acceso a alimentos frescos y espacios verdes comunitarios durante los diagnósticos realizados por el centro en 2024.
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Objetivos
      </h3>
      <p>
        Habilitar huertos comunitarios en al menos dos colonias, capacitar a familias en producción de alimentos a pequeña escala, y fomentar el uso de espacios públicos para actividades colectivas.
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Alcance
      </h3>
      <p>
        El proyecto cubre inicialmente las colonias Loma Bonita y Vista Hermosa, con posibilidad de extenderse a colonias vecinas conforme se consolide el primer huerto piloto.
      </p>
    </div>
    <div class="doc-section">
      <h3>
        Evaluación
      </h3>
      <p class="empty">
        — aún sin evaluación registrada, el proyecto sigue en curso
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
        Fecha de fin
      </label>
      <div class="value">
        En curso
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
        Responsable(s)
      </label>
      <div class="value">
        María Torres Salinas
      </div>
      <div class="value">
        Sofía Ramírez Duarte
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
        Colonias
      </label>
      <div class="simple-tag-list">
        <span class="tag">
          Colonia 1
        </span>
        <span class="tag">
          Colonia 2
        </span>
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
        Problemáticas
      </label>
      <div class="simple-tag-list">
        <span class="tag">
          Desnutrición
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
        Sofía Ramírez Duarte
      </span>
      <span class="role-badge lider">
        Docente
      </span>
    </div>
    <div class="related-row">
      <span class="name">
        Diego Martínez Cobos
      </span>
      <span class="role-badge participante">
        Logística
      </span>
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
    Nuevo reporte
  </button>
</div>
<div class="timeline-card">
  <div class="timeline">
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        20 de julio, 2026
      </div>
      <p class="timeline-text">
        Se sembraron los primeros almácigos de jitomate y calabaza en el terreno de la colonia Loma Bonita.
      </p>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        2 de junio, 2026
      </div>
      <p class="timeline-text">
        Reunión con vecinos de Loma Bonita para definir el terreno disponible y acordar horarios de riego compartido.
      </p>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        15 de marzo, 2025
      </div>
      <p class="timeline-text">
        Arranque oficial del proyecto con recorrido por las colonias participantes.
      </p>
    </div>
  </div>
</div>
@endsection