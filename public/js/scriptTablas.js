//---------------------------------------------------------
//          Para las tablas de los index
//---------------------------------------------------------

//Función para inicializar el buscado por texto y filtrar la búsqueda
function initTableSearch() {
    document.querySelectorAll('.table-search input').forEach(searchInput => {
        if (searchInput.dataset.initialized === 'true') return;
        searchInput.dataset.initialized = 'true';

        searchInput.addEventListener('input', function () {
            runFiltering();
        });
    });
}

function initTablePagination() {
    const PAGE_SIZE = 20;

    document.querySelectorAll('.table-pagination').forEach(pagination => {
        // Evita inicializar dos veces el mismo bloque.
        if (pagination.dataset.initialized === 'true') return;
        pagination.dataset.initialized = 'true';

        // Busca la tabla asociada a esta paginación.
        const scope = pagination.closest('.entity-picker')
            || document.getElementById('mainContent');

        const table = scope
            ? scope.querySelector('.table-card table')
            : null;

        if (!table) return;

        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        const rows = Array.from(tbody.querySelectorAll('tr'));

        const info = pagination.querySelector('.table-pagination-info');
        const [prevBtn, nextBtn] = pagination.querySelectorAll(
            '.table-pagination-btn'
        );

        if (!info || !prevBtn || !nextBtn) return;

        let currentPage = 1;

        function renderPage() {
            const filteredRows = table._filteredRows ?? rows;
            const total = filteredRows.length;
            const totalPages = Math.ceil(total / PAGE_SIZE);

            // Si cambia la cantidad de resultados, evita páginas inválidas.
            currentPage = totalPages > 0
                ? Math.min(currentPage, totalPages)
                : 1;

            const startIndex = (currentPage - 1) * PAGE_SIZE;
            const endIndex = Math.min(startIndex + PAGE_SIZE, total);

            // Oculta las filas que no pertenecen a la página actual.
            rows.forEach(row => {
                row.hidden = true;
            });

            filteredRows.slice(startIndex, endIndex).forEach(row => {
                row.hidden = false;
            });

            // Actualiza el contador.
            const desde = total > 0 ? startIndex + 1 : 0;
            const hasta = endIndex;

            if(total == 0){
                info.textContent = 'Sin resultados';
            } else {
                info.textContent = `${desde}–${hasta} de ${total}`;
            }

            // Habilita o deshabilita las flechas.
            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage >= totalPages;
        }

        table._paginationReset = () => {
            currentPage = 1;
            renderPage();
        };

        prevBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                renderPage();
            }
        });

        nextBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(rows.length / PAGE_SIZE);

            if (currentPage < totalPages) {
                currentPage++;
                renderPage();
            }
        });

        // Muestra la primera página al inicializar.
        renderPage();
    });
}

//---------------------------------------------------------
//          Para las tablas de involucrados
//---------------------------------------------------------

//// Vincular participantes a un proyecto (selección en tabla + tarjeta de rol)

