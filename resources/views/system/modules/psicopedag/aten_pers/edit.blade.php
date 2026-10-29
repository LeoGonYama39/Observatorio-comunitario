@extends('system.app')

@section('title', 'Editar expediente')

@section('content')
    @if($expediente)
    <div class="breadcrumb">
        <a href="{{ route('aten_pers.index') }}" data-url="{{ route('aten_pers.index') }}" class="return-index">
            Atención individual
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <a href="{{ route('aten_pers.show', $expediente->id) }}" data-url="{{ route('aten_pers.show', $expediente->id) }}" class="return-index">
            {{ $expediente->comunidad->nombre }} {{ $expediente->comunidad->ap_pat }} {{ $expediente->comunidad->ap_mat ?? '' }}
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <span class="current">
    Editar expediente
  </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Editar expediente</h1>
            <p>Editar expediente y tutores para {{ $expediente->comunidad->nombre }} {{ $expediente->comunidad->ap_pat }} {{ $expediente->comunidad->ap_mat ?? '' }}</p>
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

    <form method="POST" action="{{ route('aten_pers.update', $expediente->id) }}">
        @csrf
        @method('PUT')
        
        <h3 class="form-section-title">Datos generales</h3>
        <div class="form-card">
                <h3 class="form-section-title">Datos para expediente</h3>
                <div class="form-grid">
                    <div class="form-field">
                        <label>Contacto de emergencia</label>
                        <input type="text" name="contacto_emergencia" class="form-input" value="{{ old('contacto_emergencia', $expediente->contacto_emergencia) }}">
                        @error('contacto_emergencia')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

        <div class="entity-picker-grid" data-roles-proyecto="{{ json_encode($parentescoOpciones) }}">
            @include('system.parts.forms.entity_picker', [
            'tipo' => 'tutores',
            'label' => 'Tutores',
            'options' => $personasComunidad,
            'selected' => $seleccionados,
            'roles' => $parentescoOpciones,
            ])
        </div>
        @error('roles_tutores.*')<span class="field-error">{{ $message }}</span>@enderror

        <div class="form-actions" style="margin-top: 20px">
            <a href="{{ route('aten_pers.show', $expediente->id) }}" data-url="{{ route('aten_pers.show', $expediente->id) }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Guardar cambios</button>
        </div>
    </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('aten_pers.index')])
    @endif
@endsection
