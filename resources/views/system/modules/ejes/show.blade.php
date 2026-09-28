@extends('system.app')

@section('title', $eje ? $eje->nombre .  '· Ficha' : 'Sin resultados')

@section('content')
    @if ($eje)
        <div class="breadcrumb">
            <a href="{{ route('ejes.index') }}" data-url="{{ route('ejes.index') }}" class="return-index">
                Ejes
            </a>
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M9 6l6 6-6 6" />
            </svg>
            <span class="current">
                {{ $eje->nombre }}
            </span>
        </div>

        @include('system.parts.alerts')

        <div class="content-header">
            <div>
                <h1>
                    {{ $eje->nombre }}
                </h1>
                <p>
                    Ficha del eje
                </p>
            </div>
            <div class="header-actions">
                <a href="{{ route('ejes.edit', $eje->id) }}" data-url="{{ route('ejes.edit', $eje->id) }}"
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
                        Responsabilidad
                    </label>
                    <div class="value {{ $eje->responsabilidades_formato ? '' : 'empty' }}">
                        {{ $eje->responsabilidades_formato ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="section-header">
            <h3>
                Responsabilidades encargadas
            </h3>
            <a class="btn-outline btn-small" href="#" data-url="#">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14"/>
                    <path d="M5 12h14"/>
                </svg>
                Agregar responsabilidad
            </a>
        </div>
        @if($eje->responsabilidades->isNotEmpty())
            <div class="table-card" style="margin-bottom: 32px;">
                <div style="padding: 6px 24px;">
                    @foreach($eje->responsabilidades as $respons)
                        <div class="related-row">
            <span class="name">
                {{ $respons->nombre }}
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p>Sin responsabilidades registrados</p>
        @endif

        <dialog id="modalEliminar" class="confirm-modal" onclick="if (event.target === this) this.close()">
            <div class="confirm-modal-content">
                <div class="confirm-modal-header">
                    <div class="confirm-modal-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                        </svg>
                    </div>
                    <div>
                        <h3>¿Eliminar eje?</h3>
                        <p>Esta acción no se puede deshacer. Se eliminará el registro de
                            <strong>{{ $eje->nombre }}</strong>.</p>
                    </div>
                </div>
                <div class="confirm-modal-actions">
                    <button type="button" class="btn-outline" onclick="document.getElementById('modalEliminar').close()">
                        Cancelar
                    </button>
                    <form action="{{ route('ejes.destroy', $eje->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18" />
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            </svg>
                            Confirmar eliminación
                        </button>
                    </form>
                </div>
            </div>
        </dialog>
    @else
        @include('system.parts.not_found', ['route' => route('ejes.index')])
    @endif

@endsection
