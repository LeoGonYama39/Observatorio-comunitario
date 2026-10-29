@extends('system.app')

@section('title', 'Editar registro de persona externa')

@section('content')
    @if($externo)
        <div class="breadcrumb">
            <a href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}"
               class="return-index">
                Personas Externas
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <a href="{{ route('personas-externo.show', $externo->id) }}"
               data-url="{{ route('personas-externo.show', $externo->id) }}" class="return-index">
                {{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <span class="current">
    Editar registro
  </span>
        </div>
        <div class="content-header">
            <div>
                <h1>Editar registro</h1>
                <p>Personas Externas</p>
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
        <form method="POST" action="{{ route('personas-externo.update', $externo->id) }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label>Nombre <span class="required">*</span></label>
                        <input type="text" name="nombre" class="form-input"
                               value="{{ old('nombre', $externo->nombre) }}" required>
                        @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Apellido paterno <span class="required">*</span></label>
                        <input type="text" name="ap_pat" class="form-input" value="{{ old('ap_pat', $externo->ap_pat)}}"
                               required>
                        @error('ap_pat') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Apellido materno</label>
                        <input type="text" name="ap_mat" class="form-input"
                               value="{{ old('ap_mat', $externo->ap_mat) }}">
                        @error('ap_mat') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    @include('system.parts.forms.enum_select', ['name' => 'universidad_id', 'label' => 'Universidad', 'options' => $universidades, 'old_option' => $externo->universidad_id, 'usarId' => true])

                    <div class="form-field">
                        <label>Carrera</label>
                        <input type="text" name="carrera" class="form-input"
                               value="{{ old('carrera', $externo->carrera) }}">
                        @error('carrera') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Matrícula</label>
                        <input type="text" name="matricula" class="form-input"
                               value="{{ old('matricula', $externo->matricula) }}">
                        @error('matricula') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Correo</label>
                        <input type="text" name="correo" class="form-input"
                               value="{{ old('correo', $externo->correo) }}">
                        @error('correo') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    @include('system.parts.forms.enum_select', ['name' => 'responsabilidad_id', 'label' => 'Responsabilidad', 'options' => $responsabilidades, 'old_option' => $externo->responsabilidad_id, 'usarId' => true])
                
                </div>
                <hr class="form-separator">

                <h3 class="form-section-title">Acceso al sistema</h3>

                @if ($externo->usuario)
                    <div class="acceso-fields" id="accesoExistenteFields">
                        <div class="form-grid">
                            <div class="form-field">
                                <label>Usuario<span class="required">*</span></label>
                                <input type="text" name="usuario" class="form-input"
                                       value="{{ old('usuario', $externo->usuario) }}">
                                @error('usuario')
                                <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label>Nueva contraseña</label>
                                <div class="input-shell">
                                    <input type="password" name="password" id="password_field"
                                           placeholder="Dejar en blanco para no cambiarla">
                                    <button type="button" class="toggle-pass" onclick="togglePasswordField()"
                                            aria-label="Mostrar contraseña">
                                        <svg id="eye-icon-form" width="18" height="18" viewBox="0 0 24 24"
                                             fill="none" stroke-width="1.8" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-checkbox-row">
                        <input type="checkbox" id="eliminar_acceso" name="eliminar_acceso" value="1"
                               onchange="toggleEliminarAcceso(this)">
                        <label for="eliminar_acceso">Eliminar acceso al sistema</label>
                    </div>
                @else
                    <div class="form-checkbox-row">
                        <input type="checkbox" id="crear_acceso" name="crear_acceso" value="1"
                               onchange="toggleAccesoFields(this)" {{ old('crear_acceso') ? 'checked' : '' }}>
                        <label for="crear_acceso">Crear acceso al sistema</label>
                    </div>

                    <div class="acceso-fields" id="accesoFields" {{ old('crear_acceso') ? '' : 'hidden' }}>
                        <div class="form-grid">
                            <div class="form-field">
                                <label>Usuario <span class="required">*</span></label>
                                <input type="text" name="usuario" class="form-input" value="{{ old('usuario') }}">
                                @error('usuario')
                                <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label>Contraseña <span class="required">*</span></label>
                                <div class="input-shell">
                                    <input type="password" name="password" id="password_field">
                                    <button type="button" class="toggle-pass" onclick="togglePasswordField()"
                                            aria-label="Mostrar contraseña">
                                        <svg id="eye-icon-form" width="18" height="18" viewBox="0 0 24 24"
                                             fill="none" stroke-width="1.8" stroke-linecap="round"
                                             stroke-linejoin="round">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('personas-externo.show', $externo->id) }}" data-url="{{ route('personas-externo.show', $externo->id) }}"
                   class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Guardar cambios</button>
            </div>
        </form>

    @else
        @include('system.parts.alerts.not_found', ['route' => route('personas-externo.index')])
    @endif
@endsection
