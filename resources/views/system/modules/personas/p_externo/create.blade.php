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
    Registro nuevo
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
            </div>

            <div class="form-checkbox-row">
                <input type="checkbox" id="agregar_participacion" onchange="toggleParticipacionFields(this)">
                <label for="agregar_participacion">Agregar participación</label>
            </div>

            <div class="acceso-fields" id="participacionFields" hidden>
                <div class="form-grid">
                    <div class="form-field">
                        <label>Temporada <span class="required">*</span></label>
                        <div class="select-shell">
                            <select name="temporada" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="primavera" {{ old('temporada') == 'primavera' ? 'selected' : '' }}>Primavera</option>
                                <option value="otono" {{ old('temporada') == 'otono' ? 'selected' : '' }}>Otoño</option>
                            </select>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </div>
                        @error('temporada') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Año <span class="required">*</span></label>
                        <input type="number" name="anio" class="form-input" value="{{ old('anio') }}">
                        @error('anio') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Tipo de participación <span class="required">*</span></label>
                        <div class="select-shell">
                            <select name="tipo" class="form-select">
                                <option value="">Seleccionar</option>
                                <option value="servicio_social" {{ old('tipo') == 'servicio_social' ? 'selected' : '' }}>Servicio social</option>
                                <option value="voluntariado" {{ old('tipo') == 'voluntariado' ? 'selected' : '' }}>Voluntariado</option>
                            </select>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </div>
                        @error('tipo') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Aportación</label>
                        <input type="text" name="aport" class="form-input" value="{{ old('aport') }}">
                        @error('aport') <span class="field-error">{{ $message }}</span> @enderror
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
