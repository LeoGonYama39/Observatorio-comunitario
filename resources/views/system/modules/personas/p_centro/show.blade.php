@extends('system.app')

@section(
    'title',
    $centro
        ? $centro->nombre . ' ' . $centro->ap_pat . ' ' . $centro->ap_mat . ' · Ficha'
        : 'Sin resultados'
)

@section('content')
@if($centro)
<div class="breadcrumb">
  <a href="{{ route('personas-centro.index') }}" data-url="{{ route('personas-centro.index') }}" class="return-index">
    Personas del Centro
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    {{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}
  </span>
</div>

@include('system.parts.alerts')

<div class="content-header">
  <div>
    <h1>
     {{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}
    </h1>
    <p>
      Ficha de persona del centro
    </p>
  </div>
  <div class="header-actions">
    <a href="{{ route('personas-centro.edit', $centro->id) }}" data-url="{{ route('personas-centro.edit', $centro->id) }}" class="btn-outline">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 20h9"/>
        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
      </svg>
      Editar
  </a>
    <button type="button" class="btn-danger" onclick="document.getElementById('modalEliminar').showModal()">
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
        {{ ucfirst(str_replace('_', ' ', $centro->cargo)) }}
      </div>
    </div>
    @if($centro->a_cargo_de)
    <div class="info-field">
      <label>
        A cargo de
      </label>
      <div class="value">
        {{ $centro->a_cargo_de }}
      </div>
    </div>
    @endif
  </div>
</div>

<dialog id="modalEliminar" class="confirm-modal" onclick="if (event.target === this) this.close()">
  <div class="confirm-modal-content">
    <div class="confirm-modal-header">
      <div class="confirm-modal-icon">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 6h18"/>
          <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
          <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
          <path d="M10 11v6"/>
          <path d="M14 11v6"/>
        </svg>
      </div>
      <div>
        <h3>¿Eliminar persona del centro?</h3>
        <p>Esta acción no se puede deshacer. Se eliminará el registro de <strong>{{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}</strong>.</p>
      </div>
    </div>
    <div class="confirm-modal-actions">
      <button type="button" class="btn-outline" onclick="document.getElementById('modalEliminar').close()">
        Cancelar
      </button>
      <form action="{{ route('personas-centro.destroy', $centro->id) }}" method="POST" style="margin: 0;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18"/>
            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
          </svg>
          Confirmar eliminación
        </button>
      </form>
    </div>
  </div>
</dialog>
@else
    @include('system.parts.not_found', ['route' => route('personas-centro.index')])
@endif

@endsection
