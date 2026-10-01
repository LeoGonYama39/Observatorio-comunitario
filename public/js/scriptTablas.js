//---------------------------------------------------------
//          Para las tablas de los index
//---------------------------------------------------------

//Función para inicializar el buscado por texto y filtrar la búsqueda
function initTableSearch() {
    document.querySelectorAll('.table-search input').forEach(searchInput => {   //Se hace así para que sirva si hay más de una tabla del mismo tipo
        const scope = searchInput.closest('.entity-picker') || document.getElementById('mainContent');
        const table = scope ? scope.querySelector('.table-card table') : null;

        if (!table) { return; }

        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function () {
            const search = this.value.toLowerCase().trim();

            rows.forEach(row => {
                const name = row.querySelector('.person-name');
                if (!name) { return; }
                const text = name.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        });
    });
}


//---------------------------------------------------------
//          Para las tablas de involucrados
//---------------------------------------------------------

//// Vincular participantes a un proyecto (selección en tabla + tarjeta de rol)

//Lee los roles reales desde data-roles-proyecto (impreso por Blade desde la BD,
//no una lista quemada aquí, para no desincronizarse con el enum real)
function getRolesProyectoOpciones() {
    const container = document.querySelector('[data-roles-proyecto]');
    if (!container) return [];

    try {
        return JSON.parse(container.dataset.rolesProyecto);
    } catch (e) {
        console.error('No se pudo leer data-roles-proyecto', e);
        return [];
    }
}

//Mismo formato que usa Blade: guiones bajos a espacios + primera letra mayúscula
function formatRoleLabel(valor) {
    const conEspacios = valor.replace(/_/g, ' ');
    return conEspacios.charAt(0).toUpperCase() + conEspacios.slice(1);
}

//Click en una fila de cualquiera de las 4 tablas: selecciona o deselecciona
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

//Crea la tarjeta con el dropdown de rol y el campo "otro" (oculto hasta elegir "Otro")
function addEntityCard(tipo, id, nombre, subtitle) {
    const container = document.getElementById('selected-' + tipo);
    const otroFieldId = 'otro_field_' + tipo + '_' + id;

    const opcionesHtml = getRolesProyectoOpciones()
        .map(valor => '<option value="' + valor + '">' + formatRoleLabel(valor) + '</option>')
        .join('');

    const card = document.createElement('div');
    card.className = 'selected-entity-card';
    card.setAttribute('data-card-id', id);

    card.innerHTML =
        '<div class="entity-card-head">' +
        '<div class="entity-info">' +
        '<div class="person-name"></div>' +
        '<div class="person-role"></div>' +
        '</div>' +
        '<button type="button" class="remove-entity-btn" aria-label="Quitar" ' +
        'onclick="removeEntityCard(this, \'' + tipo + '\', \'' + id + '\')">' +
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">' +
        '<path d="M18 6 6 18"/><path d="M6 6l12 12"/>' +
        '</svg>' +
        '</button>' +
        '</div>' +
        '<div class="entity-rol-group">' +
        '<div class="select-shell">' +
        '<select class="form-select" required name="roles_' + tipo + '[' + id + '][rol]" ' +
        'onchange="onEntityRolChange(this, \'' + otroFieldId + '\')">' +
        '<option value="">Seleccionar rol…</option>' +
        opcionesHtml +
        '</select>' +
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' +
        '<path d="M6 9l6 6 6-6"/>' +
        '</svg>' +
        '</div>' +
        '<input type="text" class="form-input" id="' + otroFieldId + '" ' +
        'name="roles_' + tipo + '[' + id + '][otros]" placeholder="Especificar otro rol" maxlength="30" hidden>' +
        '</div>';

    //textContent (no innerHTML) para que un nombre con caracteres raros no rompa ni inyecte HTML
    card.querySelector('.person-name').textContent = nombre;
    const roleEl = card.querySelector('.person-role');
    if (subtitle) {
        roleEl.textContent = subtitle;
    } else {
        roleEl.remove();
    }

    container.appendChild(card);
}

//Muestra el input "otro" solo si el rol elegido es "otro", y lo vacía si se cambia a otro rol
//(así un texto viejo escondido no viaja en el POST)
function onEntityRolChange(select, otroFieldId) {
    const otro = document.getElementById(otroFieldId);
    if (!otro) return;

    const esOtro = select.value === 'otro';
    otro.hidden = !esOtro;
    if (!esOtro) otro.value = '';
}

//Botón ✕ de la tarjeta: la quita y desmarca la fila en la tabla
function removeEntityCard(button, tipo, id) {
    const card = button.closest('.selected-entity-card');
    if (card) card.remove();

    const row = document.querySelector('.selectable-row[data-tipo="' + tipo + '"][data-id="' + id + '"]');
    if (row) row.classList.remove('row-selected');
}

//Buscador de cada tabla (oninput desde el <input>); filtra solo dentro de su propio .entity-picker
function filterEntityRows(input) {
    const picker = input.closest('.entity-picker');
    if (!picker) return;

    const search = input.value.toLowerCase().trim();
    picker.querySelectorAll('.selectable-row').forEach(row => {
        const name = row.querySelector('.person-name');
        if (!name) return;
        row.style.display = name.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
}

