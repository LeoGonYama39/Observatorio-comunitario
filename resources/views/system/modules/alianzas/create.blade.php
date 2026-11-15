@extends('system.app')

@section('title', 'Nuevo registro de alianza/institución')

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('alianzas.index') }}" data-url="{{ route('alianzas.index') }}" class="return-index">
            Alianzas/Instituciones
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
             stroke-linejoin="round">
            <path d="M9 6l6 6-6 6" />
        </svg>
        <span class="current">
            Nuevo registro
        </span>
    </div>

    @include('system.parts.alerts.alerts')

    <div class="content-header">
        <div>
            <h1>Nuevo registro</h1>
            <p>Alianzas/Instituciones</p>
        </div>
    </div>

    <form method="POST" action="{{ route('alianzas.store') }}">
        @csrf

        <div class="form-card">
            <div class="form-grid">
                <div class="form-field">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-input" value="{{ old('nombre') }}">
                    @error('nombre')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label>Nombre del contacto</label>
                    <input type="text" name="nombre_contacto" class="form-input" value="{{ old('nombre_contacto') }}">
                    @error('nombre_contacto')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label>Área</label>
                    <input type="text" name="area" class="form-input" value="{{ old('area') }}">
                    @error('area')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label>Correo</label>
                    <input type="text" name="correo" class="form-input" value="{{ old('correo') }}">
                    @error('correo')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-input" value="{{ old('telefono') }}">
                    @error('telefono')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="form-checkbox-row">
                <input type="checkbox" name="universidad" id="universidad" value="1"
                    {{ old('universidad') ? 'checked' : '' }}>
                <label for="universidad">Es universidad</label>
                <span class="field-info-tooltip"
                      data-tooltip="Las instituciones marcadas como universidades pueden ser ligadas a las personas externas">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg>
                </span>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('alianzas.index') }}" data-url="{{ route('alianzas.index') }}"
               class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Registrar</button>
        </div>
    </form>
@endsection
