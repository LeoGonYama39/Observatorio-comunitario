@extends('system.app')

@section('title', 'Nuevo registro de persona usuaria')

@section('content')
    @php
        // Los rangos de ingreso se muestran como "1000 - 2000"; el resto, como texto normal
        $formatIngreso = fn ($v) => preg_match('/^\d+_\d+$/', $v)
            ? str_replace('_', ' - ', $v)
            : \Illuminate\Support\Str::ucfirst(str_replace('_', ' ', $v));
    @endphp

    <div class="breadcrumb">
        <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}"
           class="return-index">
            Personas Usuarias
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round">
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

            <h3 class="form-section-title">Datos personales</h3>
            <div class="form-grid">
                <div class="form-field">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-input" maxlength="40" value="{{ old('nombre') }}"
                           required>
                    @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido paterno <span class="required">*</span></label>
                    <input type="text" name="ap_pat" class="form-input" maxlength="40" value="{{ old('ap_pat') }}"
                           required>
                    @error('ap_pat') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido materno</label>
                    <input type="text" name="ap_mat" class="form-input" maxlength="40" value="{{ old('ap_mat') }}">
                    @error('ap_mat') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Fecha de nacimiento <span class="required">*</span></label>
                    <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date') }}">
                    @error('birth_date') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                @include('system.parts.forms.enum_select', ['name' => 'genero', 'label' => 'Género', 'options' => $generos, 'obligatorio' => true])
                @include('system.parts.forms.enum_select', ['name' => 'estado_civil', 'label' => 'Estado civil', 'options' => $estadoCivil])

                <div class="form-field">
                    <label>Número de hijos</label>
                    <input type="number" min="0" max="255" name="num_hijos" class="form-input"
                           value="{{ old('num_hijos') }}">
                    @error('num_hijos') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                @include('system.parts.forms.enum_select', ['name' => 'nv_escolar', 'label' => 'Nivel escolar', 'options' => $nvEscolar])

                <div class="form-field">
                    <label>Ocupación</label>
                    <input type="text" name="ocupacion" class="form-input" maxlength="50"
                           value="{{ old('ocupacion') }}">
                    @error('ocupacion') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Registro de periodo</h3>

            <div class="form-grid">
                @include('system.parts.forms.enum_select', ['name' => 'temporada', 'label' => 'Temporada', 'options' => $opTemporada, 'obligatorio' => true])

                <div class="form-field">
                    <label>Año <span class="required">*</span></label>
                    <input type="number" name="anio" class="form-input" value="{{ old('anio') }}">
                    @error('anio') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Domicilio y contacto</h3>
            <div class="form-grid">
                <div class="form-field full-width">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-input" maxlength="200"
                           value="{{ old('direccion') }}">
                    @error('direccion') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Colonia <span class="required">*</span></label>
                    <div class="select-shell">
                        <select name="colonia_id" class="form-select"
                                onchange="toggleOtroField(this, 'colonia_otro_field', 'otro')">
                            <option value="">Sin especificar</option>
                            @foreach($colonias as $colonia)
                                <option value="{{ $colonia->id }}" {{ (string) old('colonia_id') === (string) $colonia->id ? 'selected' : '' }}>{{ $colonia->nombre }}</option>
                            @endforeach
                            <option value="otro" {{ old('colonia_id') === 'otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('colonia_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field" id="colonia_otro_field" {{ old('colonia_id') === 'otro' ? '' : 'hidden' }}>
                    <label>Especificar colonia <span class="required">*</span></label>
                    <input type="text" name="colonia_otro" class="form-input" maxlength="50"
                           value="{{ old('colonia_otro') }}">
                    @error('colonia_otro') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                @include('system.parts.forms.enum_select', [
                    'name' => 'alcaldia',
                    'label' => 'Alcaldía',
                    'options' => $alcaldia,
                    'onchange' => "toggleOtroField(this, 'alcaldia_otro_field', 'otro')",
                ])

                <div class="form-field" id="alcaldia_otro_field" {{ old('alcaldia') === 'otro' ? '' : 'hidden' }}>
                    <label>Especificar alcaldía</label>
                    <input type="text" name="alcaldia_otro" class="form-input" maxlength="50"
                           value="{{ old('alcaldia_otro') }}">
                    @error('alcaldia_otro') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Teléfono de casa</label>
                    <input type="text" name="telefono_casa" class="form-input" maxlength="20"
                           value="{{ old('telefono_casa') }}">
                    @error('telefono_casa') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Teléfono celular</label>
                    <input type="text" name="telefono_celular" class="form-input" maxlength="20"
                           value="{{ old('telefono_celular') }}">
                    @error('telefono_celular') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Correo</label>
                    <input type="text" name="correo" class="form-input" maxlength="100" value="{{ old('correo') }}">
                    @error('correo') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Vivienda y economía</h3>
            <div class="form-grid">
                @include('system.parts.forms.enum_select', ['name' => 'ingreso_mensual', 'label' => 'Ingreso mensual', 'options' => $ingresoMensual, 'format' => $formatIngreso])
                @include('system.parts.forms.enum_select', ['name' => 'tipo_hogar', 'label' => 'Tipo de hogar', 'options' => $tipoHogar])
                @include('system.parts.forms.enum_select', ['name' => 'tipo_vivienda', 'label' => 'Tipo de vivienda', 'options' => $tipoVivienda])

                <div class="form-field">
                    <label>Habitantes menores de 18</label>
                    <input type="number" min="0" max="255" name="habitantes_menos_18" class="form-input"
                           value="{{ old('habitantes_menos_18') }}">
                    @error('habitantes_menos_18') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Habitantes mayores de 18</label>
                    <input type="number" min="0" max="255" name="habitantes_mas_18" class="form-input"
                           value="{{ old('habitantes_mas_18') }}">
                    @error('habitantes_mas_18') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Habitantes mayores de 60</label>
                    <input type="number" min="0" max="255" name="habitantes_mas_60" class="form-input"
                           value="{{ old('habitantes_mas_60') }}">
                    @error('habitantes_mas_60') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Redes de apoyo y servicios</h3>

            @include('system.parts.forms.tag_picker', ['group' => 'difusion', 'label' => '¿Cómo se enteró del centro? (Difusión)', 'placeholder' => 'Seleccionar…', 'options' => $difuciones])
            @include('system.parts.forms.tag_picker', ['group' => 'sustento', 'label' => 'Parentesco de quien provee el sustento económico', 'placeholder' => 'Seleccionar…', 'options' => $sustentos])
            @include('system.parts.forms.tag_picker', ['group' => 'no_trabaja', 'label' => 'En caso de no trabajar, ¿cómo obtiene sus ingresos?', 'placeholder' => 'Seleccionar…', 'options' => $noTrabaja   ])
            @include('system.parts.forms.tag_picker', ['group' => 'servicio_medico', 'label' => 'Servicio médico al que recurre', 'placeholder' => 'Seleccionar…', 'options' => $serviciosMedicos])
            @include('system.parts.forms.tag_picker', ['group' => 'personas_dependen', 'label' => '¿Cuántas personas dependen de usted?', 'placeholder' => 'Seleccionar…', 'options' => $personasDependen])

            <hr class="form-separator">

            <h3 class="form-section-title">Otros</h3>
            <div class="form-grid">
                <div class="form-field full-width">
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
            <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}"
               class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Registrar</button>
        </div>
    </form>

@endsection
