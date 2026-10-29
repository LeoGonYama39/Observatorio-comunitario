{{-- Params: $name, $label, $options (array de valores del enum),
     opcionales: $onchange (JS del select), $format (closure valor => texto a mostrar) --}}
@php
    $format = $format ?? fn ($valor) => \Illuminate\Support\Str::ucfirst(str_replace('_', ' ', $valor));
    $key = fn ($valor) => !empty($usarId) ? $valor->id : $valor;
    $display = fn($valor) => !empty($usarId) ? $valor->nombre : $valor;
@endphp
<div class="form-field">
    <label>{{ $label }} @if(!empty($obligatorio)) <span class="required">*</span>@endif</label>
    <div class="select-shell">
        <select name="{{ $name }}" class="form-select" @if(!empty($onchange)) onchange="{{ $onchange }}" @endif>
            <option value="">Sin especificar</option>
            @foreach($options as $valor)
                <option value="{{ $key($valor) }}"
                    {{ (string) old($name, $old_option ?? '') === (string) $key($valor) ? 'selected' : '' }}>
                    {{ $format($display($valor)) }}
                </option>
            @endforeach
        </select>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
        </svg>
    </div>
    @error($name) <span class="field-error">{{ $message }}</span> @enderror
</div>