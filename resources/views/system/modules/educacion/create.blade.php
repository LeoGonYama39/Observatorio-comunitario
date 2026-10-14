{{--
  Vista para crear nuevo registro en educación.
  Sirve para los create de educación básica y media-superior.
  $rutaIndex: ruta para regresar al index de educación
  $etiqueta: etiqueta para mostrar en el breadcrumb (ej. "Educación básica")
  $personasComunidad: lista de personas de la comunidad para seleccionar
  $yaRegistrados: lista de personas que ya están registradas en educación
--}}

@extends('system.app')

@section('title', 'Nuevo registro en educación')

@section('content')
<div class="breadcrumb">
  <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="return-index">
    {{ $etiqueta }}
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
    <p>{{ $etiqueta }}</p>
  </div>
</div>

@if (session('error'))
<div class="form-card" style="border-color:#b3261e; margin-bottom: 16px;">
  <p style="color:#b3261e; margin:0;">{{ session('error') }}</p>
</div>
@endif

@if ($errors->any())
<div class="form-card" style="border-color:#b3261e; margin-bottom: 16px;">
  <ul style="margin:0; padding-left: 18px; color:#b3261e;">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif

<form method="POST" action="{{ route('educacion.store') }}">
  @csrf

  @include('system.parts.forms.single_entity_picker', [
      'name' => 'comunidad_id',
      'label' => 'Persona de la comunidad',
      'options' => $personasComunidad,
      'yaRegistrados' => $yaRegistrados,
      'etiquetaRegistrado' => 'Ya en educación',
      'mensajeRegistrado' => 'Esta persona ya está registrada en educación.',
  ])

  <div class="acceso-fields" data-depende-de="comunidad_id" {{ old('comunidad_id') ? '' : 'hidden' }}>
    <div class="form-card">
      <h3 class="form-section-title">Datos de educación</h3>
      <div class="form-grid">
        <div class="form-field">
          <label>RFE</label>
          <input type="text" name="rfe" class="form-input" maxlength="20" value="{{ old('rfe') }}">
          @error('rfe') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
          <label>CURP</label>
          <input type="text" name="curp" class="form-input" maxlength="20" value="{{ old('curp') }}">
          @error('curp') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-field">
          <label>Matrícula</label>
          <input type="text" name="matricula" class="form-input" maxlength="20" value="{{ old('matricula') }}">
          @error('matricula') <span class="field-error">{{ $message }}</span> @enderror
        </div>
      </div>
    </div>
  </div>

  <div class="form-actions" style="margin-top: 24px;">
    <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="btn-outline">Cancelar</a>
    <button type="submit" class="btn-new">Registrar</button>
  </div>
</form>
@endsection