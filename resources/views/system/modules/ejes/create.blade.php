@extends('system.app')

@section('title', 'Nuevo registro de eje')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('ejes.index') }}" data-url="{{ route('ejes.index') }}" class="return-index">
            Ejes
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
            <p>Ejes</p>
        </div>
    </div>

    <form method="POST" action="{{ route('ejes.store') }}">
        @csrf

        <div class="form-card">

            <h3 class="form-section-title">Datos del Eje</h3>
            <div class="form-grid">
                <div class="form-field">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-input" maxlength="50" value="{{ old('nombre') }}" required>
                    @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                </div>
                @include('system.parts.tag_picker', ['group' => 'responsabilidades', 'label' => 'Responsabilidades a cargo del eje', 'placeholder' => 'Seleccionar…', 'options' => $responsabilidades])

            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('ejes.index') }}" data-url="{{ route('ejes.index') }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Registrar</button>
        </div>
    </form>
@endsection
