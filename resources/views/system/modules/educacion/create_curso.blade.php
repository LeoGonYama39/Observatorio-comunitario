{{--
  Vista para crear nuevo registro en educación.
  Sirve para los create de educación básica y media-superior.
  $rutaIndex: ruta para regresar al index de educación
  $etiqueta: etiqueta para mostrar en el breadcrumb (ej. "Educación básica")
  $rutaStore: ruta para enviar el formulario de creación (ej. route('educ_basica.store'))
--}}

@extends('system.app')

@section('title', 'Nuevo registro de curso')

@section('content')
    @if ($inscripcion)
        @php
            $comunidad = $inscripcion->comunidad;
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
                <h1>Nuevo registro de curso</h1>
                <p>Registro de curso de {{ ucfirst($etiqueta) }}</p>
            </div>
        </div>

        <form method="POST" action="{{ $rutaStore }}">
            @csrf

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label>Fecha de ingreso <span class="required">*</span></label>
                        <input type="date" name="fecha_ingreso" class="form-input" value="{{ old('fecha_ingreso') }}">
                        @error('fecha_ingreso')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label>Curso <span class="required">*</span></label>
                        <div class="select-shell">
                            <select name="cursos_id" class="form-select">
                                <option value="">Sin especificar</option>
                                @foreach ($cursos as $curso)
                                    <option value="{{ $curso->id }}"
                                        {{ (string) old('cursos_id') === (string) $curso->id ? 'selected' : '' }}>
                                        {{ $curso->nombre }}</option>
                                @endforeach
                            </select>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </div>
                        @error('cursos_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top: 24px;">
                <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => $rutaIndex])
    @endif
@endsection
