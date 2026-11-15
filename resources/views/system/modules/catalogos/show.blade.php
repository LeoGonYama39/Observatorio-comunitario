@extends('system.app')

@section('title', 'Catálogo · ' . $config->titulo)

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('catalogos.index') }}" data-url="{{ route('catalogos.index') }}" class="return-index">
            Catálogos
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 6l6 6-6 6" />
        </svg>
        <span class="current">{{ $config->titulo }}</span>
    </div>

    @include('system.parts.alerts.alerts')

    @if ($errors->any())
        <div class="form-card" style="border-color:#b3261e; margin-bottom: 16px; padding: 14px 20px;">
            <ul style="margin:0; padding-left: 18px; color:#b3261e; font-size: 13.5px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-header">
        <div>
            <h1>{{ $config->titulo }}</h1>
            <p>{{ $config->descripcion }} Haz clic sobre cualquier nombre para editarlo directamente.</p>
        </div>
    </div>

    {{-- ========================================================= --}}
    {{-- BARRA DE CREACIÓN RÁPIDA (IN-SITU)                        --}}
    {{-- ========================================================= --}}
    <form method="POST" action="{{ route('catalogos.store', $config->slug) }}" class="quick-add-card">
        @csrf
        <input type="text"
               name="nombre"
               class="form-input"
               placeholder="Escribe una nueva {{ $config->singular }}..."
               maxlength="{{ $config->max_length }}"
               value="{{ old('nombre') }}"
               required>

        @if ($config->has_bool)
            <div class="form-checkbox-row" style="margin: 0; padding: 0; border: none;">
                <input type="checkbox" id="new_bool_field" name="{{ $config->bool_field }}" value="1" {{ old($config->bool_field) ? 'checked' : '' }}>
                <label for="new_bool_field">{{ $config->bool_label }}</label>
            </div>
        @endif

        <button type="submit" class="btn-new">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14" />
                <path d="M5 12h14" />
            </svg>
            Agregar
        </button>
    </form>

    {{-- ========================================================= --}}
    {{-- TABLA EDITABLE ESTILO HOJA DE CÁLCULO                     --}}
    {{-- ========================================================= --}}
    <div class="table-card">
        <table>
            <thead>
            <tr>
                <th style="width: 45%;">Nombre (clic para editar)</th>
                @if ($config->has_bool)
                    <th style="width: 18%;">{{ $config->bool_label }}</th>
                @endif
                <th>Uso actual en el sistema</th>
                <th style="text-align: right; width: 140px;">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($items as $item)
                @php
                    $formId = 'form_row_' . $item->id;
                    $usos = [];
                    $totalUsos = 0;

                    foreach ($config->relaciones as $relKey => [$singular, $plural]) {
                        $cant = $item->{$relKey . '_count'} ?? 0;
                        $totalUsos += $cant;

                        if ($cant > 0) {
                            $etiqueta = ($cant === 1) ? $singular : $plural;
                            $usos[] = "$cant $etiqueta";
                        }
                    }
                    $textoUso = count($usos) > 0 ? implode(' · ', $usos) : 'Sin uso';
                @endphp

                <tr style="cursor: default;">
                    <td>
                        <form id="{{ $formId }}" method="POST" action="{{ route('catalogos.update', [$config->slug, $item->id]) }}">
                            @csrf
                            @method('PUT')
                            <input type="text"
                                   name="nombre"
                                   class="inline-edit-input"
                                   value="{{ $item->nombre }}"
                                   maxlength="{{ $config->max_length }}"
                                   required
                                   oninput="this.closest('tr').classList.add('is-dirty')">
                        </form>
                    </td>

                    @if ($config->has_bool)
                        <td>
                            <div class="form-checkbox-row" style="margin: 0; padding: 0; border: none;">
                                <input type="checkbox"
                                       form="{{ $formId }}"
                                       id="bool_{{ $item->id }}"
                                       name="{{ $config->bool_field }}"
                                       value="1"
                                       {{ $item->{$config->bool_field} ? 'checked' : '' }}
                                       onchange="this.closest('tr').classList.add('is-dirty')">
                                <label for="bool_{{ $item->id }}">
                                    {{ $item->{$config->bool_field} ? 'Sí' : 'No' }}
                                </label>
                            </div>
                        </td>
                    @endif

                    <td>
                            <span class="meta-badge {{ $totalUsos > 0 ? 'on' : '' }}">
                                {{ $textoUso }}
                            </span>
                    </td>

                    <td>
                        <div class="catalog-row-actions">
                            <button type="submit" form="{{ $formId }}" class="btn-save-inline" title="Guardar cambios de esta fila">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Guardar
                            </button>

                            <button type="button"
                                    class="btn-row-delete"
                                    title="Eliminar registro"
                                    onclick="document.getElementById('modalEliminarCat_{{ $item->id }}').showModal()">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18"/>
                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6"/>
                                    <path d="M14 11v6"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>

                @include('system.parts.alerts.confirm_delete', [
                    'modalId' => 'modalEliminarCat_' . $item->id,
                    'titulo'  => '¿Eliminar ' . $config->singular . '?',
                    'mensaje' => $totalUsos > 0
                        ? "Actualmente se utiliza en ($textoUso). Si eliminas :nombre, se desvinculará de esos registros."
                        : "Se eliminará :nombre del catálogo (actualmente no está en uso).",
                    'nombre'  => $item->nombre,
                    'ruta'    => route('catalogos.destroy', [$config->slug, $item->id]),
                ])
            @empty
                <tr style="cursor: default;">
                    <td colspan="{{ $config->has_bool ? 4 : 3 }}" style="text-align: center; padding: 32px; color: var(--steel);">
                        No hay registros en este catálogo todavía. Usa la barra superior para agregar el primero.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
