@extends('system.app')

@section('title', 'Editar registro de participación')

@section('content')
    @if($participacion)
        <div class="breadcrumb">
            <a href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}" class="return-index">
                Personas Externas
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <a href="{{ route('personas-externo.show', $participacion->externo->id) }}" data-url="{{ route('personas-externo.show', $participacion->externo->id) }}" class="return-index">
                {{ $participacion->externo->nombre }} {{ $participacion->externo->ap_pat }} {{ $participacion->externo->ap_mat }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 6l6 6-6 6"/>
            </svg>
            <span class="current">
    Editar registro de participación
  </span>
        </div>
        @include('system.parts.alerts')
        <div class="content-header">
            <div>
                <h1>Editar registro de participación</h1>
                <p>Editar participación para {{ $participacion->externo->nombre }} {{ $participacion->externo->ap_pat }} {{ $participacion->externo->ap_mat }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('personas-externo.update_participacion', $participacion->id) }}">
            @csrf
            @method('PUT')

            <div class="form-card">
                <div class="form-grid">
                    <div class="form-field">
                        <label>Temporada <span class="required">*</span></label>
                        <div class="select-shell">
                            <select name="temporada" class="form-select">
                                <option value="">Seleccionar</option>
                                @if(empty($opTemporada))
                                    <option value="">Error al buscar las opciones</option>
                                @else
                                    @foreach($opTemporada as $temporada)
                                        <option value="{{ $temporada }}" {{ old('temporada', $participacion->temporada) == $temporada ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $temporada)) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </div>
                        @error('temporada') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Año <span class="required">*</span></label>
                        <input type="number" name="anio" class="form-input" value="{{ old('anio', $participacion->anio) }}">
                        @error('anio') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Tipo de participación <span class="required">*</span></label>
                        <div class="select-shell">
                            <select name="tipo" class="form-select">
                                <option value="">Seleccionar</option>
                                @if(empty($opTipo))
                                    <option value="">Error al buscar las opciones</option>
                                @else
                                    @foreach($opTipo as $tipo)
                                        <option value="{{ $tipo }}" {{ old('tipo', $participacion->tipo) == $tipo ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $tipo)) }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 9l6 6 6-6"/>
                            </svg>
                        </div>
                        @error('tipo') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-field">
                        <label>Aportación</label>
                        <input type="text" name="aport" class="form-input" value="{{ old('aport', $participacion->aport) }}">
                        @error('aport') <span class="field-error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('personas-externo.show', $participacion->externo->id) }}" data-url="{{ route('personas-externo.show', $participacion->externo->id) }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-new">Registrar cambio</button>
            </div>
        </form>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m21 21-4.3-4.3"/>
                    <path d="M9 9l4 4"/>
                    <path d="M13 9l-4 4"/>
                </svg>
            </div>
            <h2>No se encontró ningún resultado</h2>
            <p>No hay información que coincida con lo que buscas.</p>
            <a type="button" class="btn-outline" href="{{ route('personas-externo.index') }}" data-url="{{ route('personas-externo.index') }}">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5"/><path d="M11 18l-6-6 6-6"/>
                </svg>
                Regresar
            </a>
        </div>
    @endif
@endsection
