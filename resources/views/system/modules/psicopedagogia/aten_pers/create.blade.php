@extends('system.app')

@section('title', 'Nuevo expediente para atención individual')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('aten_pers.index') }}" data-url="{{ route('aten_pers.index') }}" class="return-index">
            Atención individual
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <path d="M9 6l6 6-6 6" />
        </svg>
        <span class="current">
            Registro nuevo
        </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Nuevo registro</h1>
            <p>Generar un nuevo expediente para persona usuaria</p>
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

    <form method="POST" action="{{ route('aten_pers.store') }}">
        @csrf

        @include('system.parts.forms.single_entity_picker', [
            'name' => 'comunidad_id',
            'label' => 'Persona de la comunidad',
            'options' => $personasComunidad,
            'yaRegistrados' => $yaRegistrados,
            'etiquetaRegistrado' => 'Ya tiene un expediente',
            'mensajeRegistrado' => 'Esta persona ya tiene un expediente abierto.',
        ])

        <div class="acceso-fields" data-depende-de="comunidad_id" {{ old('comunidad_id') ? '' : 'hidden' }}>
            <div class="form-card">
                <h3 class="form-section-title">Datos para expediente</h3>
                <div class="form-grid">
                    <div class="form-field">
                        <label>Contacto de emergencia</label>
                        <input type="text" name="contacto_emergencia" class="form-input"
                            value="{{ old('contacto_emergencia') }}">
                        @error('contacto_emergencia')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 24px;">
            <a href="{{ route('aten_pers.index') }}" data-url="{{ route('aten_pers.index') }}"
                class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Registrar</button>
        </div>
    </form>
@endsection
