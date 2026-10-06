@extends('system.app')

@section('title', 'Editar registro de persona externa')

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
    Editar registro
  </span>
        </div>
        <div class="content-header">
            <div>
                <h1>Editar registro</h1>
                <p>Personas Externas</p>
            </div>
        </div>

        <form method="POST" action="{{ route('personas-externo.update', $externo->id) }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label>Nombre <span class="required">*</span></label>
                        <input type="text" name="nombre" class="form-input"
                               value="{{ old('nombre', $externo->nombre) }}" required>
                        @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Apellido paterno <span class="required">*</span></label>
                        <input type="text" name="ap_pat" class="form-input" value="{{ old('ap_pat', $externo->ap_pat)}}"
                               required>
                        @error('ap_pat') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Apellido materno</label>
                        <input type="text" name="ap_mat" class="form-input"
                               value="{{ old('ap_mat', $externo->ap_mat) }}">
                        @error('ap_mat') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Universidad</label>
                        <input type="text" name="universidad" class="form-input"
                               value="{{ old('universidad', $externo->universidad) }}">
                        @error('universidad') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Carrera</label>
                        <input type="text" name="carrera" class="form-input"
                               value="{{ old('carrera', $externo->carrera) }}">
                        @error('carrera') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Matrícula</label>
                        <input type="text" name="matricula" class="form-input"
                               value="{{ old('matricula', $externo->matricula) }}">
                        @error('matricula') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Correo</label>
                        <input type="text" name="correo" class="form-input"
                               value="{{ old('correo', $externo->correo) }}">
                        @error('correo') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-field">
                        <label>Responsabilidad</label>
                        <div class="select-shell">
                            <select name="responsabilidad_id" class="form-select">
                                <option value="">Sin asignar</option>
                                @if (empty($responsabilidades))
                                    <option value="">Error al buscar las opciones</option>
                                @else
                                    @foreach($responsabilidades as $responsabilidad)
                                        <option value="{{ $responsabilidad->id }}" {{ old('responsabilidad_id', $externo->responsabilidad_id) == $responsabilidad->id ? 'selected' : '' }}>
                                            {{ $responsabilidad->nombre }} @if($responsabilidad->area)
                                                ({{ $responsabilidad->area->nombre }})
                                            @endif
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </div>
                        @error('responsabilidad_id') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('personas-externo.show', $externo->id) }}" data-url="{{ route('personas-externo.show', $externo->id) }}"
                   class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Guardar cambios</button>
            </div>
        </form>

    @else
        @include('system.parts.alerts.not_found', ['route' => route('personas-externo.index')])
    @endif
@endsection
