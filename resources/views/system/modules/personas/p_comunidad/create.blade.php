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

            <h3 class="form-section-title">Datos personales</h3>
            <div class="form-grid">
                <div class="form-field">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-input" maxlength="40" value="{{ old('nombre') }}" required>
                    @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido paterno <span class="required">*</span></label>
                    <input type="text" name="ap_pat" class="form-input" maxlength="40" value="{{ old('ap_pat') }}" required>
                    @error('ap_pat') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Apellido materno</label>
                    <input type="text" name="ap_mat" class="form-input" maxlength="40" value="{{ old('ap_mat') }}">
                    @error('ap_mat') <span class="field-error">{{ $message }}</span> @enderror
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
                            @if(empty($generos))
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($generos as $genero)
                                    <option value="{{ $genero }}" {{ old('genero') == $genero ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $genero)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('genero') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Estado civil</label>
                    <div class="select-shell">
                        <select name="estado_civil" class="form-select">
                            <option value="">Sin especificar</option>
                            @if(empty($estadoCivil))
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($estadoCivil as $estado)
                                    <option value="{{ $estado }}" {{ old('genero') == $estado ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $estado)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('estado_civil') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Número de hijos</label>
                    <input type="number" min="0" name="num_hijos" class="form-input" value="{{ old('num_hijos') }}">
                    @error('num_hijos') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Nivel escolar</label>
                    <div class="select-shell">
                        <select name="nv_escolar" class="form-select">
                            <option value="">Sin especificar</option>
                            @if(empty($nvEscolar))
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($nvEscolar as $estado)
                                    <option value="{{ $estado }}" {{ old('nv_escolar') == $estado ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $estado)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('nv_escolar') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Ocupación</label>
                    <input type="text" name="ocupacion" class="form-input" maxlength="50" value="{{ old('ocupacion') }}">
                    @error('ocupacion') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Domicilio y contacto</h3>
            <div class="form-grid">
                <div class="form-field full-width">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-input" maxlength="200" value="{{ old('direccion') }}">
                    @error('direccion') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Colonia</label>
                    <div class="select-shell">
                        <select name="colonia_id" class="form-select" onchange="toggleOtroField(this, 'colonia_otro_field')">
                            <option value="">Sin especificar</option>
                            @if($colonias->isEmpty())
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($colonias as $colonia)
                                    <option value="{{ $colonia->id }}" {{ old('colonia_id') == $colonia->nombre ? 'selected' : '' }}>{{ $colonia->nombre }}</option>
                                @endforeach
                            @endif
                            <option value="otros" {{ old('colonia_id') == 'otros' ? 'selected' : '' }}>Otros</option>
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('colonia_id') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field" id="colonia_otro_field" {{ old('colonia_id') == 'otro' ? '' : 'hidden' }}>
                    <label>Especificar colonia</label>
                    <input type="text" name="colonia_otro" class="form-input" maxlength="50" value="{{ old('colonia_otro') }}">
                    @error('colonia_otro') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Alcaldía</label>
                    <div class="select-shell">
                        <select name="alcaldia" class="form-select" onchange="toggleOtroField(this, 'alcaldia_otro_field', 'otros')">
                            <option value="">Sin especificar</option>
                            @if(empty($alcaldia))
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($alcaldia as $estado)
                                    <option value="{{ $estado }}" {{ old('alcaldia') == $estado ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $estado)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('alcaldia') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field" id="alcaldia_otro_field" {{ old('alcaldia') == 'otros' ? '' : 'hidden' }}>
                    <label>Especificar alcaldía</label>
                    <input type="text" name="alcaldia_otro" class="form-input" maxlength="50" value="{{ old('alcaldia_otro') }}">
                    @error('alcaldia_otro') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Teléfono de casa</label>
                    <input type="text" name="telefono_casa" class="form-input" maxlength="20" value="{{ old('telefono_casa') }}">
                    @error('telefono_casa') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Teléfono celular</label>
                    <input type="text" name="telefono_celular" class="form-input" maxlength="20" value="{{ old('telefono_celular') }}">
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
                <div class="form-field">
                    <label>Ingreso mensual</label>
                    <div class="select-shell">
                        <select name="ingreso_mensual" class="form-select">
                            <option value="">Sin especificar</option>
                            @if(empty($ingresoMensual))
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($ingresoMensual as $estado)
                                    <option value="{{ $estado }}" {{ old('ingreso_mensual') == $estado ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $estado)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('ingreso_mensual') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Tipo de hogar</label>
                    <div class="select-shell">
                        <select name="tipo_hogar" class="form-select">
                            <option value="">Sin especificar</option>
                            @if(empty($tipoHogar))
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($tipoHogar as $estado)
                                    <option value="{{ $estado }}" {{ old('tipo_hogar') == $estado ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $estado)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('tipo_hogar') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Tipo de vivienda</label>
                    <div class="select-shell">
                        <select name="tipo_vivienda" class="form-select">
                            <option value="">Sin especificar</option>
                            @if(empty($tipoVivienda))
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($tipoVivienda as $estado)
                                    <option value="{{ $estado }}" {{ old('tipo_vivienda') == $estado ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $estado)) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    @error('tipo_vivienda') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Habitantes menores de 18</label>
                    <input type="number" min="0" name="habitantes_menos_18" class="form-input" value="{{ old('habitantes_menos_18') }}">
                    @error('habitantes_menos_18') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Habitantes mayores de 18</label>
                    <input type="number" min="0" name="habitantes_mas_18" class="form-input" value="{{ old('habitantes_mas_18') }}">
                    @error('habitantes_mas_18') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Habitantes mayores de 60</label>
                    <input type="number" min="0" name="habitantes_mas_60" class="form-input" value="{{ old('habitantes_mas_60') }}">
                    @error('habitantes_mas_60') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <hr class="form-separator">

            <h3 class="form-section-title">Redes de apoyo y servicios</h3>

            <div class="form-field full-width">
                <label>¿Cómo se enteró del centro? (Difusión)</label>
                <div class="tag-picker">
                    <div class="select-shell">
                        <select class="form-select" onchange="addTag(this, 'difusion')">
                            <option value="">Seleccionar…</option>
                            @if($difuciones->isEmpty())
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($difuciones as $difucion)
                                    <option value="{{ $difucion->nombre }}">{{ $difucion->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    <div class="tag-chip-list" id="difusion-list"></div>
                </div>
            </div>

            <div class="form-field full-width">
                <label>Parentesco de quien provee el sustento económico</label>
                <div class="tag-picker">
                    <div class="select-shell">
                        <select class="form-select" onchange="addTag(this, 'sustento')">
                            <option value="">Seleccionar…</option>
                            @if($sustentos->isEmpty())
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($sustentos as $sustento)
                                    <option value="{{ $sustento->nombre }}">{{ $sustento->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    <div class="tag-chip-list" id="sustento-list"></div>
                </div>
            </div>

            <div class="form-field full-width">
                <label>En caso de no trabajar, ¿cómo obtiene sus ingresos?</label>
                <div class="tag-picker">
                    <div class="select-shell">
                        <select class="form-select" onchange="addTag(this, 'no_trabaja')">
                            <option value="">Seleccionar…</option>
                            @if($noTrabaja->isEmpty())
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($noTrabaja as $opciones)
                                    <option value="{{ $opciones->nombre }}">{{ $opciones->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    <div class="tag-chip-list" id="no_trabaja-list"></div>
                </div>
            </div>

            <div class="form-field full-width">
                <label>Servicio médico al que recurre</label>
                <div class="tag-picker">
                    <div class="select-shell">
                        <select class="form-select" onchange="addTag(this, 'servicio_medico')">
                            <option value="">Seleccionar…</option>
                            @if($serviciosMedicos->isEmpty())
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($serviciosMedicos as $serviciosMedico)
                                    <option value="{{ $serviciosMedico->nombre }}">{{ $serviciosMedico->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    <div class="tag-chip-list" id="servicio_medico-list"></div>
                </div>
            </div>

            <div class="form-field full-width">
                <label>¿Cuántas personas dependen de usted?</label>
                <div class="tag-picker">
                    <div class="select-shell">
                        <select class="form-select" onchange="addTag(this, 'personas_dependen')">
                            <option value="">Seleccionar…</option>
                            @if($personasDependen->isEmpty())
                                <option value="">Error al encontrar las opciones</option>
                            @else
                                @foreach($personasDependen as $personas)
                                    <option value="{{ $personas->nombre }}">{{ $personas->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    <div class="tag-chip-list" id="personas_dependen-list"></div>
                </div>
            </div>

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
@endsection
