{{-- Params: $group, $label, $placeholder, $options, y opcional $selected (ids ya vinculados, para el edit) --}}
@php
    $selected = old($group, $selected ?? []);
@endphp

<div class="form-field full-width">
    <label>{{ $label }}</label>
    <div class="tag-picker">
        <div class="select-shell">
            <select class="form-select" onchange="addTag(this, '{{ $group }}')">
                @if($options->isEmpty())
                    <option value="">Error, options vacío</option>
                @else
                    <option value="">{{ $placeholder }}</option>
                    @foreach($options as $option)
                        <option value="{{ $option->id }}">{{ $option->nombre }}</option>
                    @endforeach
                @endif
            </select>
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 9l6 6 6-6"/>
            </svg>
        </div>

        <div class="tag-chip-list" id="{{ $group }}-list">
            @foreach($options->whereIn('id', $selected) as $option)
                <span class="tag-chip" data-value="{{ $option->id }}">{{ $option->nombre }}<button type="button" class="remove-tag" onclick="this.parentElement.remove()"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M18 6 6 18"/><path d="M6 6l12 12"/></svg></button><input type="hidden" name="{{ $group }}[]" value="{{ $option->id }}"></span>
            @endforeach
        </div>
    </div>

    @error($group) <span class="field-error">{{ $message }}</span> @enderror
    @error($group . '.*') <span class="field-error">{{ $message }}</span> @enderror
</div>
