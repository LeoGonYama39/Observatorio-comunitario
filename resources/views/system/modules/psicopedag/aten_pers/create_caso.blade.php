@extends('system.app')

@section('title', 'Nuevo expediente para atención individual')

@section('content')
    @if ($expediente)
        @include('system.parts.alerts.alerts')
        <div class="breadcrumb">
            <a href="{{ route('aten_pers.index') }}" data-url="{{ route('aten_pers.index') }}" class="return-index">
                Atención individual
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <a href="{{ route('aten_pers.show', $expediente->id) }}"
                data-url="{{ route('aten_pers.show', $expediente->id) }}" class="return-index">
                {{ $expediente->comunidad->nombre }} {{ $expediente->comunidad->ap_pat }}
                {{ $expediente->comunidad->ap_mat ?? '' }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                Caso nuevo
            </span>
        </div>

        <div class="content-header">
            <div>
                <h1>Caso nuevo</h1>
                <p>Registrar un nuevo caso para el expediente de {{ $expediente->comunidad->nombre }}
                    {{ $expediente->comunidad->ap_pat }} {{ $expediente->comunidad->ap_mat ?? '' }}</p>
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

        <form method="POST" action="{{ route('aten_pers.caso.store', $expediente->id) }}">
            @csrf

            <div class="form-card">
                <h3 class="form-section-title">Nuevo caso</h3>
                <div class="form-grid">
                    <div class="form-field">
                        <label>Fecha de inicio <span class="required">*</span></label>
                        <input type="date" name="init" class="form-input" value="{{ old('init') }}">
                        @error('init')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    @include('system.parts.forms.enum_select', ['name' => 'tipo', 'label' => 'Tipo de atención', 'options' => $tipos, 'obligatorio' => true,])

                    @include('system.parts.forms.enum_select', ['name' => 'estado', 'label' => 'Estado', 'options' => $estados, 'obligatorio' => true,])

                    <div class="form-field">
                        <label>Canalizado</label>
                        <div class="form-checkbox-row" style="margin-top: 0; padding-top: 0; border-top: none;">
                            <input type="checkbox" id="canalizado" name="canalizado" value="1" onchange="toggleCanalizadoField(this)" {{ old('canalizado') ? 'checked' : '' }}>
                            <label for="canalizado">Canalizado</label>
                        </div>
                    </div>

                    <div class="form-field acceso-fields" id="canalizado_site_field" {{ old('canalizado') ? '' : 'hidden' }} style="margin-top: 0px">
                        <label>Canalizado externo a <span class="required">*</span></label>
                        <input type="text" name="canalizado_site" class="form-input" maxlength="255" value="{{ old('canalizado_site') }}">
                        @error('canalizado_site') 
                            <span class="field-error">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>
                <hr class="form-separator">
                <div class="form-field">
                    <label>Petición</label>
                    <textarea name="peticion" class="form-textarea textarea-large" rows="5">{{ old('peticion') }}</textarea>
                    @error('peticion')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
                <hr class="form-separator">
                @include('system.parts.forms.tag_picker', ['group' => 'motivos', 'label' => 'Motivos', 'placeholder' => 'Seleccionar…', 'options' => $motivos])
            </div>

            <div class="form-actions" style="margin-top: 24px;">
                <a href="{{ route('aten_pers.show', $expediente->id) }}"
                    data-url="{{ route('aten_pers.show', $expediente->id) }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar</button>
            </div>
        </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('aten_pers.index')])
    @endif

@endsection
