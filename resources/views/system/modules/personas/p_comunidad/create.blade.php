@extends('system.app')

@section('title', 'Nuevo registro de persona usuaria')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}" class="return-index">
    Personas Usuarias
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
    <h1>Nuevo registro</h1>
    <p>Personas Usuarias</p>
  </div>
</div>

<form method="POST" action="{{ route('personas-usuarias.store') }}">
  @csrf

  <div class="form-card">
    <div class="form-grid">
      <div class="form-field">
        <label>Nombre <span class="required">*</span></label>
        <input type="text" name="nombre" class="form-input" value="{{ old('nombre') }}" required>
        @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Apellido paterno <span class="required">*</span></label>
        <input type="text" name="ap_pat" class="form-input" value="{{ old('ap_pat') }}" required>
        @error('ap_pat') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Apellido materno</label>
        <input type="text" name="ap_mat" class="form-input" value="{{ old('ap_mat') }}">
        @error('ap_mat') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Colonia</label>
        <div class="select-shell">
          <select name="colonia_id" class="form-select">
            <option value="">Sin especificar</option>
            <option value="1" {{ old('colonia_id') == '1' ? 'selected' : '' }}>Santa Fe</option>
            <option value="2" {{ old('colonia_id') == '2' ? 'selected' : '' }}>Tepeaca</option>
            <option value="3" {{ old('colonia_id') == '3' ? 'selected' : '' }}>Carlos A. Madrazo</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        @error('colonia_id') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Fecha de nacimiento</label>
        <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date') }}">
        @error('birth_date') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Género</label>
        <div class="select-shell">
          <select name="genero" class="form-select">
            <option value="">Sin especificar</option>
            <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
            <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
            <option value="otro" {{ old('genero') == 'otro' ? 'selected' : '' }}>Otro</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        @error('genero') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Nivel escolar</label>
        <div class="select-shell">
          <select name="nv_escolar" class="form-select">
            <option value="">Sin especificar</option>
            <option value="primaria" {{ old('nv_escolar') == 'primaria' ? 'selected' : '' }}>Primaria</option>
            <option value="secundaria" {{ old('nv_escolar') == 'secundaria' ? 'selected' : '' }}>Secundaria</option>
            <option value="otro" {{ old('nv_escolar') == 'otro' ? 'selected' : '' }}>Otro</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        @error('nv_escolar') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Teléfono</label>
        <input type="text" name="telefono" class="form-input" value="{{ old('telefono') }}">
        @error('telefono') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="form-field">
        <label>Directorio de saberes</label>
        <input type="text" name="saberes" class="form-input" maxlength="255" value="{{ old('saberes') }}">
        @error('saberes') <span class="field-error">{{ $message }}</span> @enderror
      </div>
    </div>

    <div class="form-checkbox-row">
      <input type="checkbox" id="lider" name="lider" value="1" {{ old('lider') ? 'checked' : '' }}>
      <label for="lider">Líder comunitario</label>
    </div>
  </div>

  <div class="form-actions">
    <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}" class="btn-outline">Cancelar</a>
    <button type="submit" class="btn-new">Registrar</button>
  </div>
</form>
@endsection
