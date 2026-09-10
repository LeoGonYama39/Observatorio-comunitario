@extends('system.app')

@section(
    'title',
    $colonia
        ? $colonia->nombre . ' · Ficha'
        : 'Sin resultados'
)

@section('content')

@if($colonia)
<div class="breadcrumb">
  <a href="{{ route('colonias.index') }}" data-url="{{ route('colonias.index') }}" class="return-index">
    Colonias
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    {{ $colonia->nombre }}
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      {{ $colonia->nombre }}
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
        Viviendas
      </label>
      <div class="value {{ $colonia->viviendas ? '' : 'empty'}}">
        {{ $colonia->viviendas ?? '-'}}
      </div>
    </div>
    <div class="info-field">
      <label>
        Adultos
      </label>
      <div class="value {{ $colonia->adultos ? '' : 'empty'}}">
        {{ $colonia->adultos ?? '-' }}
      </div>
    </div>
    <div class="info-field">
      <label>
        Niños
      </label>
      <div class="value {{ $colonia->ninos ? '' : 'empty'}}">
        {{ $colonia->ninos ?? '-' }}
      </div>
    </div>
    <div class="info-field">
      <label>
        Incidencia social
      </label>
      <div class="value">
        {{ $proyectos->count() }}
      </div>
    </div>
    <div class="info-field">
      <label>
        Población total
      </label>
      <div class="value {{ $colonia->pob_total ? '' : 'empty'}}">
        {{ $colonia->pob_total ?? '-' }}
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
      @if($problematicas->isNotEmpty())
      @foreach($problematicas as $problematica)
      <span class="tag">
        {{ ucfirst($problematica) }}
      </span>
      @endforeach
      @else
      <span class="tag">
        Sin problemáticas registradas
      </span>
      @endif
    </div>
  </div>
  <div class="related-card">
    <h3>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 21V8l8-5 8 5v13"/>
        <path d="M9 21v-7h6v7"/>
        <path d="M4 12h16"/>
      </svg>
      Espacios históricos (no programado)
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
      @if($proyectos->isNotEmpty())
      @foreach($proyectos as $proyecto)
      <div class="related-row">
        <span class="name">
          {{ $proyecto }}
        </span>
      </div>
      @endforeach
      @else
      <div class="related-row">
        <span class="name">
          Sin proyectos registrados
        </span>
      </div>
      @endif
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
    Nueva nota
  </button>
</div>
<div class="timeline-card">
  <div class="timeline">
@if($historial->isNotEmpty())
    @foreach($historial as $historia)
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        {{ $historia->fecha_formateada }}
      </div>
      <p class="timeline-text">
        {{ $historia->comentario }}
      </p>
    </div>
    @endforeach
@else
    <div class="timeline-item">
      <div class="timeline-dot">
      </div>
      <div class="timeline-date">
        ---
      </div>
      <p class="timeline-text">
        Sin registro de historial
      </p>
    </div>
@endif
  </div>
</div>

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
  <a type="button" class="btn-outline" href="{{ route('colonias.index') }}" data-url="{{ route('colonias.index') }}">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/>
    </svg>
    Regresar
</a>
</div>
@endif
@endsection