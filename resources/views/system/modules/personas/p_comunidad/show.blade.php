@extends('system.app')

@section(
    'title',
    $usuaria
        ? $usuaria->nombre . ' ' . $usuaria->ap_pat . ' ' . $usuaria->ap_mat . ' · Ficha'
        : 'Sin resultados'
)

@section('content')
@if ($usuaria)
<div class="breadcrumb">
  <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}" class="return-index">
    Personas usuarias
  </a>
  <svg
                  width="13"
                  height="13"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
               >
    <path d="M9 6l6 6-6 6" />
  </svg>
  <span class="current">
    {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat }}
  </span>
</div>
<div class="content-header">
  <div>
    <h1>
      {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat }}
    </h1>
    <p>
      Ficha de persona de la persona usuaria
    </p>
  </div>
  <div class="header-actions">
    <button class="btn-outline">
      <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                     >
        <path d="M12 20h9" />
        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
      </svg>
      Editar
    </button>
    <button class="btn-danger">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M3 6h18" />
        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
        <path
                           d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"
                        />
        <path d="M10 11v6" />
        <path d="M14 11v6" />
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
            Categoría
        </label>
        <div class="value">
            {{ $usuaria->categoria }}
        </div>
    </div>
    @if($usuaria->edad)
    <div class="info-field">
        <label>
            Edad
        </label>
        <div class="value">
            {{ $usuaria->edad }} años
        </div>
    </div>
    @endif
    @if($usuaria->genero)
    <div class="info-field">
        <label>
            Genero
        </label>
        <div class="value">
            {{ ucfirst($usuaria->genero) }}
        </div>
    </div>
    @endif
    @if($usuaria->nv_escolar)
    <div class="info-field">
        <label>
            Nivel escolar
        </label>
        <div class="value">
            {{ ucfirst($usuaria->nv_escolar) }}
        </div>
    </div>
    @endif
    @if($usuaria->telefono)
    <div class="info-field">
        <label>
            Nivel escolar
        </label>
        <div class="value">
            {{ $usuaria->telefono }}
        </div>
    </div>
    @endif
  </div>
</div>

@if($usuaria->saberes)
<div class="doc-card" style="margin-top: 32px;">
  <div class="doc-section">
    <h3>Directoio de saberes</h3>
    <p>{{ $usuaria->saberes }}</p>
  </div>
</div>
@endif

<div class="related-grid">
  <div class="related-card">
    <h3>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path
                           d="M14.7 6.3a4 4 0 1 1-5.4 5.4L2 19v3h3l7.3-7.3"
                        />
        <path d="M17.5 3.5 20.5 6.5" />
        <path d="M15 9l5-5" />
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
  <a type="button" class="btn-outline" href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/>
    </svg>
    Regresar
</a>
</div>
@endif

@endsection