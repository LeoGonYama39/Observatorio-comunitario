@extends('system.app')

@section('title', 'María Torres Salinas · Centro Ibero Meneses')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('p_centro.index') }}" data-url="{{ route('p_centro.index') }}" class="return-index">
    Personas del Centro
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    María Torres Salinas
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      María Torres Salinas
    </h1>
    <p>
      Ficha de persona del centro
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
        Cargo
      </label>
      <div class="value">
        Coordinadora
      </div>
    </div>
    <div class="info-field">
      <label>
        Área a cargo
      </label>
      <div class="value">
        Nutrición Comunitaria
      </div>
    </div>
  </div>
</div>
<div class="related-grid">
  <div class="related-card">
    <h3>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 11l3 3L22 4"/>
        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
      </svg>
      Proyectos
    </h3>
    <div class="related-list">
      <div class="related-row">
        <span class="name">
          Huertos Comunitarios
        </span>
        <span class="role-badge lider">
          Líder
        </span>
      </div>
      <div class="related-row">
        <span class="name">
          Salud Preventiva en Colonias
        </span>
        <span class="role-badge participante">
          Participante
        </span>
      </div>
    </div>
  </div>
  <div class="related-card">
    <h3>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 7a2 2 0 0 1 2-2h4l2 2.5h7a2 2 0 0 1 2 2V17a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"/>
      </svg>
      Casos
    </h3>
    <div class="simple-tag-list">
      <span class="tag">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 3c-1 3-4 4-4 8a4 4 0 0 0 8 0c0-4-3-5-4-8Z"/>
          <path d="M12 13v8"/>
        </svg>
        Da consultas nutricionales
      </span>
    </div>
  </div>
  <div class="related-card">
    <h3>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M14.7 6.3a4 4 0 1 1-5.4 5.4L2 19v3h3l7.3-7.3"/>
        <path d="M17.5 3.5 20.5 6.5"/>
        <path d="M15 9l5-5"/>
      </svg>
      Talleres
    </h3>
    <div class="related-list">
      <div class="related-row">
        <span class="name">
          Alimentación Saludable
        </span>
      </div>
    </div>
  </div>
</div>
@endsection