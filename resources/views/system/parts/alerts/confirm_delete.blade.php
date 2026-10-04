<dialog id="{{ $modalId }}" class="confirm-modal" onclick="if (event.target === this) this.close()">
    <div class="confirm-modal-content">
        <div class="confirm-modal-header">
            <div class="confirm-modal-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18" />
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                    <path d="M10 11v6" />
                    <path d="M14 11v6" />

                </svg>
            </div>

            <div>
                <h3>{{ $titulo }}</h3>
                <p>
                    {!! str_replace(':nombre', '<strong>' . e($nombre) . '</strong>', $mensaje) !!}
                </p>
            </div>
        </div>

        <div class="confirm-modal-actions">
            <button type="button" class="btn-outline" onclick="document.getElementById('{{ $modalId }}').close()">
                Cancelar
            </button>

            <form action="{{ $ruta }}" method="POST" style="margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                         stroke-width="1.8"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    </svg>
                    Confirmar eliminación
                </button>
            </form>
        </div>
    </div>
</dialog>
