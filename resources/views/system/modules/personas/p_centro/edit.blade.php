@extends('system.app')

@section('title', 'Editar registro de persona del centro')

@section('content')
    @if ($centro)
        <div class="breadcrumb">
            <a href="{{ route('personas-centro.index') }}" data-url="{{ route('personas-centro.index') }}"
               class="return-index">
                Personas del Centro
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                Editar registro
            </span>
        </div>

        <div class="content-header">
            <div>
                <h1>Editar registro</h1>
                <p>Personas del Centro</p>
            </div>
        </div>

        <form method="POST" action="{{ route('personas-centro.update', $centro->id) }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label>Nombre <span class="required">*</span></label>
                        <input type="text" name="nombre" class="form-input" value="{{ old('nombre', $centro->nombre) }}"
                               required>
                        @error('nombre')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label>Apellido paterno <span class="required">*</span></label>
                        <input type="text" name="ap_pat" class="form-input" value="{{ old('ap_pat', $centro->ap_pat) }}"
                               required>
                        @error('ap_pat')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label>Apellido materno</label>
                        <input type="text" name="ap_mat" class="form-input"
                               value="{{ old('ap_mat', $centro->ap_mat) }}">
                        @error('ap_mat')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label>Cargo</label>
                        <div class="select-shell">
                            <select name="cargo" class="form-select">
                                <option value="">Sin especificar</option>
                                @if (empty($opCargo))
                                    <option value="">Error al buscar las opciones</option>
                                @else
                                    @foreach ($opCargo as $cargo)
                                        <option value="{{ $cargo }}"
                                            {{ old('cargo', $centro->cargo) == $cargo ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $cargo)) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </div>
                        @error('cargo')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <hr class="form-separator">

                <h3 class="form-section-title">Acceso al sistema</h3>

                @if ($centro->usuario)
                    <div class="acceso-fields" id="accesoExistenteFields">
                        <div class="form-grid">
                            <div class="form-field">
                                <label>Usuario<span class="required">*</span></label>
                                <input type="text" name="usuario" class="form-input"
                                       value="{{ old('usuario', $centro->usuario) }}">
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
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
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
                        <input type="checkbox" id="eliminar_acceso" name="eliminar_acceso" value="1" onchange="toggleEliminarAcceso(this)">
                        <label for="eliminar_acceso">Eliminar acceso al sistema</label>
                    </div>
                @else
                    <div class="form-checkbox-row">
                        <input type="checkbox" id="crear_acceso" name="crear_acceso" value="1" onchange="toggleAccesoFields(this)" {{ old('crear_acceso') ? 'checked' : '' }}>
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
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
                                            <circle cx="12" cy="12" r="3" />
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
                <a href="{{ route('personas-centro.show', $centro->id) }}"
                   data-url="{{ route('personas-centro.show', $centro->id) }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Guardar cambios</button>
            </div>
        </form>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7" />
                    <path d="m21 21-4.3-4.3" />
                    <path d="M9 9l4 4" />
                    <path d="M13 9l-4 4" />
                </svg>
            </div>
            <h2>No se encontró ningún resultado</h2>
            <p>No hay información que coincida con lo que buscas.</p>
            <a type="button" class="btn-outline" href="{{ route('personas-centro.index') }}"
               data-url="{{ route('personas-centro.index') }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5" />
                    <path d="M11 18l-6-6 6-6" />
                </svg>
                Regresar
            </a>
        </div>
    @endif
@endsection
