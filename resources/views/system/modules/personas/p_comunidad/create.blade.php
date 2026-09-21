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
                            <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="no_binario" {{ old('genero') == 'no_binario' ? 'selected' : '' }}>No binario</option>
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
                            <option value="soltero" {{ old('estado_civil') == 'soltero' ? 'selected' : '' }}>Soltero</option>
                            <option value="casado" {{ old('estado_civil') == 'casado' ? 'selected' : '' }}>Casado</option>
                            <option value="divorciado" {{ old('estado_civil') == 'divorciado' ? 'selected' : '' }}>Divorciado</option>
                            <option value="viudo" {{ old('estado_civil') == 'viudo' ? 'selected' : '' }}>Viudo</option>
                            <option value="union_libre" {{ old('estado_civil') == 'union_libre' ? 'selected' : '' }}>Unión libre</option>
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
                            <option value="ninguna" {{ old('nv_escolar') == 'ninguna' ? 'selected' : '' }}>Ninguna</option>
                            <option value="primaria" {{ old('nv_escolar') == 'primaria' ? 'selected' : '' }}>Primaria</option>
                            <option value="secundaria" {{ old('nv_escolar') == 'secundaria' ? 'selected' : '' }}>Secundaria</option>
                            <option value="carrera_tecnica" {{ old('nv_escolar') == 'carrera_tecnica' ? 'selected' : '' }}>Carrera técnica</option>
                            <option value="preparatoria" {{ old('nv_escolar') == 'preparatoria' ? 'selected' : '' }}>Preparatoria</option>
                            <option value="tsu" {{ old('nv_escolar') == 'tsu' ? 'selected' : '' }}>TSU</option>
                            <option value="licenciatura" {{ old('nv_escolar') == 'licenciatura' ? 'selected' : '' }}>Licenciatura</option>
                            <option value="maestria" {{ old('nv_escolar') == 'maestria' ? 'selected' : '' }}>Maestría</option>
                            <option value="doctorado" {{ old('nv_escolar') == 'doctorado' ? 'selected' : '' }}>Doctorado</option>
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
                            <option value="1" {{ old('colonia_id') == '1' ? 'selected' : '' }}>La Mexicana</option>
                            <option value="2" {{ old('colonia_id') == '2' ? 'selected' : '' }}>Cuevitas</option>
                            <option value="3" {{ old('colonia_id') == '3' ? 'selected' : '' }}>Pueblo Nuevo</option>
                            <option value="otro" {{ old('colonia_id') == 'otro' ? 'selected' : '' }}>Otro</option>
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
                            <option value="alvaro_obregon" {{ old('alcaldia') == 'alvaro_obregon' ? 'selected' : '' }}>Álvaro Obregón</option>
                            <option value="azcapotzalco" {{ old('alcaldia') == 'azcapotzalco' ? 'selected' : '' }}>Azcapotzalco</option>
                            <option value="benito_juarez" {{ old('alcaldia') == 'benito_juarez' ? 'selected' : '' }}>Benito Juárez</option>
                            <option value="coyoacan" {{ old('alcaldia') == 'coyoacan' ? 'selected' : '' }}>Coyoacán</option>
                            <option value="cuajimalpa_de_morelos" {{ old('alcaldia') == 'cuajimalpa_de_morelos' ? 'selected' : '' }}>Cuajimalpa de Morelos</option>
                            <option value="cuauhtemoc" {{ old('alcaldia') == 'cuauhtemoc' ? 'selected' : '' }}>Cuauhtémoc</option>
                            <option value="gustavo_a_madero" {{ old('alcaldia') == 'gustavo_a_madero' ? 'selected' : '' }}>Gustavo A. Madero</option>
                            <option value="iztacalco" {{ old('alcaldia') == 'iztacalco' ? 'selected' : '' }}>Iztacalco</option>
                            <option value="iztapalapa" {{ old('alcaldia') == 'iztapalapa' ? 'selected' : '' }}>Iztapalapa</option>
                            <option value="la_magdalena_contreras" {{ old('alcaldia') == 'la_magdalena_contreras' ? 'selected' : '' }}>La Magdalena Contreras</option>
                            <option value="miguel_hidalgo" {{ old('alcaldia') == 'miguel_hidalgo' ? 'selected' : '' }}>Miguel Hidalgo</option>
                            <option value="milpa_alta" {{ old('alcaldia') == 'milpa_alta' ? 'selected' : '' }}>Milpa Alta</option>
                            <option value="tlahuac" {{ old('alcaldia') == 'tlahuac' ? 'selected' : '' }}>Tláhuac</option>
                            <option value="tlalpan" {{ old('alcaldia') == 'tlalpan' ? 'selected' : '' }}>Tlalpan</option>
                            <option value="venustiano_carranza" {{ old('alcaldia') == 'venustiano_carranza' ? 'selected' : '' }}>Venustiano Carranza</option>
                            <option value="xochimilco" {{ old('alcaldia') == 'xochimilco' ? 'selected' : '' }}>Xochimilco</option>
                            <option value="otros" {{ old('alcaldia') == 'otros' ? 'selected' : '' }}>Otros</option>
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
                            <option value="1000_2000" {{ old('ingreso_mensual') == '1000_2000' ? 'selected' : '' }}>$1,000 – $2,000</option>
                            <option value="2500_4000" {{ old('ingreso_mensual') == '2500_4000' ? 'selected' : '' }}>$2,500 – $4,000</option>
                            <option value="4000_5500" {{ old('ingreso_mensual') == '4000_5500' ? 'selected' : '' }}>$4,000 – $5,500</option>
                            <option value="5500_7000" {{ old('ingreso_mensual') == '5500_7000' ? 'selected' : '' }}>$5,500 – $7,000</option>
                            <option value="7000_8500" {{ old('ingreso_mensual') == '7000_8500' ? 'selected' : '' }}>$7,000 – $8,500</option>
                            <option value="8500_10000" {{ old('ingreso_mensual') == '8500_10000' ? 'selected' : '' }}>$8,500 – $10,000</option>
                            <option value="10000_20000" {{ old('ingreso_mensual') == '10000_20000' ? 'selected' : '' }}>$10,000 – $20,000</option>
                            <option value="mas_de_20000" {{ old('ingreso_mensual') == 'mas_de_20000' ? 'selected' : '' }}>Más de $20,000</option>
                            <option value="no_aplica" {{ old('ingreso_mensual') == 'no_aplica' ? 'selected' : '' }}>No aplica</option>
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
                            <option value="familiar" {{ old('tipo_hogar') == 'familiar' ? 'selected' : '' }}>Familiar</option>
                            <option value="prestada" {{ old('tipo_hogar') == 'prestada' ? 'selected' : '' }}>Prestada</option>
                            <option value="propia" {{ old('tipo_hogar') == 'propia' ? 'selected' : '' }}>Propia</option>
                            <option value="rentada" {{ old('tipo_hogar') == 'rentada' ? 'selected' : '' }}>Rentada</option>
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
                            <option value="casa" {{ old('tipo_vivienda') == 'casa' ? 'selected' : '' }}>Casa</option>
                            <option value="departamento" {{ old('tipo_vivienda') == 'departamento' ? 'selected' : '' }}>Departamento</option>
                            <option value="cuarto" {{ old('tipo_vivienda') == 'cuarto' ? 'selected' : '' }}>Cuarto</option>
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
                            <option value="anuncios_impresos">Anuncios impresos en comunidad</option>
                            <option value="centro_meneses">Centro Meneses</option>
                            <option value="conocidos">Conocidos</option>
                            <option value="redes_sociales">Redes sociales (Facebook e Instagram)</option>
                            <option value="familia">Familia</option>
                            <option value="recomendacion_secundarias">Recomendación de secundarias cercanas</option>
                            <option value="whatsapp">WhatsApp</option>
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
                            <option value="abuela">Abuela</option>
                            <option value="abuelo">Abuelo</option>
                            <option value="esposo_a">Esposo/a</option>
                            <option value="hermano_a">Hermano/a</option>
                            <option value="hijo_a">Hijo/a</option>
                            <option value="madre">Madre</option>
                            <option value="padre">Padre</option>
                            <option value="tia">Tía</option>
                            <option value="tio">Tío</option>
                            <option value="soy_proveedor">Soy proveedor económico</option>
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
                            <option value="becas_apoyos">Becas y/o apoyos</option>
                            <option value="conyugue">Cónyuge</option>
                            <option value="familiares">Familiares</option>
                            <option value="pension">Pensión</option>
                            <option value="no_aplica">No aplica</option>
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
                            <option value="imss">IMSS</option>
                            <option value="issste">ISSSTE</option>
                            <option value="centro_salud">Centro de salud</option>
                            <option value="medico_farmacia">Servicio médico de farmacia</option>
                            <option value="medico_privado">Médico privado</option>
                            <option value="medico_militar">Médico militar</option>
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
                            <option value="abuela">Abuela</option>
                            <option value="abuelo">Abuelo</option>
                            <option value="conyugue">Cónyuge</option>
                            <option value="hermanos_as">Hermanos/as</option>
                            <option value="hijos_as">Hijos/as</option>
                            <option value="madre">Madre</option>
                            <option value="padre">Padre</option>
                            <option value="nietos_as">Nietos/as</option>
                            <option value="sobrinos_as">Sobrinos/as</option>
                            <option value="no_aplica">No aplica</option>
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
