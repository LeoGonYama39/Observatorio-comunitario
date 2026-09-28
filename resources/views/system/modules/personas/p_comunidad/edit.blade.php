@extends('system.app')

@section('title', 'Nuevo registro de persona usuaria')

@section('content')
    @if($usuaria)
    @php
        // Los rangos de ingreso se muestran como "1000 - 2000"; el resto, como texto normal
        $formatIngreso = fn ($v) => preg_match('/^\d+_\d+$/', $v)
            ? str_replace('_', ' - ', $v)
            : \Illuminate\Support\Str::ucfirst(str_replace('_', ' ', $v));
    @endphp

    <div class="breadcrumb">
        <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}" class="return-index">
            Personas Usuarias
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <a href="{{ route('personas-usuarias.show', $usuaria->id) }}" data-url="{{ route('personas-usuarias.show', $usuaria->id) }}" class="return-index">
            {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat ?? '' }}
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <span class="current">
    Editar registro
  </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Editar registro</h1>
            <p>Editar registro de {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat ?? '' }}</p>
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

    <form method="POST" action="{{ route('personas-usuarias.update', $usuaria->id) }}">
        @csrf

        <div class="form-card">

            <h3 class="form-section-title">Datos personales</h3>
            <div class="form-grid">
                <div class="form-field">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-input" maxlength="40" value="{{ old('nombre', $usuaria->nombre) }}" required>
                    @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido paterno <span class="required">*</span></label>
                    <input type="text" name="ap_pat" class="form-input" maxlength="40" value="{{ old('ap_pat', $usuaria->ap_pat) }}" required>
                    @error('ap_pat') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido materno</label>
                    <input type="text" name="ap_mat" class="form-input" maxlength="40" value="{{ old('ap_mat', $usuaria->ap_mat) }}">
                    @error('ap_mat') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date', $usuaria->birth_date) }}">
                    @error('birth_date') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                @include('system.parts.enum_select', ['name' => 'genero', 'label' => 'Género', 'options' => $generos, 'old_option' => $usuaria->genero])
                @include('system.parts.enum_select', ['name' => 'estado_civil', 'label' => 'Estado civil', 'options' => $estadoCivil, 'old_option' => $usuaria->estado_civil])

                <div class="form-field">
                    <label>Número de hijos</label>
                    <input type="number" min="0" max="255" name="num_hijos" class="form-input" value="{{ old('num_hijos', $usuaria->num_hijos) }}">
                    @error('num_hijos') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                @include('system.parts.enum_select', ['name' => 'nv_escolar', 'label' => 'Nivel escolar', 'options' => $nvEscolar, 'old_option' => $usuaria->nv_escolar])

                <div class="form-field">
                    <label>Ocupación</label>
                    <input type="text" name="ocupacion" class="form-input" maxlength="50" value="{{ old('ocupacion', $usuaria->ocupacion) }}">
                    @error('ocupacion') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Domicilio y contacto</h3>
            <div class="form-grid">
                <div class="form-field full-width">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-input" maxlength="200" value="{{ old('direccion', $usuaria->direccion) }}">
                    @error('direccion') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Colonia</label>
                    <div class="select-shell">
                        <select name="colonia_id" class="form-select" onchange="toggleOtroField(this, 'colonia_otro_field', 'otro')">
                            <option value="">Sin especificar</option>
                            @foreach($colonias as $colonia)
                                <option value="{{ $colonia->id }}" {{ (string) old('colonia_id', $usuaria->colonia_id) === (string) $colonia->id ? 'selected' : '' }}>{{ $colonia->nombre }}</option>
                            @endforeach
                            <option value="otro" {{ old('colonia_id', $usuaria->colonia_id === null && $usuaria->colonia_otro ? 'otro' : '') === 'otro' ? 'selected' : '' }}>
                                Otro
                            </option>
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('colonia_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field" id="colonia_otro_field"
                    {{ old('colonia_id', $usuaria->colonia_id === null && $usuaria->colonia_otro ? 'otro' : '') === 'otro' ? '' : 'hidden' }}>
                    <label>Especificar colonia</label>
                    <input type="text" name="colonia_otro" class="form-input" maxlength="50" value="{{ old('colonia_otro', $usuaria->colonia_otro) }}">
                    @error('colonia_otro') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                @include('system.parts.enum_select', [
                    'name' => 'alcaldia',
                    'label' => 'Alcaldía',
                    'options' => $alcaldia,
                    'onchange' => "toggleOtroField(this, 'alcaldia_otro_field', 'otros')",
                    'old_option' => $usuaria->alcaldia,
                ])

                <div class="form-field" id="alcaldia_otro_field"
                    {{ old('alcaldia', $usuaria->alcaldia) === 'otros' ? '' : 'hidden' }}>
                    <label>Especificar alcaldía</label>
                    <input type="text" name="alcaldia_otro" class="form-input" maxlength="50" value="{{ old('alcaldia_otro', $usuaria->alcaldia_otro) }}">
                    @error('alcaldia_otro') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Teléfono de casa</label>
                    <input type="text" name="telefono_casa" class="form-input" maxlength="20" value="{{ old('telefono_casa', $usuaria->telefono_casa) }}">
                    @error('telefono_casa') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Teléfono celular</label>
                    <input type="text" name="telefono_celular" class="form-input" maxlength="20" value="{{ old('telefono_celular', $usuaria->telefono_celular) }}">
                    @error('telefono_celular') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Correo</label>
                    <input type="text" name="correo" class="form-input" maxlength="100" value="{{ old('correo', $usuaria->correo) }}">
                    @error('correo') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Vivienda y economía</h3>
            <div class="form-grid">
                @include('system.parts.enum_select', ['name' => 'ingreso_mensual', 'label' => 'Ingreso mensual', 'options' => $ingresoMensual, 'format' => $formatIngreso, 'old_option' => $usuaria->ingreso_mensual])
                @include('system.parts.enum_select', ['name' => 'tipo_hogar', 'label' => 'Tipo de hogar', 'options' => $tipoHogar, 'old_option' => $usuaria->tipo_hogar])
                @include('system.parts.enum_select', ['name' => 'tipo_vivienda', 'label' => 'Tipo de vivienda', 'options' => $tipoVivienda, 'old_option' => $usuaria->tipo_vivienda])

                <div class="form-field">
                    <label>Habitantes menores de 18</label>
                    <input type="number" min="0" max="255" name="habitantes_menos_18" class="form-input" value="{{ old('habitantes_menos_18', $usuaria->habitantes_menos_18) }}">
                    @error('habitantes_menos_18') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Habitantes mayores de 18</label>
                    <input type="number" min="0" max="255" name="habitantes_mas_18" class="form-input" value="{{ old('habitantes_mas_18', $usuaria->habitantes_mas_18) }}">
                    @error('habitantes_mas_18') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Habitantes mayores de 60</label>
                    <input type="number" min="0" max="255" name="habitantes_mas_60" class="form-input" value="{{ old('habitantes_mas_60', $usuaria->habitantes_mas_60) }}">
                    @error('habitantes_mas_60') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Redes de apoyo y servicios</h3>

            @include('system.parts.tag_picker', ['group' => 'difusion', 'label' => '¿Cómo se enteró del centro? (Difusión)', 'placeholder' => 'Seleccionar…', 'options' => $difuciones])
            @include('system.parts.tag_picker', ['group' => 'sustento', 'label' => 'Parentesco de quien provee el sustento económico', 'placeholder' => 'Seleccionar…', 'options' => $sustentos])
            @include('system.parts.tag_picker', ['group' => 'no_trabaja', 'label' => 'En caso de no trabajar, ¿cómo obtiene sus ingresos?', 'placeholder' => 'Seleccionar…', 'options' => $noTrabaja   ])
            @include('system.parts.tag_picker', ['group' => 'servicio_medico', 'label' => 'Servicio médico al que recurre', 'placeholder' => 'Seleccionar…', 'options' => $serviciosMedicos, 'selected' => $usuaria->serviciosMedicos->pluck('id')->toArray(),])
            @include('system.parts.tag_picker', ['group' => 'personas_dependen', 'label' => '¿Cuántas personas dependen de usted?', 'placeholder' => 'Seleccionar…', 'options' => $personasDependen])

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
            <a href="{{ route('personas-usuarias.index') }}" data-url="{{ route('personas-usuarias.index') }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Registrar</button>
        </div>
    </form>
    @else
        @include('system.parts.not_found', ['route' => route('personas-usuarias.index')])
    @endif
@endsection
