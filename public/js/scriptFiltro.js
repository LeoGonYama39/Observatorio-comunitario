//Estados de los filtros
let activeFiltersState = {};

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
        syncInputsWithActiveState();
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
        // Buscador de texto
        if (searchTerm) {
            const nameEl = row.querySelector('.person-name');
            if (!nameEl || !nameEl.textContent.toLowerCase().includes(searchTerm)) return false;
        }

        // Filtro especial de edad (solo si está activo)
        if (activeFiltersState._edad) {
            const rowEdad = parseInt(row.dataset.edad);
            if (!isNaN(rowEdad)) {
                if (rowEdad < activeFiltersState._edad.min || rowEdad > activeFiltersState._edad.max) {
                    return false;
                }
            } else if (activeFiltersState._edad.min > 0) {
                return false;
            }
        }

        // Filtros dinámicos basados en data-*
        for (const [tipo, valoresSeleccionados] of Object.entries(activeFiltersState)) {
            if (tipo === '_edad' || valoresSeleccionados.length === 0) continue;

            const rowRawValue = (row.dataset[tipo] || '').toLowerCase().trim();
            //Excepciones
            //lider_saberes en usuarios, puede servir tanto con lider o saberes
            if (tipo === 'categ' && rowRawValue === 'lider_saberes') {  
                const match = valoresSeleccionados.includes('lider') || valoresSeleccionados.includes('saberes');
                if (!match) return false;
                continue;
            }
            const rowValoresArray = rowRawValue.split(',').map(v => v.trim());
            const tieneCoincidencia = valoresSeleccionados.some(val => rowValoresArray.includes(val));
            if (!tieneCoincidencia) return false;
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
    activeFiltersState = {};

    document.querySelectorAll('.filter-cb:checked').forEach(cb => {
        const tipo = cb.dataset.filter;
        if (!tipo) return;

        if (!activeFiltersState[tipo]) {
            activeFiltersState[tipo] = [];
        }
        activeFiltersState[tipo].push(cb.value.toLowerCase());
    });

    const lowInput = document.getElementById('edadRangeLow');
    const highInput = document.getElementById('edadRangeHigh');
    if (lowInput && highInput) {
        const min = parseInt(lowInput.value);
        const max = parseInt(highInput.value);
        if (min > 0 || max < 99) {
            activeFiltersState._edad = { min, max };
        }
    }

    let totalCount = 0;
    for (const [key, val] of Object.entries(activeFiltersState)) {
        totalCount += key === '_edad' ? 1 : val.length;
    }
    updateFilterBadgeCount(totalCount);
    runFiltering();

    const popover = document.getElementById('filterPopover');
    if (popover) popover.hidden = true;
}

/////Para borrar los filtros
function clearClientFilters() {
    clearFilterOptions();
    activeFiltersState = {};
    updateFilterBadgeCount(0);
    runFiltering();
}

function clearFilterOptions(){
    document.querySelectorAll('.filter-cb').forEach(cb => cb.checked = false);

    const lowInput = document.getElementById('edadRangeLow');
    const highInput = document.getElementById('edadRangeHigh');
    if (lowInput && highInput) {
        lowInput.value = 0;
        highInput.value = 99;
        if (typeof updateFilterEdadRange === 'function') updateFilterEdadRange();
    }
}

function syncInputsWithActiveState() {
    document.querySelectorAll('.filter-cb').forEach(cb => {
        const tipo = cb.dataset.filter;
        if (!tipo) return;
        const valoresConfirmados = activeFiltersState[tipo] || [];
        cb.checked = valoresConfirmados.includes(cb.value.toLowerCase());
    });

    const lowInput = document.getElementById('edadRangeLow');
    const highInput = document.getElementById('edadRangeHigh');
    if (lowInput && highInput) {
        const edadConfig = activeFiltersState._edad || { min: 0, max: 99 };
        lowInput.value = edadConfig.min;
        highInput.value = edadConfig.max;

        if (typeof updateFilterEdadRange === 'function') {
            updateFilterEdadRange();
        }
    }
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