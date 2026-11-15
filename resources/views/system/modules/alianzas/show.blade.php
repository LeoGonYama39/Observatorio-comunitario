@extends('system.app')

@section('title', $aliado ? $aliado->nombre : 'Sin resultados')

@section('content')
    @if ($aliado)
        <div class="breadcrumb">
            <a href="{{ route('alianzas.index') }}" data-url="{{ route('alianzas.index') }}" class="return-index">
                Alianzas/Instituciones
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                {{ $aliado->nombre }}
            </span>
        </div>

        @include('system.parts.alerts.alerts')

        <div class="content-header">
            <div>
                <h1>
                    {{ $aliado->nombre }}
                </h1>
                <p>
                    Ficha del aliado/institución
                </p>
            </div>
            <div class="header-actions">
                <a href="{{ route('alianzas.edit', $aliado->id) }}" data-url="{{ route('alianzas.edit', $aliado->id) }}"
                   class="btn-outline">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                    </svg>
                    Editar
                </a>
                <button type="button" class="btn-danger" onclick="document.getElementById('modalEliminar').showModal()">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18" />
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M10 11v6" />
                        <path d="M14 11v6" />
                    </svg>
                    Borrar
                </button>
            </div>
        </div>
        <div class="info-card">
            <h3>
                Información general
            </h3>
            <div class="info-grid">
                <div class="info-field">
                    <label>
                        Contacto
                    </label>
                    <div class="value {{ $aliado->nombre_contacto ? '' : 'empty' }}">
                        {{ $aliado->nombre_contacto ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>
                        Área
                    </label>
                    <div class="value {{ $aliado->area ? '' : 'empty' }}">
                        {{ $aliado->area ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label class="label-with-info">
                        Es universidad
                        <span class="field-info-tooltip"
                              data-tooltip="Las instituciones marcadas como universidades pueden ser ligadas a las personas externas">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                        </span>
                    </label>
                    <div class="value">
                        {{ $aliado->universidad ? 'Sí' : 'No' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>
                        Correo
                    </label>
                    <div class="value {{ $aliado->correo ? '' : 'empty' }}">
                        {{ $aliado->correo ?? '-' }}
                    </div>
                </div>
                <div class="info-field">
                    <label>
                        Teléfono
                    </label>
                    <div class="value {{ $aliado->telefono ? '' : 'empty' }}">
                        {{ $aliado->telefono ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        @include('system.parts.alerts.confirm_delete', [
            'modalId' => 'modalEliminar',
            'titulo' => '¿Eliminar alianza?',
            'mensaje' => 'Esta acción no se puede deshacer. Se eliminará el registro de :nombre.',
            'nombre' => $aliado->nombre,
            'ruta' => route('alianzas.destroy', $aliado->id),
        ])
    @else
        @include('system.parts.alerts.not_found', ['route' => route('alianzas.index')])
    @endif

@endsection
