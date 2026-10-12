{{--
  Selector de UNA sola persona, con buscador.

  Params:
  - $name: nombre del campo hidden que viaja en el POST (default 'comunidad_id')
  - $label: título de la sección (default 'Persona')
  - $options: Collection de objetos con ->id y ->nombre, y opcionales:
        ->subtitle  texto chico bajo el nombre
        ->detalles  array [etiqueta => valor], se muestra en la tarjeta al seleccionar
  - $yaRegistrados: array de ids que salen marcados y NO se pueden seleccionar (default [])
  - $etiquetaRegistrado: texto de la etiqueta de esas filas (default 'Ya registrado')
  - $mensajeRegistrado: aviso al hacer clic en una de esas filas
  - $selected: id preseleccionado (default: lo que traiga old($name), por si el form regresó con errores)

  Los campos que dependen de haber elegido a alguien van en un contenedor con
  data-depende-de="{{ $name }}" y class="acceso-fields": se muestran y habilitan solos al seleccionar.
--}}
@php
    $name = $name ?? 'comunidad_id';
    $label = $label ?? 'Persona';
    $yaRegistrados = $yaRegistrados ?? [];
    $etiquetaRegistrado = $etiquetaRegistrado ?? 'Ya registrado';
    $mensajeRegistrado = $mensajeRegistrado ?? 'Esta persona ya está registrada.';

    $selectedId = old($name, $selected ?? null);
    $seleccionada = ($selectedId && !in_array($selectedId, $yaRegistrados))
        ? $options->firstWhere('id', $selectedId)
        : null;
@endphp

<div class="entity-picker" data-single-picker="{{ $name }}">
  <h3 class="form-section-title">{{ $label }}</h3>

  <div class="table-search">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="7"/>
      <path d="m21 21-4.3-4.3"/>
    </svg>
    <input type="text" placeholder="Buscar por nombre…" onkeydown="if (event.key === 'Enter') event.preventDefault()">
  </div>

  <div class="table-card">
    <div class="entity-scroll">
      <table>
        <tbody>
          @foreach($options as $option)
          @php $registrado = in_array($option->id, $yaRegistrados); @endphp
          <tr class="selectable-row {{ $registrado ? 'row-registrado' : '' }} {{ $seleccionada && $seleccionada->id == $option->id ? 'row-selected' : '' }}"
              data-single="{{ $name }}" data-id="{{ $option->id }}"
              data-nombre="{{ $option->nombre }}" data-subtitle="{{ $option->subtitle ?? '' }}"
              data-detalles="{{ json_encode($option->detalles ?? []) }}"
              data-registrado="{{ $registrado ? '1' : '0' }}"
              onclick="selectSingleEntity(this)">
            <td class="select-check-cell">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6 9 17l-5-5"/>
              </svg>
            </td>
            <td>
              <div class="person-name">{{ $option->nombre }}</div>
              @if(!empty($option->subtitle))
              <div class="person-role">{{ $option->subtitle }}</div>
              @endif
            </td>
            <td class="single-badge-cell">
              @if($registrado)
              <span class="meta-badge">{{ $etiquetaRegistrado }}</span>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- Aviso al hacer clic en alguien ya registrado (lo muestra y oculta el JS) --}}
  <span class="field-error" id="single-notice-{{ $name }}" hidden>{{ $mensajeRegistrado }}</span>

  <input type="hidden" name="{{ $name }}" id="single-value-{{ $name }}" value="{{ $seleccionada ? $seleccionada->id : '' }}">

  {{-- Sin espacios entre las etiquetas cuando está vacío, para que :empty muestre el texto de "nadie seleccionado" --}}
  <div class="selected-entity-list" id="selected-single-{{ $name }}">@if($seleccionada)
    {{-- Pre-renderizado con la MISMA estructura que arma buildSingleCard() en JS --}}
    <div class="selected-entity-card" data-card-id="{{ $seleccionada->id }}">
      <div class="entity-card-head">
        <div class="entity-info">
          <div class="person-name">{{ $seleccionada->nombre }}</div>
          @if(!empty($seleccionada->subtitle))
          <div class="person-role">{{ $seleccionada->subtitle }}</div>
          @endif
        </div>
        <button type="button" class="remove-entity-btn" aria-label="Quitar"
                onclick="clearSingleEntity('{{ $name }}')">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
            <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
          </svg>
        </button>
      </div>
      @if(!empty($seleccionada->detalles))
      <div class="info-grid">
        @foreach($seleccionada->detalles as $etiqueta => $valor)
        <div class="info-field">
          <label>{{ $etiqueta }}</label>
          <div class="value {{ $valor ? '' : 'empty' }}">{{ $valor ?: '-' }}</div>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  @endif</div>

  @error($name) <span class="field-error">{{ $message }}</span> @enderror
</div>