@extends('system.app')

@section('title', 'Agregar registro de historial')

@section('content')
    @if($entidad)
        <div class="breadcrumb">
            <a href="{{ $rutaIndex }}" data-url="{{ $rutaIndex }}" class="return-index">
                {{ $nombreIndex }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="return-index">
                {{ $nombreEntidad }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                Registro nuevo de historial
            </span>
        </div>
        @include('system.parts.alerts')
        <div class="content-header">
            <div>
                <h1>Nuevo registro de historial</h1>
                <p>Agregar un nuevo registro de historial</p>
            </div>
        </div>

        <form method="POST" action="{{ $rutaStore }}">
            @csrf

            <div class="form-card">
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
                            Comentario <span class="required">*</span>
                        </label>
                        <textarea name="comentario" class="form-textarea textarea-large" rows="5">{{ old('comentario') }}</textarea>
                        @error('comentario')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ $rutaShow }}" data-url="{{ $rutaShow }}" class="btn-outline">
                    Cancelar
                </a>
                <button type="submit" class="btn-new">
                    Registrar
                </button>
            </div>
        </form>
    @else
        @include('system.parts.not_found', ['route' => $rutaIndex,])
    @endif
@endsection
