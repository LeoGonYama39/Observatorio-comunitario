@extends('system.app')

@section('title', 'Crear grupo')

@section('content')
    @if($taller)
        <div class="breadcrumb">
            <a href="{{ route('talleres.index') }}" data-url="{{ route('talleres.index') }}" class="return-index">
                Talleres
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <a href="{{ route('talleres.show', $taller->id) }}" data-url="{{ route('talleres.show', $taller->id) }}" class="return-index">
                {{ $taller->nombre }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
            Nuevo grupo
        </span>
        </div>

        <div class="content-header">
            <div>
                <h1>Nuevo Grupo</h1>
                <p>Crear nuevo grupo para {{ $taller->nombre }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('talleres.gen.store', $taller->id) }}">
            @csrf

            <div class="form-card">
                <div class="form-grid">
                    @include('system.parts.forms.enum_select', ['name' => 'temporada', 'label' => 'Temporada', 'options' => $opTemporada, 'obligatorio' => true])

                    <div class="form-field">
                        <label>Año <span class="required">*</span></label>
                        <input type="number" name="anio" class="form-input" value="{{ old('anio') }}">
                        @error('anio') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Evaluación</label>
                        <textarea name="evaluacion" class="form-textarea textarea-large" rows="5">{{ old('evaluacion') }}</textarea>
                        @error('evaluacion')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('talleres.show', $taller->id) }}" data-url="{{ route('talleres.show', $taller->id) }}"
                   class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('talleres.index')])
    @endif
@endsection
