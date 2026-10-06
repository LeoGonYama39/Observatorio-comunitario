@extends('system.app')

@section('title', 'Editar registro de eje')

@section('content')
    @if($eje)
        <div class="breadcrumb">
            <a href="{{ route('ejes.index') }}" data-url="{{ route('ejes.index') }}" class="return-index">
                Ejes
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <a href="{{ route('ejes.show', $eje->id) }}" data-url="{{ route('ejes.show', $eje->id) }}"
               class="return-index">
                {{ $eje->nombre }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <span class="current">
    Editar registro
  </span>
        </div>

        @include('system.parts.alerts.alerts')

        <div class="content-header">
            <div>
                <h1>Editar registro de eje</h1>
                <p>Editar registro para eje {{ $eje->nombre }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('ejes.update', $eje->id) }}">
            @csrf
            @method('PUT')

            <div class="form-card">

                <h3 class="form-section-title">Datos del Eje</h3>
                <div class="form-grid">
                    <div class="form-field">
                        <label>Nombre <span class="required">*</span></label>
                        <input type="text" name="nombre" class="form-input" maxlength="50"
                               value="{{ old('nombre', $eje->nombre) }}" required>
                        @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    @include('system.parts.forms.tag_picker', ['group' => 'responsabilidades', 'label' => 'Responsabilidades a cargo del eje', 'placeholder' => 'Seleccionar…', 'options' => $responsabilidades, 'selected' => $eje->responsabilidades->pluck('id')->toArray()])
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('ejes.show', $eje->id) }}" data-url="{{ route('ejes.show', $eje->id) }}"
                   class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar cambio</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('ejes.index')])
    @endif
@endsection
