// Abrir y cerrar el panel flotante de filtros al hacer clic en el botón
function toggleFilterDropdown() {
    const popover = document.getElementById('filterPopover');
    if (!popover) return;
    
    const isHidden = popover.hasAttribute('hidden');
    // Cierra cualquier otro posible menú y alterna el actual
    if (isHidden) {
        popover.removeAttribute('hidden');
    } else {
        popover.setAttribute('hidden', '');
    }
}

// Cerrar el popover si el usuario hace clic fuera de él
document.addEventListener('click', function(e) {
    const container = document.querySelector('.filter-dropdown-container');
    const popover = document.getElementById('filterPopover');
    if (!container || !popover) return;
    
    if (!container.contains(e.target) && !popover.hasAttribute('hidden')) {
        popover.setAttribute('hidden', '');
    }
});

// Botón de "Borrar filtros": limpia todos los inputs y checkboxes del formulario
function clearFilters() {
    const form = document.getElementById('filterForm');
    if (!form) return;
    
    form.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
    
    // Reiniciar los sliders de edad a sus valores por defecto (0 y 99)
    const lowInput = document.getElementById('edadRangeLow');
    const highInput = document.getElementById('edadRangeHigh');
    if (lowInput && highInput) {
        lowInput.value = 0;
        highInput.value = 99;
        updateEdadRange();
    }
    
    // Opcional: enviar el formulario limpio o recargar la ruta base del index
    window.location.href = "{{ route('personas-usuarias.index') }}";
}

// Lógica del doble slider de rango de edad (idéntica a la de población objetivo de proyectos)
function updateEdadRange() {
    const lowInput = document.getElementById('edadRangeLow');
    const highInput = document.getElementById('edadRangeHigh');
    if (!lowInput || !highInput) return;

    let low = parseInt(lowInput.value);
    let high = parseInt(highInput.value);

    if (low > high) {
        [low, high] = [high, low];
        lowInput.value = low;
        highInput.value = high;
    }

    document.getElementById('edadLowLabel').textContent = low;
    document.getElementById('edadHighLabel').textContent = high;
    document.getElementById('edadObjLow').value = low;
    document.getElementById('edadObjHigh').value = high;

    const min = 0, max = 99;
    const fill = document.getElementById('edadRangeFill');
    if (fill) {
        const leftPct = ((low - min) / (max - min)) * 100;
        const rightPct = ((high - min) / (max - min)) * 100;
        fill.style.left = leftPct + '%';
        fill.style.width = (rightPct - leftPct) + '%';
    }
}