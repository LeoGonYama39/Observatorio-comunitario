//// Editar grupo de un taller (selección de alumnos + checkbox de baja)

//Click en una fila de la tabla: selecciona o deselecciona
function toggleAlumnoSelection(row) {
    const id = row.dataset.id;
    const container = document.getElementById('selected-alumnos');
    const existing = container.querySelector('[data-card-id="' + id + '"]');

    if (existing) {
        existing.remove();
        row.classList.remove('row-selected');
    } else {
        row.classList.add('row-selected');
        addAlumnoCard(id, row.dataset.nombre, row.dataset.subtitle || '');
    }
}

//Crea la tarjeta con el checkbox de baja (desmarcado por defecto: alguien recién
//agregado no debería empezar como dado de baja)
function addAlumnoCard(id, nombre, subtitle) {
    const container = document.getElementById('selected-alumnos');

    const card = document.createElement('div');
    card.className = 'selected-entity-card alumno-card';
    card.setAttribute('data-card-id', id);

    card.innerHTML =
        '<div class="entity-info">' +
        '<div class="person-name"></div>' +
        '<div class="person-role"></div>' +
        '</div>' +
        '<label class="baja-toggle" for="baja_' + id + '">' +
        '<input type="checkbox" id="baja_' + id + '" name="baja[' + id + ']" value="1">' +
        'Dado de baja' +
        '</label>' +
        '<button type="button" class="remove-entity-btn" aria-label="Quitar" ' +
        'onclick="removeAlumnoCard(this, \'' + id + '\')">' +
        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">' +
        '<path d="M18 6 6 18"/><path d="M6 6l12 12"/>' +
        '</svg>' +
        '</button>' +
        '<input type="hidden" name="grupo[]" value="' + id + '">';

    //textContent (no innerHTML) para que un nombre con caracteres raros no rompa ni inyecte HTML
    card.querySelector('.person-name').textContent = nombre;
    const subtitleEl = card.querySelector('.person-role');
    if (subtitle) {
        subtitleEl.textContent = subtitle;
    } else {
        subtitleEl.remove();
    }

    container.appendChild(card);
}

//Botón ✕ de la tarjeta: la quita y desmarca la fila en la tabla
function removeAlumnoCard(button, id) {
    const card = button.closest('.selected-entity-card');
    if (card) card.remove();

    const row = document.querySelector('.selectable-row[data-id="' + id + '"]');
    if (row) row.classList.remove('row-selected');
}
