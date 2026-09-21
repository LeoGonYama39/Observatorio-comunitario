@extends('system.app')

@section('title', 'Nuevo registro de persona del centro')

@section('content')
<div class="breadcrumb">
  <a href="{{ route('personas-centro.index') }}" data-url="{{ route('personas-centro.index') }}" class="return-index">
      Personas Centro
  </a>
  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 6l6 6-6 6"/>
  </svg>
  <span class="current">
    Nuevo registro
  </span>
</div>

@include('system.parts.alerts')

<div class="content-header">
  <div>
    <h1>Nuevo registro</h1>
    <p>Personas del Centro</p>
  </div>
</div>

<form method="POST" action="{{ route('personas-centro.store') }}">
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
        <label>Cargo</label>
        <div class="select-shell">
          <select name="cargo" class="form-select">
            <option value="">Sin especificar</option>
            <option value="coordinador_general" {{ old('cargo') == 'coordinador_general' ? 'selected' : '' }}>Coordinador general</option>
            <option value="asistente_de_coordinación" {{ old('cargo') == 'asistente_de_coordinación' ? 'selected' : '' }}>Asistente de coordinación</option>
            <option value="administración" {{ old('cargo') == 'administración' ? 'selected' : '' }}>Administración</option>
            <option value="recepción" {{ old('cargo') == 'recepción' ? 'selected' : '' }}>Recepción</option>
            <option value="coordinador" {{ old('cargo') == 'coordinador' ? 'selected' : '' }}>Coordinador</option>
            <option value="responsable" {{ old('cargo') == 'responsable' ? 'selected' : '' }}>Responsable</option>
          </select>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </div>
        @error('cargo') <span class="field-error">{{ $message }}</span> @enderror
      </div>
    </div>

    <div class="form-checkbox-row">
      <input type="checkbox" name="crear_acceso" id="crear_acceso" value="1" {{ old('crear_acceso') ? 'checked' : '' }} onchange="toggleAccesoFields(this)">
      <label for="crear_acceso">Crear acceso al sistema</label>
    </div>

    <div class="acceso-fields" id="accesoFields" {{ old('crear_acceso') ? '' : 'hidden' }}>
      <div class="form-grid">
        <div class="form-field">
          <label>Usuario <span class="required">*</span></label>
          <input type="text" name="usuario" class="form-input" value="{{ old('usuario') }}">
          @error('usuario') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
          <label>Contraseña <span class="required">*</span></label>
          <div class="input-shell">
            <input type="password" name="password" id="password_field">
            <button type="button" class="toggle-pass" onclick="togglePasswordField()" aria-label="Mostrar contraseña">
              <svg id="eye-icon-form" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
            </button>
          </div>
          @error('password') <span class="field-error">{{ $message }}</span> @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="form-actions">
    <a href="{{ route('personas-centro.index') }}" data-url="{{ route('personas-centro.index') }}" class="btn-outline">Cancelar</a>
    <button type="submit" class="btn-new">Registrar</button>
  </div>
</form>
@endsection


