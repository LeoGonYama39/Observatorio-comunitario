@extends('system.app')

@section('title', 'Colonia 1 · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('colonias.index') }}" data-url="{{ route('colonias.index') }}" class="return-index">
    Colonias
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Colonia 1
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      Colonia 1
    </h1>
    <p>
      Ficha de colonia
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
  </div>
</div>
<div class="info-card">
  <h3>
    Información general
  </h3>
  <div class="info-grid">
    <div class="info-field">
      <label>
        Nombre
      </label>
      <div class="value">
        Colonia 1
      </div>
    </div>
    <div class="info-field">
      <label>
        Viviendas
      </label>
      <div class="value">
        168
      </div>
    </div>
    <div class="info-field">
      <label>
        Adultos
      </label>
      <div class="value">
        420
      </div>
    </div>
    <div class="info-field">
      <label>
        Niños
      </label>
      <div class="value">
        192
      </div>
    </div>
    <div class="info-field">
      <label>
        Incidencia social
      </label>
      <div class="value">
        3
      </div>
    </div>
    <div class="info-field">
      <label>
        Población total
      </label>
      <div class="value">
        612
      </div>
    </div>
  </div>
</div>
<div class="related-grid" style="grid-template-columns: repeat(3, 1fr);">
  <div class="related-card">
    <h3>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 9v4"/>
        <path d="M12 17h.01"/>
        <path d="M10.3 3.9 2.4 18a2 2 0 0 0 1.7 3h16a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
      </svg>
      Problemáticas
    </h3>
    <div class="simple-tag-list">
      <span class="tag">
        Inseguridad
      </span>
      <span class="tag">
        Falta de drenaje
      </span>
      <span class="tag">
        Desnutrición infantil
      </span>
    </div>
  </div>
  <div class="related-card">
    <h3>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 21V8l8-5 8 5v13"/>
        <path d="M9 21v-7h6v7"/>
        <path d="M4 12h16"/>
      </svg>
      Espacios históricos
    </h3>
    <div class="related-list">
      <div class="related-row">
        <span class="name">
          Capilla de Santa Fe
        </span>
      </div>
      <div class="related-row">
        <span class="name">
          Plaza del Fundador
        </span>
      </div>
    </div>
  </div>
  <div class="related-card">
    <h3>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 11l3 3L22 4"/>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
      </svg>
      Proyectos
    </h3>
    <div class="related-list">
      <div class="related-row">
        <span class="name">
          Huertos comunitarios
        </span>
      </div>
      <div class="related-row">
        <span class="name">
          Salud preventiva en coloniasr
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
    Nuevo reporte
  </button>
</div>
<div class="timeline-card">
  <div class="timeline">
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        4 de agosto, 2026
      </div>
      <p class="timeline-text">
        Investigación para implemetnación de nuevo proyecto.
      </p>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        2 de ener, 2026
      </div>
      <p class="timeline-text">
        Reporte de incidente en casas de la calle x.
      </p>
    </div>
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        15 de marzo, 2025
      </div>
      <p class="timeline-text">
        implemetnación de huertos comuntiarios en la colonia.
      </p>
    </div>
  </div>
</div>
@endsection