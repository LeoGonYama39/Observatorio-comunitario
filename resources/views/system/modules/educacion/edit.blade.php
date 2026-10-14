{{--
Plantilla edit común para educaciones.
$etiqueta: etiqueta para mostrar el tipo de educación, viene en minúsculas (ej. "educación básica")
$rutaIndex: ruta para ir al index de la educación (ej. route('educ_basica.index'))
$rutaShow: ruta para ir a la vista de detalles de la educación (ej. route('educ_basica.show', $inscripcion['id']))
$rutaUpdate: ruta para enviar el formulario de edición (ej. route('educ_basica.update', $inscripcion['id']))
--}}


@extends('system.app')

@section('title', 'Editar ficha de educación')

@section('content')
    @if($inscripcion)
        <div class="breadcrumb">
            <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="return-index">
                {{ ucfirst($etiqueta) }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="return-index">
                {{ $inscripcion->comunidad->nombre }} {{ $inscripcion->comunidad->ap_pat }} {{ $inscripcion->comunidad->ap_mat ?? '' }}
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
                <h1>Editar {{ $etiqueta }}</h1>
                <p>Editar la información de {{ $inscripcion->comunidad->nombre }} {{ $inscripcion->comunidad->ap_pat }} {{ $inscripcion->comunidad->ap_mat ?? '' }}</p>
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

        <form method="POST" action="{{ $rutaUpdate }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                    <label>RFE</label>
                    <input type="text" name="rfe" class="form-input" maxlength="20" value="{{ old('rfe', $inscripcion->rfe) }}">
                    @error('rfe') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                    <label>CURP</label>
                    <input type="text" name="curp" class="form-input" maxlength="20" value="{{ old('curp', $inscripcion->curp) }}">
                    @error('curp') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                    <label>Matrícula</label>
                    <input type="text" name="matricula" class="form-input" maxlength="20" value="{{ old('matricula', $inscripcion->matricula) }}">
                    @error('matricula') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar cambio</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => $rutaIndex])
    @endif
@endsection
