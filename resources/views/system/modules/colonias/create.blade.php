@extends('system.app')

@section('title', 'Nueva colonia')

@section('content')
        <div class="breadcrumb">
            <a href="{{ route('colonias.index') }}" data-url="{{ route('colonias.index') }}" class="return-index">
                Colonia
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <span class="current">
    Nuevo registro
  </span>
        </div>
        @include('system.parts.alerts.alerts')
        <div class="content-header">
            <div>
                <h1>Nueva colonia</h1>
                <p>Registrar una nueva colonia</p>
            </div>
        </div>

        <form method="POST" action="{{ route('colonias.store') }}">
            @csrf

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label>Nombre <span class="required">*</span></label>
                        <input type="text" name="nombre" class="form-input" maxlength="100"
                               value="{{ old('nombre') }}">
                        @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Viviendas</label>
                        <input type="number" name="viviendas" class="form-input"
                               value="{{ old('viviendas') }}">
                        @error('viviendas') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Adultos</label>
                        <input type="number" name="adultos" class="form-input"
                               value="{{ old('adultos') }}">
                        @error('adultos') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Niños</label>
                        <input type="number" name="ninos" class="form-input"
                               value="{{ old('ninos') }}">
                        @error('ninos') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                </div>

                <hr class="form-separator">
                @include('system.parts.forms.tag_picker', ['group' => 'problematicas', 'label' => 'Problemáticas', 'placeholder' => 'Seleccionar…', 'options' => $problematicas])
            </div>

            <div class="form-actions">
                <a href="{{ route('colonias.index') }}" data-url="{{ route('colonias.index') }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar</button>
            </div>
        </form>
@endsection
