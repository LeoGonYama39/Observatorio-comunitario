//---------------------------------------------------------
//          Para las tablas de los index
//---------------------------------------------------------

//Función para inicializar el buscado por texto y filtrar la búsqueda
function initTableSearch() {
    const searchInput = document.querySelector('.table-search input');
    const table = document.querySelector('.table-card table');

    if (!searchInput || !table) {return;}

    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const search = this.value.toLowerCase().trim();

        rows.forEach(row => {
            const name = row.querySelector('.person-name');
            if (!name) {return;}
            const text = name.textContent.toLowerCase();
            row.style.display = text.includes(search) ? '' : 'none';
        });
    });
}


//---------------------------------------------------------
//          Para las tablas de involucrados
//---------------------------------------------------------

//// Vincular participantes a un proyecto (selección en tabla + tarjeta de rol)
//Opciones de rol genéricas por ahora — luego se reemplazan por las reales de la BD
const ROLES_PROYECTO_OPCIONES = [
    { value: 'lider', label: 'Líder' },
    { value: 'participante', label: 'Participante' },
    { value: 'colaborador', label: 'Colaborador' },
    { value: 'enlace', label: 'Enlace' },
    { value: 'otro', label: 'Otro' },
];

//Se llama al hacer click en cualquier fila seleccionable de las 4 tablas
function toggleEntitySelection(row) {
    const tipo = row.dataset.tipo;
    const id = row.dataset.id;
    const container = document.getElementById('selected-' + tipo);
    const existing = container.querySelector('[data-card-id="' + id + '"]');

    if (existing) {
        existing.remove();
        row.classList.remove('row-selected');
    } else {
        row.classList.add('row-selected');
        addEntityCard(tipo, id, row.dataset.nombre, row.dataset.subtitle || '');
    }
}

//Crea la tarjeta con el select de rol + campo "otro" para una entidad recién seleccionada
function addEntityCard(tipo, id, nombre, subtitle) {
    const container = document.getElementById('selected-' + tipo);
    const otroFieldId = 'otro_field_' + tipo + '_' + id;

    const opcionesHtml = ROLES_PROYECTO_OPCIONES
        .map(op => '<option value="' + op.value + '">' + op.label + '</option>')
        .join('');

    const card = document.createElement('div');
    card.className = 'selected-entity-card';
    card.setAttribute('data-card-id', id);

    card.innerHTML =
        '<div class="entity-info">' +
        '<div class="entity-name">' + nombre + '</div>' +
        (subtitle ? '<div class="entity-subtitle">' + subtitle + '</div>' : '') +
        '</div>' +
        '<div class="entity-rol-group">' +
        '<div class="select-shell">' +
        '<select class="form-select" name="roles_' + tipo + '[' + id + '][rol]" ' +
        'onchange="toggleOtroField(this, \'' + otroFieldId + '\')">' +
        '<option value="">Seleccionar rol…</option>' +
        opcionesHtml +
        '</select>' +
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
        '<path d="M6 9l6 6 6-6"/>' +
        '</svg>' +
        '</div>' +
        '<input type="text" class="form-input entity-otro-input" id="' + otroFieldId + '" ' +
        'name="roles_' + tipo + '[' + id + '][otros]" placeholder="Especificar otro rol" maxlength="30" hidden>' +
        '</div>' +
        '<button type="button" class="remove-entity-btn" onclick="removeEntityCard(this, \'' + tipo + '\', \'' + id + '\')" aria-label="Quitar">' +
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">' +
        '<path d="M18 6 6 18"/><path d="M6 6l12 12"/>' +
        '</svg>' +
        '</button>';

    container.appendChild(card);
}

//Quita la tarjeta y desmarca la fila correspondiente en la tabla
function removeEntityCard(button, tipo, id) {
    const card = button.closest('.selected-entity-card');
    if (card) card.remove();

    const row = document.querySelector('.selectable-row[data-tipo="' + tipo + '"][data-id="' + id + '"]');
    if (row) row.classList.remove('row-selected');
}
 




