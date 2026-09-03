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