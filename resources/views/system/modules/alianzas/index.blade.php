@extends('system.app')

@section('title', 'Alianzas/Instituciones')

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>
                Alianzas/Instituciones
            </h1>
            <p>
                Alianzas/Instituciones que tiene el centro Ibero Meneses
            </p>
        </div>
        <a href="{{ route('alianzas.create') }}" data-url="{{ route('alianzas.create') }}" class="btn-new">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M12 5v14" />
                <path d="M5 12h14" />
            </svg>
            Nuevo registro
        </a>
    </div>
    <div class="table-toolbar">
        <div class="table-search">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>

            <input type="text" placeholder="Buscar por nombre…" />
        </div>

        <div class="table-pagination">
            <span class="table-pagination-info">
                1–20 de 25 personas
            </span>

            <div class="table-pagination-controls">
                <button type="button" class="table-pagination-btn" aria-label="Página anterior" disabled>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>
                <button type="button" class="table-pagination-btn" aria-label="Página siguiente">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div class="table-card">
        <table>
            <thead>
            <tr>
                <th>
                    Nombre
                </th>
                <th>
                    Área
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($aliados as $aliado)
                <tr data-url="{{ route('alianzas.show', $aliado->id) }}">
                    <td>
                        <div class="person-name">
                            {{ $aliado->nombre }}
                        </div>
                    </td>
                    <td>
                        <span class="area-tag {{ $aliado->area ? '' : 'empty' }}">
                            {{ $aliado->area ?? '-' }}
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
