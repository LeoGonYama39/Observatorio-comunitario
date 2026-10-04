{{--
  Params:
  - $tipo: string, ej. 'centro', 'externo', 'comunidad', 'institucion'
  - $label: string, título de la sección
  - $options: Collection de objetos con ->id, ->nombre, ->subtitle (puede ser null/"")
  - $selected: array [id => ['rol' => ..., 'otros' => ...]], default [] (vacío = como el create)
--}}
@php
    $selected = $selected ?? [];
    $roles = $roles ?? [];
@endphp

<div class="entity-picker">
    <h3 class="form-section-title">{{ $label }}</h3>

    <div class="table-search">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7"/>
            <path d="m21 21-4.3-4.3"/>
        </svg>
        <input type="text" placeholder="Buscar por nombre…" onkeydown="if (event.key === 'Enter') event.preventDefault()">
    </div>

    <div class="table-card">
        <div class="entity-scroll">
            <table>
                <tbody>
                @foreach($options as $option)
                    <tr class="selectable-row {{ array_key_exists($option->id, $selected) ? 'row-selected' : '' }}"
                        data-tipo="{{ $tipo }}" data-id="{{ $option->id }}"
                        data-nombre="{{ $option->nombre }}" data-subtitle="{{ $option->subtitle ?? '' }}"
                        onclick="toggleEntitySelection(this)">
                        <td class="select-check-cell">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </td>
                        <td>
                            <div class="person-name">{{ $option->nombre }}</div>
                            @if(!empty($option->subtitle))
                                <div class="person-role">{{ $option->subtitle }}</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="selected-entity-list" id="selected-{{ $tipo }}">
        {{-- Pre-renderizado con la MISMA estructura que genera addEntityCard() en JS,
             para que remove-entity-btn y el <select> de rol funcionen igual que si
             el usuario lo acabara de agregar con clicks. --}}
        @foreach($selected as $id => $pivot)
            @php $option = $options->firstWhere('id', $id); @endphp
            @continue(!$option)
            <div class="selected-entity-card" data-card-id="{{ $id }}">
                <div class="entity-card-head">
                    <div class="entity-info">
                        <div class="person-name">{{ $option->nombre }}</div>
                        @if(!empty($option->subtitle))
                            <div class="person-role">{{ $option->subtitle }}</div>
                        @endif
                    </div>
                    <button type="button" class="remove-entity-btn" aria-label="Quitar"
                            onclick="removeEntityCard(this, '{{ $tipo }}', '{{ $id }}')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                            <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="entity-rol-group">
                    <div class="select-shell">
                        <select class="form-select" required name="roles_{{ $tipo }}[{{ $id }}][rol]"
                                onchange="onEntityRolChange(this, 'otro_field_{{ $tipo }}_{{ $id }}')">
                            <option value="">Seleccionar rol…</option>
                            @foreach($roles as $valor)
                                <option value="{{ $valor }}" {{ $pivot['rol'] === $valor ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $valor)) }}</option>
                            @endforeach
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    <input type="text" class="form-input" id="otro_field_{{ $tipo }}_{{ $id }}"
                           name="roles_{{ $tipo }}[{{ $id }}][otros]" placeholder="Especificar otro rol" maxlength="30"
                           value="{{ $pivot['otros'] ?? '' }}" {{ ($pivot['rol'] ?? '') === 'otro' ? '' : 'hidden' }}>
                </div>
            </div>
        @endforeach
    </div>
</div>
