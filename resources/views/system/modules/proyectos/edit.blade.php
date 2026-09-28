@extends('system.app')

@section('title', 'Nuevo proyecto')

@section('content')
    @if($proyecto)
    <div class="breadcrumb">
        <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="return-index">
            Proyectos
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <a href="{{ route('proyectos.show', $proyecto->id) }}" data-url="{{ route('proyectos.show', $proyecto->id) }}" class="return-index">
            {{ $proyecto->nombre }}
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <span class="current">
    Editar registro
  </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Editar proyecto</h1>
            <p>Editar la información de {{ $proyecto->nombre }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('proyectos.update', $proyecto->id) }}">
        @csrf
        @method('PUT')

        <div class="form-card">
            <div class="form-grid">
                <div class="form-field">
                    <label>Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-input" maxlength="50" value="{{ old('nombre', $proyecto->nombre) }}" required>
                    @error('nombre') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                @include('system.parts.enum_select', ['name' => 'estado', 'label' => 'Estado', 'options' => $estado, 'obligatorio' => true, 'old_option' => $proyecto->estado])

                <div class="form-field">
                    <label>Fecha de inicio <span class="required">*</span></label>
                    <input type="date" name="fecha_inicio" class="form-input" value="{{ old('fecha_inicio', $proyecto->fecha_inicio?->format('Y-m-d')) }}" required>
                    @error('fecha_inicio') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Fecha de fin</label>
                    <input type="date" name="fecha_fin" class="form-input"  value="{{ old('fecha_fin', $proyecto->fecha_fin?->format('Y-m-d')) }}">
                    @error('fecha_fin') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Enlace de repositorio</label>
                    <input type="text" name="repo" class="form-input" maxlength="2048" value="{{ old('repo', $proyecto->repo) }}">
                    @error('repo') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Enlace de evidencia para auditoría</label>
                    <input type="text" name="auditable" class="form-input" maxlength="2048" value="{{ old('auditable', "$proyecto->auditable") }}">
                    @error('auditable') <span class="field-error">{{ $message }}</span> @enderror
                </div>

            </div>
            <hr class="form-separator">
            <div class="form-grid form-grid-2col" >
                <div class="form-field">
                    <label>Antecedentes</label>
                    <textarea name="antecedentes" class="form-textarea textarea-large" rows="5">{{ old('antecedentes', $proyecto->antecedentes) }}</textarea>
                    @error('antecedentes') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Objetivos</label>
                    <textarea name="objetivos" class="form-textarea textarea-large" rows="5">{{ old('objetivos', $proyecto->objetivos) }}</textarea>
                    @error('objetivos') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Alcance</label>
                    <textarea name="alcance" class="form-textarea textarea-large" rows="5">{{ old('alcance', $proyecto->alcance) }}</textarea>
                    @error('alcance') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Evaluación</label>
                    <textarea name="evaluacion" class="form-textarea textarea-large" rows="5">{{ old('evaluacion', $proyecto->evaluacion) }}</textarea>
                    @error('evaluacion') <span class="field-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <hr class="form-separator">
            <div class="form-field full-width">
                <label>Población objetivo</label>
                <div class="range-slider" id="poblRangeSlider">
                    <div class="range-values">
                        <span id="poblLowLabel">3</span> – <span id="poblHighLabel">60+</span>
                    </div>
                    <div class="range-slider-track">
                        <div class="range-slider-fill" id="poblRangeFill"></div>
                        <input type="range" min="3" max="60"
                               value="{{ old('pobl_obj_low', $proyecto->pobl_obj_low ?? 3) }}"
                               id="poblRangeLow" oninput="updatePoblRange()">
                        <input type="range" min="3" max="60"
                               value="{{ old('pobl_obj_high', $proyecto->pobl_obj_high ?? 60) }}"
                               id="poblRangeHigh" oninput="updatePoblRange()">
                    </div>
                </div>
                <input type="hidden" name="pobl_obj_low" id="poblObjLow" value="3">
                <input type="hidden" name="pobl_obj_high" id="poblObjHigh" value="60">
            </div>

            <div class="form-checkbox-row">
                <input type="checkbox" id="prioritario" name="prioritario" value="1" {{ old('prioritario', $proyecto->prioritario) ? 'checked' : '' }}>
                <label for="prioritario">Destacado</label>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Registrar cambio</button>
        </div>
    </form>
    @else
        @include('system.parts.not_found', ['route' => route('proyectos.index')])
    @endif
@endsection
