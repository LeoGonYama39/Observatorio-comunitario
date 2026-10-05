@extends('system.app')

@section('title', 'Nuevo registro de participación')

@section('content')
    @if($externo)
        <div class="breadcrumb">
            <a href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}"
               class="return-index">
                Personas Externas
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <a href="{{ route('personas-externo.show', $externo->id) }}"
               data-url="{{ route('personas-externo.show', $externo->id) }}" class="return-index">
                {{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <span class="current">
    Nuevo registro de participación
  </span>
        </div>
        @include('system.parts.alerts.alerts')
        <div class="content-header">
            <div>
                <h1>Nuevo registro de participación</h1>
                <p>Nueva participación para {{ $externo->nombre }} {{ $externo->ap_pat }} {{ $externo->ap_mat }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('personas-externo.store_participacion', $externo->id) }}">
            @csrf

            <div class="form-card">
                <div class="form-grid">

                    @include('system.parts.forms.enum_select', ['name' => 'temporada', 'label' => 'Temporada', 'options' => $opTemporada, 'obligatorio' => true])

                    <div class="form-field">
                        <label>Año <span class="required">*</span></label>
                        <input type="number" name="anio" class="form-input" value="{{ old('anio') }}">
                        @error('anio') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    @include('system.parts.forms.enum_select', ['name' => 'tipo', 'label' => 'Tipo de participación', 'options' => $opTipo, 'obligatorio' => true])

                    <div class="form-field">
                        <label>Aportación</label>
                        <input type="text" name="aport" class="form-input" value="{{ old('aport') }}">
                        @error('aport') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('personas-externo.show', $externo->id) }}"
                   data-url="{{ route('personas-externo.show', $externo->id) }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('personas-externo.index')])
    @endif
@endsection
