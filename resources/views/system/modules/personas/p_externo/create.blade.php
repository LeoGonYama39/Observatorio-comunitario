@extends('system.app')

@section('title', 'Nuevo registro de persona externa')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}" class="return-index">
            Personas Externas
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <span class="current">
    Nuevo registro
  </span>
    </div>
    <div class="content-header">
        <div>
            <h1>Nuevo registro</h1>
            <p>Personas Externas</p>
        </div>
    </div>

    <form method="POST" action="{{ route('personas-externo.store') }}">
        @csrf

        <div class="form-card">
            <div class="form-grid">
                <div class="form-field">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-input" value="{{ old('nombre') }}">
                    @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido paterno <span class="required">*</span></label>
                    <input type="text" name="ap_pat" class="form-input" value="{{ old('ap_pat') }}">
                    @error('ap_pat') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido materno</label>
                    <input type="text" name="ap_mat" class="form-input" value="{{ old('ap_mat') }}">
                    @error('ap_mat') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Universidad</label>
                    <input type="text" name="universidad" class="form-input" value="{{ old('universidad') }}">
                    @error('universidad') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Carrera</label>
                    <input type="text" name="carrera" class="form-input" value="{{ old('carrera') }}">
                    @error('carrera') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Matrícula</label>
                    <input type="text" name="matricula" class="form-input" value="{{ old('matricula') }}">
                    @error('matricula') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Correo</label>
                    <input type="text" name="correo" class="form-input" value="{{ old('correo') }}">
                    @error('correo') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Responsabilidad</label>
                    <div class="select-shell">
                        <select name="responsabilidad_id" class="form-select">
                            <option value="">Sin asignar</option>
                            @if (empty($responsabilidades))
                                <option value="">Error al buscar las opciones</option>
                            @else
                                @foreach($responsabilidades as $responsabilidad)
                                    <option value="{{ $responsabilidad->id }}" {{ old('responsabilidad_id') == $responsabilidad->id ? 'selected' : '' }}>
                                        {{ $responsabilidad->nombre }} @if($responsabilidad->area) ({{ $responsabilidad->area->nombre }}) @endif
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('responsabilidad_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-checkbox-row">
                <input type="checkbox" id="agregar_participacion" name="agregar_participacion" value="1" onchange="toggleParticipacionFields(this)" {{ old('agregar_participacion') ? 'checked' : '' }}>
                <label for="agregar_participacion">Agregar participación</label>
            </div>

            <div class="acceso-fields" id="participacionFields" {{ old('agregar_participacion') ? '' : 'hidden' }}>
                <div class="form-grid">

                    @include('system.parts.forms.enum_select', ['name' => 'temporada', 'label' => 'Temporada', 'options' => $opTemporada, 'obligatorio' => true])

                    <div class="form-field">
                        <label>Año <span class="required">*</span></label>
                        <input type="number" name="anio" class="form-input" value="{{ old('anio') }}">
                        @error('anio') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    @include('system.parts.forms.enum_select', ['name' => 'tipo', 'label' => 'Tipo de participación', 'options' => $opTipo, 'obligatorio' => true])

                    <div class="form-field">
                        <label>Aportación</label>
                        <input type="text" name="aport" class="form-input" value="{{ old('aport') }}">
                        @error('aport') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-checkbox-row">
                <input type="checkbox" name="crear_acceso" id="crear_acceso" value="1"
                       {{ old('crear_acceso') ? 'checked' : '' }} onchange="toggleAccesoFields(this)">
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
                            <button type="button" class="toggle-pass" onclick="togglePasswordField()"
                                    aria-label="Mostrar contraseña">
                                <svg id="eye-icon-form" width="18" height="18" viewBox="0 0 24 24" fill="none"
                                     stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
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
            <a href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Registrar</button>
        </div>
    </form>
@endsection
