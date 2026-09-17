@extends('system.app')

@section('title', 'Nuevo proyecto')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="return-index">
    Proyectos
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Registro nuevo
  </span>
</div>

<div class="content-header">
  <div>
    <h1>Nuevo proyecto</h1>
    <p>Proyectos</p>
  </div>
</div>

<form method="POST" action="{{ route('proyectos.store') }}">
  @csrf
  <div class="form-card">
    <div class="form-grid">
      <div class="form-field">
        <label>Nombre <span class="required">*</span></label>
        <input type="text" name="nombre" class="form-input" value="{{ old('nombre') }}" required>
        @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Estado</label>
        <div class="select-shell">
          <select name="estado" class="form-select">
            <option value="">Sin especificar</option>
            <option value="en_proceso" {{ old('estado') == 'en_proceso' ? 'selected' : '' }}>En proceso</option>
            <option value="concluido" {{ old('estado') == 'concluido' ? 'selected' : '' }}>Concluido</option>
            <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            <option value="pausado" {{ old('estado') == 'pausado' ? 'selected' : '' }}>Pausado</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        @error('estado') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Fecha de inicio <span class="required">*</span></label>
        <input type="date" name="fecha_inicio" class="form-input" value="{{ old('fecha_inicio') }}" required>
        @error('fecha_inicio') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Fecha de fin</label>
        <input type="date" name="fecha_fin" class="form-input" value="{{ old('fecha_fin') }}">
        @error('fecha_fin') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Enlace de repositorio</label>
        <input type="text" name="repo" class="form-input" value="{{ old('repo') }}">
        @error('repo') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Enlace de evidencia para auditoría</label>
        <input type="text" name="auditable" class="form-input" value="{{ old('auditable') }}">
        @error('auditable') <span class="field-error">{{ $message }}</span> @enderror
      </div>

    </div>
    <hr class="form-separator">
    <div class="form-grid form-grid-2col" >
      <div class="form-field">
        <label>Antecedentes</label>
        <textarea name="antecedentes" class="form-textarea textarea-large" rows="5">{{ old('antecedentes') }}</textarea>
        @error('antecedentes') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Objetivos</label>
        <textarea name="objetivos" class="form-textarea textarea-large" rows="5">{{ old('objetivos') }}</textarea>
        @error('objetivos') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Alcance</label>
        <textarea name="alcance" class="form-textarea textarea-large" rows="5">{{ old('alcance') }}</textarea>
        @error('alcance') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Evaluación</label>
        <textarea name="evaluacion" class="form-textarea textarea-large" rows="5">{{ old('evaluacion') }}</textarea>
        @error('evaluacion') <span class="field-error">{{ $message }}</span> @enderror
      </div>
    </div>
    <hr class="form-separator">
    <div class="form-field full-width">
      <label>Población objetivo</label>
      <div class="range-slider" id="poblRangeSlider">
        <div class="range-values">
          <span id="poblLowLabel">3</span> – <span id="poblHighLabel">60+</span>
        </div>
        <div class="range-slider-track">
          <div class="range-slider-fill" id="poblRangeFill"></div>
          <input type="range" min="3" max="60" value="3" id="poblRangeLow" oninput="updatePoblRange()">
          <input type="range" min="3" max="60" value="60" id="poblRangeHigh" oninput="updatePoblRange()">
        </div>
      </div>
      <input type="hidden" name="pobl_obj_low" id="poblObjLow" value="3">
      <input type="hidden" name="pobl_obj_high" id="poblObjHigh" value="60">
    </div>

    <div class="form-checkbox-row">
      <input type="checkbox" id="prioritario" name="prioritario" value="1" {{ old('prioritario') ? 'checked' : '' }}>
      <label for="prioritario">Destacado</label>
    </div>

    <hr class="form-separator">

    <div class="form-field full-width">
      <label>Colonias</label>
      <div class="tag-picker">
        <div class="select-shell">
          <select class="form-select" onchange="addTag(this, 'colonias')">
            <option value="">Seleccionar colonia…</option>
            <option value="la_mexicana">La Mexicana</option>
            <option value="cuevitas">Cuevitas</option>
            <option value="pueblo_nuevo">Pueblo Nuevo</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        <div class="tag-chip-list" id="colonias-list"></div>
      </div>
    </div>

    <div class="form-field full-width">
      <label>Ejes</label>
      <div class="tag-picker">
        <div class="select-shell">
          <select class="form-select" onchange="addTag(this, 'ejes')">
            <option value="">Seleccionar eje…</option>
            <option value="eje_i">Eje I</option>
            <option value="eje_ii">Eje II</option>
            <option value="eje_iii">Eje III</option>
            <option value="eje_iv">Eje IV</option>
            <option value="eje_v">Eje V</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        <div class="tag-chip-list" id="ejes-list"></div>
      </div>
    </div>

    <div class="form-field full-width">
      <label>Problemáticas</label>
      <div class="tag-picker">
        <div class="select-shell">
          <select class="form-select" onchange="addTag(this, 'problematicas')">
            <option value="">Seleccionar problemática…</option>
            <option value="analfabetismo">Analfabetismo</option>
            <option value="diabetes">Diabetes</option>
            <option value="desnutricion">Desnutrición</option>
            <option value="inseguridad">Inseguridad</option>
            <option value="falta_acceso_educacion">Falta de acceso a la educación</option>
            <option value="falta_acceso_salud">Falta de acceso a la salud</option>
            <option value="falta_acceso_servicios">Falta de acceso a servicios básicos</option>
            <option value="inundaciones">Inundaciones constantes</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        <div class="tag-chip-list" id="problematicas-list"></div>
      </div>
    </div>
  </div>

  <div class="form-actions">
    <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="btn-outline">Cancelar</a>
    <button type="submit" class="btn-new">Registrar</button>
  </div>
</form>
@endsection