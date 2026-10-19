{{--
  Vista para crear nuevo registro en educación.
  Sirve para los create de educación básica y media-superior.
  $rutaIndex: ruta para regresar al index de educación
  $etiqueta: etiqueta para mostrar en el breadcrumb (ej. "Educación básica")
  $rutaStore: ruta para enviar el formulario de creación (ej. route('educ_basica.store'))
--}}

@extends('system.app')

@section('title', 'Editar registro de curso')

@section('content')
    @if ($inscripcion)
        @php
            $comunidad = $inscripcion->inscripcionEducativa->comunidad;
        @endphp
        <div class="breadcrumb">
            <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="return-index">
                {{ ucfirst($etiqueta) }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="return-index">
                {{ $comunidad->nombre }} {{ $comunidad->ap_pat }} {{ $comunidad->ap_mat ?? '' }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                Registro nuevo de curso
            </span>
        </div>

        <div class="content-header">
            <div>
                <h1>Editar registro de curso</h1>
                <p>Registro de curso de {{ ucfirst($etiqueta) }}</p>
            </div>
        </div>

        <form method="POST" action="{{ $rutaStore }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label for="fecha_ingreso">Fecha de ingreso <span class="required">*</span></label>
                        <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-input" value="{{ old('fecha_ingreso', $inscripcion->fecha_ingreso?->format('Y-m-d')) }}">
                        @error('fecha_ingreso')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field">
                        <label>Estado de la inscripción</label>
                        <div class="form-checkbox-row" style="margin-top: 0; padding-top: 0; border-top: none;">
                            <input type="checkbox" id="dado_de_baja" name="dado_de_baja" value="1" {{ old('dado_de_baja', $inscripcion->estado === 'baja') ? 'checked' : '' }} {{ $inscripcion->estado === 'concluido' ? 'disabled' : '' }}>
                            <label for="dado_de_baja">Dado de baja</label>
                        </div>
                        @if ($inscripcion->estado === 'concluido')
                            <small>Curso ya concluido</small>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 24px;">
                <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => $rutaIndex])
    @endif
@endsection
