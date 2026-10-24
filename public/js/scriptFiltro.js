//Estados de los filtros
let activeFiltersState = {
    estados: [],
    categorias: [],
    colonias: [],
    edadMin: 0,
    edadMax: 99
};

// Abrir y cerrar el menú flotante
function toggleFilterDropdown(e) {
    e.stopPropagation();
    const popover = document.getElementById('filterPopover');
    if (!popover) return;
    popover.hidden = !popover.hidden;
}

// Cerrar al hacer clic fuera del contenedor
document.addEventListener('click', function(e) {
    const popover = document.getElementById('filterPopover');
    const container = document.querySelector('.filter-dropdown-container');
    if (!popover || !container) return;

    if (!container.contains(e.target) && !popover.hidden) {
        popover.hidden = true;
    }
});

// Slider de edad en el filtro
function updateFilterEdadRange() {
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

    const fill = document.getElementById('edadRangeFill');
    if (fill) {
        const leftPct = (low / 99) * 100;
        const rightPct = (high / 99) * 100;
        fill.style.left = leftPct + '%';
        fill.style.width = (rightPct - leftPct) + '%';
    }
}

function runFiltering() {
    const table = document.querySelector('.table-card table');
    if (!table) return;

    const allRows = Array.from(table.querySelectorAll('tbody tr'));
    const searchInput = document.querySelector('.table-search input');
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

    const matchingRows = allRows.filter(row => {
        // Búsqueda por nombre (se actualiza por escribir algo)
        if (searchTerm) {
            const nameEl = row.querySelector('.person-name');
            if (!nameEl || !nameEl.textContent.toLowerCase().includes(searchTerm)) {
                return false;
            }
        }

        // Estado (para usuarias, activo o no)
        const rowActivo = row.dataset.activo || '';
        if (activeFiltersState.estados.length > 0 && !activeFiltersState.estados.includes(rowActivo)) {
            return false;
        }

        // Rango de edad
        const rowEdad = parseInt(row.dataset.edad);
        if (!isNaN(rowEdad)) {
            if (rowEdad < activeFiltersState.edadMin || rowEdad > activeFiltersState.edadMax) return false;
        } else if (activeFiltersState.edadMin > 0) {
            return false;
        }

        // Colonia
        const rowColonia = (row.dataset.colonia || '').toLowerCase();
        if (activeFiltersState.colonias.length > 0 && !activeFiltersState.colonias.includes(rowColonia)) {
            return false;
        }

        // E) Categoría (confirmada)
        const rowCateg = (row.dataset.categ || '').toLowerCase();
        if (activeFiltersState.categorias.length > 0) {
            let matchCateg = false;
            if (rowCateg === 'lider_saberes') {
                matchCateg = activeFiltersState.categorias.includes('lider') || 
                             activeFiltersState.categorias.includes('saberes');
            } else {
                matchCateg = activeFiltersState.categorias.includes(rowCateg);
            }

            if (!matchCateg) return false;
        }
        return true;
    });

    table._filteredRows = matchingRows;

    if (typeof table._paginationReset === 'function') {
        table._paginationReset();
    } else {
        allRows.forEach(row => {
            row.hidden = !matchingRows.includes(row);
        });
    }
}

function applyClientFilters() {
    // Guarda el estado actual de los controles del popover en el estado confirmado
    activeFiltersState.estados = Array.from(document.querySelectorAll('.filter-cb[data-filter="activo"]:checked')).map(cb => cb.value);
    activeFiltersState.categorias = Array.from(document.querySelectorAll('.filter-cb[data-filter="categ"]:checked')).map(cb => cb.value.toLowerCase());
    activeFiltersState.colonias = Array.from(document.querySelectorAll('.filter-cb[data-filter="colonia"]:checked')).map(cb => cb.value.toLowerCase());
    activeFiltersState.edadMin = parseInt(document.getElementById('edadRangeLow')?.value || 0);
    activeFiltersState.edadMax = parseInt(document.getElementById('edadRangeHigh')?.value || 99);

    // Actualiza el badge numérico en el botón de filtro
    const totalCount = activeFiltersState.estados.length +
                       activeFiltersState.categorias.length +
                       activeFiltersState.colonias.length +
                       (activeFiltersState.edadMin > 0 || activeFiltersState.edadMax < 99 ? 1 : 0);
    updateFilterBadgeCount(totalCount);

    // Aplica el filtrado a la tabla
    runFiltering();

    // Cierra el popover
    const popover = document.getElementById('filterPopover');
    if (popover) popover.hidden = true;
}

// 3. Evento del botón "Borrar filtros"
function clearClientFilters() {
    // Desmarca los elementos visuales del popover
    document.querySelectorAll('.filter-cb').forEach(cb => cb.checked = false);

    const lowInput = document.getElementById('edadRangeLow');
    const highInput = document.getElementById('edadRangeHigh');
    if (lowInput && highInput) {
        lowInput.value = 0;
        highInput.value = 99;
        updateFilterEdadRange();
    }

    // Restablece el estado confirmado
    activeFiltersState = {
        estados: [],
        categorias: [],
        colonias: [],
        edadMin: 0,
        edadMax: 99
    };

    updateFilterBadgeCount(0);
    runFiltering();
}

// Botón "Borrar filtros"
function clearClientFilters() {
    document.querySelectorAll('.filter-cb').forEach(cb => cb.checked = false);
    const lowInput = document.getElementById('edadRangeLow');
    const highInput = document.getElementById('edadRangeHigh');
    if (lowInput && highInput) {
        lowInput.value = 0;
        highInput.value = 99;
        updateFilterEdadRange();
    }
    applyClientFilters();
}

// Badge numérico en el botón de filtro
function updateFilterBadgeCount(count) {
    const badge = document.getElementById('filterActiveCount');
    if (!badge) return;

    if (count > 0) {
        badge.textContent = count;
        badge.hidden = false;
    } else {
        badge.hidden = true;
    }
}