//Lee los roles reales desde data-roles-proyecto (impreso por Blade desde la BD,
//no una lista quemada aquí, para no desincronizarse con el enum real).
//Normaliza a arreglo plano de valores, sea que el JSON venga como array o como objeto.
function getRolesProyectoOpciones() {
    const container = document.querySelector('[data-roles-proyecto]');
    if (!container) return [];

    try {
        const datos = JSON.parse(container.dataset.rolesProyecto);
        return Array.isArray(datos) ? datos : Object.values(datos);
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
    // Solo existe en la tabla de externos: la participación a usar si se
    // selecciona esta fila DESDE CERO (persona nueva, o re-agregada a propósito)
    const participacionId = row.dataset.participacionId;
    // La bandera vive una sola vez en el contenedor del picker (la imprime el partial
    // según si recibió $roles), no repetida en el onclick de cada fila
    const picker = row.closest('.entity-picker');
    const conRoles = !picker || picker.dataset.conRoles !== '0';
    const container = document.getElementById('selected-' + tipo);
    const existing = container.querySelector('[data-card-id="' + id + '"]');

    if (existing) {
        existing.remove();
        row.classList.remove('row-selected');
    } else {
        row.classList.add('row-selected');
        addEntityCard(tipo, id, row.dataset.nombre, row.dataset.subtitle || '', participacionId, conRoles);
    }
}

//Crea la tarjeta con el dropdown de rol y el campo "otro" (oculto hasta elegir "Otro")
function addEntityCard(tipo, id, nombre, subtitle, participacionId, conRoles = true) {
    const container = document.getElementById('selected-' + tipo);
    const otroFieldId = 'otro_field_' + tipo + '_' + id;

    const card = document.createElement('div');
    card.className = 'selected-entity-card';
    card.setAttribute('data-card-id', id);

    // Con roles: dropdown + campo "otro". Sin roles (ej. talleristas): solo un hidden tipo[]
    // para que el id viaje en el POST (sin ningún input, la tarjeta no mandaría nada).
    let detalleHtml;
    if (conRoles) {
        const opcionesHtml = getRolesProyectoOpciones()
            .map(valor => '<option value="' + valor + '">' + formatRoleLabel(valor) + '</option>')
            .join('');

        detalleHtml =
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
    } else {
        detalleHtml = '<input type="hidden" name="' + tipo + '[]" value="' + id + '">';
    }

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
        detalleHtml +
        (participacionId
            ? '<input type="hidden" name="roles_' + tipo + '[' + id + '][participacion_id]" value="' + participacionId + '">'
            : '');

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


//// Selector de UNA sola persona (partial single_entity_picker)
//Depende de syncFieldGroupDisabled(), que ya vive en ScriptVarios.js.
//No guarda estado en variables sueltas: todo vive en el DOM, así que no necesita
//reinicializarse en initPageScripts (Blade ya deja pintado el estado inicial).
 
//Click en una fila: selecciona esa persona (deselecciona la anterior) o, si ya era
//la seleccionada, la quita. Las filas de gente ya registrada solo muestran un aviso.
function selectSingleEntity(row) {
    const name = row.dataset.single;
    const picker = row.closest('[data-single-picker]');
    if (!picker) return;
 
    if (row.dataset.registrado === '1') {
        showSingleNotice(name);
        return;
    }
    hideSingleNotice(name);
 
    const eraLaSeleccionada = row.classList.contains('row-selected');
    picker.querySelectorAll('.selectable-row.row-selected').forEach(r => r.classList.remove('row-selected'));
 
    if (eraLaSeleccionada) {
        setSingleSelection(name, null);
        return;
    }
 
    row.classList.add('row-selected');
    setSingleSelection(name, {
        id: row.dataset.id,
        nombre: row.dataset.nombre,
        subtitle: row.dataset.subtitle || '',
        detalles: parseDetalles(row.dataset.detalles),
    });
}
 
//Botón ✕ de la tarjeta
function clearSingleEntity(name) {
    const picker = document.querySelector('[data-single-picker="' + name + '"]');
    if (picker) {
        picker.querySelectorAll('.selectable-row.row-selected').forEach(r => r.classList.remove('row-selected'));
    }
    hideSingleNotice(name);
    setSingleSelection(name, null);
}
 
//Actualiza el hidden que viaja en el POST, la tarjeta y los campos que dependen de la selección
function setSingleSelection(name, persona) {
    const input = document.getElementById('single-value-' + name);
    const container = document.getElementById('selected-single-' + name);
    if (!input || !container) return;
 
    container.innerHTML = '';
    input.value = persona ? persona.id : '';
    if (persona) container.appendChild(buildSingleCard(name, persona));
 
    //Muestra/oculta (y habilita/deshabilita) los campos que dependen de haber elegido a alguien
    document.querySelectorAll('[data-depende-de="' + name + '"]').forEach(contenedor => {
        contenedor.hidden = !persona;
        syncFieldGroupDisabled(contenedor);
    });
}
 
//Tarjeta con nombre, subtítulo, datos y botón de quitar.
//Se arma con textContent (no innerHTML) para que un nombre con caracteres raros no inyecte HTML.
function buildSingleCard(name, persona) {
    const card = document.createElement('div');
    card.className = 'selected-entity-card';
    card.setAttribute('data-card-id', persona.id);
 
    const head = document.createElement('div');
    head.className = 'entity-card-head';
 
    const info = document.createElement('div');
    info.className = 'entity-info';
 
    const nombreEl = document.createElement('div');
    nombreEl.className = 'person-name';
    nombreEl.textContent = persona.nombre;
    info.appendChild(nombreEl);
 
    if (persona.subtitle) {
        const subtitleEl = document.createElement('div');
        subtitleEl.className = 'person-role';
        subtitleEl.textContent = persona.subtitle;
        info.appendChild(subtitleEl);
    }
 
    const quitar = document.createElement('button');
    quitar.type = 'button';
    quitar.className = 'remove-entity-btn';
    quitar.setAttribute('aria-label', 'Quitar');
    quitar.addEventListener('click', () => clearSingleEntity(name));
    quitar.innerHTML =
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">' +
            '<path d="M18 6 6 18"/><path d="M6 6l12 12"/>' +
        '</svg>';
 
    head.appendChild(info);
    head.appendChild(quitar);
    card.appendChild(head);
 
    const detalles = Object.entries(persona.detalles || {});
    if (detalles.length) {
        const grid = document.createElement('div');
        grid.className = 'info-grid';
 
        detalles.forEach(([etiqueta, valor]) => {
            const field = document.createElement('div');
            field.className = 'info-field';
 
            const label = document.createElement('label');
            label.textContent = etiqueta;
 
            const value = document.createElement('div');
            value.className = 'value' + (valor ? '' : ' empty');
            value.textContent = valor || '-';
 
            field.appendChild(label);
            field.appendChild(value);
            grid.appendChild(field);
        });
 
        card.appendChild(grid);
    }
 
    return card;
}
 
function parseDetalles(raw) {
    try {
        return JSON.parse(raw || '{}');
    } catch (e) {
        console.error('No se pudo leer data-detalles', e);
        return {};
    }
}
 
//Aviso al hacer clic en alguien ya registrado: se muestra unos segundos y se oculta solo
function showSingleNotice(name) {
    const notice = document.getElementById('single-notice-' + name);
    if (!notice) return;
 
    notice.hidden = false;
    clearTimeout(notice._timeout);
    notice._timeout = setTimeout(() => { notice.hidden = true; }, 3500);
}
 
function hideSingleNotice(name) {
    const notice = document.getElementById('single-notice-' + name);
    if (!notice) return;
 
    clearTimeout(notice._timeout);
    notice.hidden = true;
}