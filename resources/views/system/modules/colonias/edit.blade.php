@extends('system.app')

@section('title', 'Editar colonia')

@section('content')
    @if($colonia)
        <div class="breadcrumb">
            <a href="{{ route('colonias.index') }}" data-url="{{ route('colonias.index') }}" class="return-index">
                Colonia
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <a href="{{ route('colonias.show', $colonia->id) }}"
               data-url="{{ route('colonias.show', $colonia->id) }}" class="return-index">
                {{ $colonia->nombre }}
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
                <h1>Editar colonia</h1>
                <p>Editar la información de {{ $colonia->nombre }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('colonias.update', $colonia->id) }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label>Viviendas</label>
                        <input type="number" min="0" max="16777215" name="viviendas" class="form-input"
                               value="{{ old('viviendas', $colonia->viviendas) }}">
                        @error('viviendas') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Adultos</label>
                        <input type="number" min="0" max="16777215" name="adultos" class="form-input"
                               value="{{ old('adultos', $colonia->adultos) }}">
                        @error('adultos') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Niños</label>
                        <input type="number" min="0" max="16777215" name="ninos" class="form-input"
                               value="{{ old('ninos', $colonia->ninos) }}">
                        @error('ninos') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                </div>

                <hr class="form-separator">
                @include('system.parts.forms.tag_picker', ['group' => 'problematicas', 'label' => 'Problemáticas', 'placeholder' => 'Seleccionar…', 'options' => $problematicas, 'selected' => $colonia->problematicas->pluck('id')->toArray()])
            </div>

            <div class="form-actions">
                <a href="{{ route('colonias.show', $colonia->id) }}" data-url="{{ route('colonias.show', $colonia->id) }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar cambio</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('colonias.index')])
    @endif
@endsection
