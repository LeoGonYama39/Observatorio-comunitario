@extends('system.app')

@section('title', 'Editar grupo')

@section('content')
    @if($grupo)
        @php
            $inscritos = $grupo->grupos()
                ->get()
                ->mapWithKeys(fn ($persona) => [
                    $persona->id => $persona->pivot->baja,
                ])->toArray();
        @endphp

    <div class="breadcrumb">
        <a href="{{ route('talleres.index') }}" data-url="{{ route('talleres.index') }}" class="return-index">
            Talleres
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <a href="{{ route('talleres.show', $grupo->taller->id) }}" data-url="{{ route('talleres.show', $grupo->taller->id) }}" class="return-index">
            {{ $grupo->taller->nombre }}
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6"/>
        </svg>
        <span class="current">
    Editar grupo
  </span>
    </div>

    <div class="content-header">
        <div>
            <h1>Editar grupo</h1>
            <p>{{ ucfirst($grupo->temporada) }} {{ $grupo->anio }}</p>
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

    <form method="POST" action="#">
        @csrf
        @method('PUT')

        <h3 class="form-section-title">Datos generales</h3>
        <div class="form-card">
            <div class="form-grid">
                @include('system.parts.forms.enum_select', ['name' => 'temporada', 'label' => 'Temporada', 'options' => $opTemporada, 'obligatorio' => true, 'old_option' => $grupo->temporada])

                <div class="form-field">
                    <label>Año <span class="required">*</span></label>
                    <input type="number" name="anio" class="form-input" value="{{ old('anio', $grupo->anio) }}">
                    @error('anio') <span class="field-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-field">
                    <label>Evaluación</label>
                    <textarea name="evaluacion" class="form-textarea textarea-large" rows="5">{{ old('evaluacion', $grupo->evaluacion) }}</textarea>
                    @error('evaluacion')
                    <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>


        <h3 class="form-section-title">Incripción</h3>
        <div class="table-search">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7"/>
                <path d="m21 21-4.3-4.3"/>
            </svg>
            <input type="text" placeholder="Buscar por nombre…" onkeydown="if (event.key === 'Enter') event.preventDefault()">
        </div>

        <div class="table-card" style="margin-top: 20px">
            <div class="entity-scroll">
                <table>
                    <tbody>
                    @if(!$usuarias)
                        <tr>
                            <td>Error al buscar personas usuarias</td>
                        </tr>
                    @else
                        @foreach($usuarias as $persona)
                            <tr class="selectable-row {{ array_key_exists($persona->id, $inscritos) ? 'row-selected' : '' }}"
                                data-id="{{ $persona->id }}"
                                data-nombre="{{ $persona->nombre }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}"
                                data-subtitle="{{ $persona->colonia_mostrar ?? '' }}"
                                onclick="toggleAlumnoSelection(this)">
                                <td class="select-check-cell">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 6 9 17l-5-5"/>
                                    </svg>
                                </td>
                                <td>
                                    <div class="person-name">{{ $persona->nombre }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</div>
                                    @if(!empty($persona->colonia_mostrar))
                                        <div class="person-role">{{ $persona->colonia_mostrar }}</div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <h3 class="form-section-title" style="margin-top: 20px">Inscritos</h3>
        <div class="selected-entity-list" id="selected-alumnos">
            {{-- Pre-renderizado con la MISMA estructura que arma addAlumnoCard() en JS --}}
            @foreach($inscritos as $id => $baja)
                @php $persona = $usuarias->firstWhere('id', $id); @endphp
                @continue(!$persona)
                <div class="selected-entity-card alumno-card" data-card-id="{{ $id }}">
                    <div class="entity-info">
                        <div class="person-name">{{ $persona->nombre }} {{ $persona->ap_pat }} {{ $persona->ap_mat }}</div>
                        @if(!empty($persona->colonia_mostrar))
                            <div class="person-role">{{ $persona->colonia_mostrar }}</div>
                        @endif
                    </div>

                    <label class="baja-toggle" for="baja_{{ $id }}">
                        <input type="checkbox" id="baja_{{ $id }}" name="baja[{{ $id }}]" value="1" {{ $baja ? 'checked' : '' }}>
                        Dado de baja
                    </label>

                    <button type="button" class="remove-entity-btn" aria-label="Quitar"
                            onclick="removeAlumnoCard(this, '{{ $id }}')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                            <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
                        </svg>
                    </button>

                    <input type="hidden" name="grupo[]" value="{{ $id }}">
                </div>
            @endforeach
        </div>

        <div class="form-actions" style="margin-top: 20px">
            <a href="{{ route('talleres.show', $grupo->taller->id) }}" data-url="{{ route('talleres.show', $grupo->taller->id) }}" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-new">Guardar cambios</button>
        </div>
    </form>
    @else
        @include('system.parts.alerts.not_found', ['route' => route('talleres.index')])
    @endif
@endsection
