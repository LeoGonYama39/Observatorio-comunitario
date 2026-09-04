//Scripts varios para la interacción de las cosas en main-content

//Toggle de la vista de detalles de generación en talleres y procesos grupales
function toggleBreakdown(btn) {
    const panel = btn.nextElementSibling;
    if (panel.hasAttribute('hidden')) {
        panel.removeAttribute('hidden');
        btn.classList.add('open');
    } else {
        panel.setAttribute('hidden', '');
        btn.classList.remove('open');
    }
}

//Toggle de las materias en educación
function toggleMateria(box) {
    box.classList.toggle('done');
    const check = box.querySelector('.check-circle');
    check.innerHTML = box.classList.contains('done')
      ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>'
      : '';
}

//Toggle del checkbox para toggle de crear usuario en p_centro
function toggleAccesoFields(checkbox) {
    const fields = document.getElementById('accesoFields');
    fields.hidden = !checkbox.checked;
}


//Toggle para mostrar o no contraseña
function togglePasswordField() {
    const input = document.getElementById('password_field');
    const icon = document.getElementById('eye-icon-form');
    const visible = input.type === 'text';
    input.type = visible ? 'password' : 'text';
    icon.innerHTML = visible
        ? '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>'
        : '<path d="M3 3l18 18"/><path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path d="M9.5 5.3A9.8 9.8 0 0 1 12 5c6.5 0 10 7 10 7a15.6 15.6 0 0 1-3.4 4.4M6.6 6.6C4 8.3 2 12 2 12s3.5 7 10 7a9.7 9.7 0 0 0 4-.8"/>';
}