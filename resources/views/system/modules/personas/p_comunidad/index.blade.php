@extends('system.app')

@section('title', 'Personas usuarias')

@section('content')
    @include('system.parts.alerts.alerts')
    <div class="content-header">
        <div>
            <h1>Personas usuarias</h1>
            <p>Personas de la comunidad</p>
        </div>
        <a href="{{ route('personas-usuarias.create') }}" data-url="{{ route('personas-usuarias.create') }}" class="btn-new">
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
            <svg width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="7" />
                <path d="m21 21-4.3-4.3" />
            </svg>
            <input type="text" placeholder="Buscar por nombre…" />
        </div>
        <button class="btn-filter" type="button">
            <svg width="15" height="15" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="1.8"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 6h16" />
                <path d="M7 12h10" />
                <path d="M10 18h4" />
            </svg>
            Filtro
            <svg width="13" height="13" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6" />
            </svg>
        </button>
        <div class="table-pagination">
            <span class="table-pagination-info">
                1–20 de 25 personas
            </span>
            <div class="table-pagination-controls">
                <button type="button" class="table-pagination-btn" aria-label="Página anterior" disabled>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>
                </button>
                <button type="button" class="table-pagination-btn" aria-label="Página siguiente">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Colonia</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarias as $usuaria)
                    <tr data-url="{{ route('personas-usuarias.show', $usuaria->id) }}" data-edad="{{ $usuaria->edad }}"
                        data-colonia="{{ $usuaria->colonia }}" data-categ="{{ $usuaria->categ_categ }}">
                        <td>
                            <div class="person-name">
                                {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat ?? '' }}
                            </div>
                            <div class="person-role">
                                {{ $usuaria->activo ? 'Registro activo' : 'Registro inactivo' }}
                            </div>
                        </td>
                        <td>
                            <span class="area-tag {{ $usuaria->edad ? '' : 'empty' }}">
                                {{ $usuaria->edad ? $usuaria->edad . ' años' : '—' }}
                            </span>
                        </td>
                        <td>
                            <span class="area-tag {{ !$usuaria->colonia && !$usuaria->colonia_otro ? 'empty' : '' }}">
                                {{ $usuaria->colonia_mostrar }}
                            </span>
                        </td>
                        <td>
                            <span class="area-tag">
                                {{ $usuaria->categoria }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
