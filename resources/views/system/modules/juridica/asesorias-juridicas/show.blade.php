@extends('system.app')

@section('title', 'Fernando Castellanos · Asesoría jurídica')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('a-juridicas.index') }}" data-url="{{ route('a-juridicas.index') }}" class="return-index">
    Asesoría jurídica
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Fernando Castellanos
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      Fernando Castellanos
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
        Periodo
      </label>
      <div class="value">
        Otoño 2026
      </div>
    </div>
    <div class="info-field">
      <label>
        Estado
      </label>
      <span class="meta-badge on">
        Acompañamiento
      </span>
    </div>
    <div class="info-field">
      <label>
        Ramas
      </label>
      <div class="simple-tag-list">
        <span class="tag">
          Civil
        </span>
        <span class="tag">
          Notarial y registral
        </span>
      </div>
    </div>
    <div class="info-field">
      <label>
        Conflictos
      </label>
      <div class="simple-tag-list">
        <span class="tag">
          Jubilaciones y pensiones
        </span>
        <span class="tag">
          Afore
        </span>
      </div>
    </div>
    <div class="info-field">
      <label>
        Edad
      </label>
      <div class="value">
        70 años
      </div>
    </div>
    <div class="info-field">
      <label>
        Colonia
      </label>
      <div class="value">
        Cuevitas
      </div>
    </div>
  </div>
</div>

<div class="section-header">
  <h3>
    Involucrados en el conflicto
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
        Mario Castellano
      </span>
      <span class="role-badge participante">
        Familiar directo
      </span>
    </div>
    <div class="related-row">
      <span class="name">
        Marco Elisondo
      </span>
      <span class="role-badge participante">
        Familiar indirecto
      </span>
    </div>
  </div>
</div>
@endsection