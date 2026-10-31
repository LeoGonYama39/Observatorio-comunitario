@extends('system.app')

@section('title', 'Agregar registro de seguimiento')

@section('content')
    @if($caso)
        <div class="breadcrumb">
            <a href="{{ route('aten_pers.index') }}" data-url="{{ route('aten_pers.index') }}" class="return-index">
                Atención individual
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <a href="{{ route('aten_pers.show', $caso->expediente->id) }}"
               data-url="{{ route('aten_pers.show', $caso->expediente->id) }}" class="return-index">
                {{ $caso->expediente->comunidad->nombre }} {{ $caso->expediente->comunidad->ap_pat }}
                {{ $caso->expediente->comunidad->ap_mat ?? '' }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <span class="current">
                Registro nuevo de seguimiento
            </span>
        </div>
        @include('system.parts.alerts.alerts')
        <div class="content-header">
            <div>
                <h1>Nuevo registro de seguimiento</h1>
                <p>Agregar un nuevo registro de seguimiento para el caso "{{ str_replace('_', ' ', $caso->tipo) }}"</p>
            </div>
        </div>

        <form method="POST" action="{{ route('aten_pers.seguimiento.store', $caso->id) }}">
            @csrf

            <div class="form-card">
                <h3 class="form-section-title">Datos del seguimiento</h3>
                <div class="form-grid full-width">

                    <div class="form-field">
                        <label>
                            Fecha <span class="required">*</span>
                        </label>
                        <input type="date" name="fecha" class="form-input" value="{{ old('fecha') }}">
                        @error('fecha')<span class="field-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="form-field full-width">
                        <label>
                            Nota <span class="required">*</span>
                        </label>
                        <textarea name="nota" class="form-textarea textarea-large" rows="5">{{ old('nota') }}</textarea>
                        @error('nota')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>
            <div class="entity-picker-grid" style="grid-template-columns: repeat(2, minmax(0, 1fr))">
                @include('system.parts.forms.entity_picker', [
                'tipo' => 'centro',
                'label' => 'Personas del Centro',
                'options' => $personasCentro,
                'selected' => null,
                ])

                @include('system.parts.forms.entity_picker', [
                'tipo' => 'externo',
                'label' => 'Personas Externas',
                'options' => $personasExterno,
                'selected' => null,
                ])
            </div>

            <div class="form-actions">
                <a href="{{ route('aten_pers.show', $caso->expediente->id) }}" data-url="{{ route('aten_pers.show', $caso->expediente->id) }}" class="btn-outline">
                    Cancelar
                </a>
                <button type="submit" class="btn-new">
                    Registrar
                </button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('aten_pers.index'),])
    @endif
@endsection
