///// Para las tablas de los Index.

//Buscador por texto

//Función para inicializar el buscado por texto
function initTableSearch() {
    const searchInput = document.querySelector('.table-search input');
    const table = document.querySelector('.table-card table');

    if (!searchInput || !table) {
        return;
    }

    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function () {
        const search = this.value.toLowerCase().trim();

        rows.forEach(row => {
            const name = row.querySelector('.person-name');

            if (!name) {
                return;
            }

            const text = name.textContent.toLowerCase();

            row.style.display = text.includes(search) ? '' : 'none';
        });
    });
}




