@extends('system.app')

@section('title', $asesoria ? ($tipoAsesoria === 'familiar' ? $asesoria->nombre_familia : $asesoria->comunidad->nombre .
    ' ' . $asesoria->comunidad->ap_pat . ' ' . $asesoria->comunidad->ap_mat . ' · ' . ucfirst($label)) : 'Sin resultados')

@section('content')
    @if ($asesoria)
        <div class="breadcrumb">
            <a href="{{ route($ruta . '.index') }}" data-url="{{ route($ruta . '.index') }}" class="return-index">
                {{ ucfirst($label) }}
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                @if ($tipoAsesoria === 'familiar')
                    {{ $asesoria->nombre_familia }}
                @else
                    {{ $asesoria->comunidad->nombre }}
                    {{ $asesoria->comunidad->ap_pat }}
                    {{ $asesoria->comunidad->ap_mat ?? '' }}
                @endif
            </span>
        </div>
        <div class="content-header">
            <div>
                <h1>
                    @if ($tipoAsesoria === 'familiar')
                        {{ $asesoria->nombre_familia }}
                    @else
                        {{ $asesoria->comunidad->nombre }}
                        {{ $asesoria->comunidad->ap_pat }}
                        {{ $asesoria->comunidad->ap_mat ?? '' }}
                    @endif
                </h1>
                <p>
                    Ficha de {{ $label }}
                </p>
            </div>
            <div class="header-actions">
                <button class="btn-outline">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z" />
                    </svg>
                    Editar
                </button>
                <button class="btn-danger">
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
        <div class="info-card" style="margin-bottom: 32px;">
            <h3>
                Información general
            </h3>
            <div class="info-grid">
                <div class="info-field">
                    <label>
                        Periodo
                    </label>
                    <div class="value">
                        {{ ucfirst($asesoria->asesoria->temporada) }} {{ $asesoria->asesoria->anio }}
                    </div>
                </div>
                <div class="info-field">
                    <label>
                        Estado
                    </label>
                    <span class="meta-badge @if($asesoria->asesoria->estado === 'asunto_concluido') on @endif">
                        {{ ucfirst(str_replace('_', ' ', $asesoria->asesoria->estado)) }}
                    </span>
                </div>
                <div class="info-field">
                    <label>
                        Ramas
                    </label>
                    <div class="simple-tag-list">
                        @forelse($asesoria->asesoria->ramas as $rama)
                            <span class="tag">
                                {{ $rama->nombre }}
                            </span>
                        @empty
                            <span class="tag">
                                Sin ramas registradas
                            </span>
                        @endforelse
                    </div>
                </div>
                <div class="info-field">
                    <label>
                        Conflictos
                    </label>
                    <div class="simple-tag-list">
                        @forelse($asesoria->asesoria->conflictos as $conflicto)
                            <span class="tag">
                                {{ $conflicto->nombre }}
                            </span>
                        @empty
                            <span class="tag">
                                Sin conflcitos registradas
                            </span>
                        @endforelse
                    </div>
                </div>
                @if($tipoAsesoria === "juridica")
                    <div class="info-field">
                        <label>
                            Edad
                        </label>
                        <div class="value">
                            {{ $asesoria->comunidad->edad }} años
                        </div>
                    </div>
                    <div class="info-field">
                        <label>
                            Colonia
                        </label>
                        <div class="value">
                            {{ $asesoria->comunidad->colonia_mostrar }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="section-header">
            <h3>
                Involucrados en el conflicto
            </h3>
            <button class="btn-outline btn-small">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14" />
                    <path d="M5 12h14" />
                </svg>
                Editar involucrados
            </button>
        </div>
        <div class="table-card" style="margin-bottom: 32px;">
            <div style="padding: 6px 24px;">
                @forelse($asesoria->asesoria->involucrados as $inv)
                    <div class="related-row">
                        <span class="name">
                           {{ $inv->nombre }}
                        </span>
                        <span class="role-badge participante">
                            {{ $inv->familiar_directo ? 'Familiar directo' : 'Familiar indirecto' }}
                        </span>
                    </div>
                @empty
                    <div class="related-row">
                        <span class="name">
                            <strong>Sin involucrados registrados</strong>
                        </span>
                    </div>
                @endforelse
            </div>
        </div>
    @else
        @include('system.parts.alerts.not_found', ['route' => route($ruta . '.index')])
    @endif
@endsection
