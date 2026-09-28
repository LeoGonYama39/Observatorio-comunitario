<div class="empty-state">
    <div class="empty-state-icon">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.8"
             stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7" />
            <path d="m21 21-4.3-4.3" />
            <path d="M9 9l4 4" />
            <path d="M13 9l-4 4" />
        </svg>
    </div>

    <h2>No se encontró ningún resultado</h2>

    <p>No hay información que coincida con lo que buscas.</p>

    <a type="button"
       class="btn-outline"
       href="{{ $route }}"
       data-url="{{ $route }}">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2.2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 12H5" />
            <path d="M11 18l-6-6 6-6" />
        </svg>
        Regresar
    </a>
</div>
