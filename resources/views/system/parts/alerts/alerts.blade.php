@if (session('success'))
    <div class="sys-alert sys-alert-success" role="alert">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 6 9 17l-5-5"/>
        </svg>
        <span>{{ session('success') }}</span>
        <button type="button" class="sys-alert-close" onclick="this.parentElement.remove()" aria-label="Cerrar">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="sys-alert sys-alert-error" role="alert">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>{{ session('error') }}</span>
        <button type="button" class="sys-alert-close" onclick="this.parentElement.remove()" aria-label="Cerrar">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"/><path d="M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif
