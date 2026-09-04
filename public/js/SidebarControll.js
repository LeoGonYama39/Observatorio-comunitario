//Apunto a los elementos
const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
const sidebarBackdrop = document.getElementById('sidebarBackdrop');
const MOBILE_BREAKPOINT = 900; //DEFINE de la dimención a la que cambia

//Función para mostrar sidebar
function toggleSidebar()  {
  document.body.classList.toggle('sidebar-toggled');
}

//Función para ocultar sidebar
function closeSidebar()  {
  document.body.classList.remove('sidebar-toggled');
}

//Evento click para los botones
sidebarToggleBtn.addEventListener('click', toggleSidebar);
sidebarBackdrop.addEventListener('click', closeSidebar);

let wasMobile = window.innerWidth <=
MOBILE_BREAKPOINT;
window.addEventListener('resize', () =>  {
  const isMobile = window.innerWidth <=
  MOBILE_BREAKPOINT;
  if (isMobile !== wasMobile)  {
    closeSidebar();
    wasMobile = isMobile;
  }
});



//---------------------------ç
//Función para navegación AJAX con elementos que aparecen y desaparecen del main-content
//Agregar los elementos correspondientes a closest si hay nuevos
document.addEventListener('click', function(e) {
  const elemento = e.target.closest(
    'tr[data-url], a.return-index[data-url], a.btn-new[data-url], a.btn-outline[data-url]');
  if (!elemento){
    return;
  } else {
    e.preventDefault();
    const url = elemento.getAttribute('data-url');
    navigateTo(url, 1);
  }  
});


// Soporte para botones Atrás/Adelante del navegador
//Agrego evento a popstate
window.addEventListener('popstate', async () =>   {

  clearActiveStates();
  
  //Obtengo el nuevo url al que salté con atrás o adelante
  const url = location.href;
  const elemento = [...document.querySelectorAll(
        '.sidebar .sub-item[data-url], .sidebar .nav-item[data-url]'
    )].find(el => {
        const dataUrl = el.getAttribute('data-url');
        return url.includes(dataUrl);
    });

    if (elemento.classList.contains('sub-item')) {
        elemento.classList.add('active');

        // Busca el nav-item padre (el submenu siempre es su hermano justo después)
        const submenu = elemento.closest('.submenu');
        const parentNavItem = submenu ? submenu.previousElementSibling : null;
        if (parentNavItem) parentNavItem.classList.add('section-active');
      } else {
        elemento.classList.add('active');
    }


  //GET a url
  navigateTo(url, 2)
});

//Control de los submenus
document.querySelectorAll('.sidebar .nav-item.has-submenu').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        this.classList.toggle('parent-active');
    });
});

document.querySelectorAll('.sidebar .nav-item[data-url], .sidebar .sub-item[data-url]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();

        clearActiveStates();

        if (this.classList.contains('sub-item')) {
            this.classList.add('active');

            // Busca el nav-item padre (el submenu siempre es su hermano justo después)
            const submenu = this.closest('.submenu');
            const parentNavItem = submenu ? submenu.previousElementSibling : null;
            if (parentNavItem) parentNavItem.classList.add('section-active');
        } else {
            this.classList.add('active');
        }

        if (window.innerWidth <= MOBILE_BREAKPOINT && typeof closeSidebar === 'function') {
            closeSidebar();
        }

        navigateTo(this.getAttribute('data-url'), 1);
    });
});


//-------------------------
//Funciones de apoyo
//-------------------------

//Función para limpiar todos los active y setction-active de la sidebar
function clearActiveStates() {
    document.querySelectorAll('.sidebar .nav-item').forEach(el => {
        el.classList.remove('active', 'section-active');
    });
    document.querySelectorAll('.sidebar .sub-item').forEach(el => {
        el.classList.remove('active');
    });
}

//Función para el control de los botones active o no active
//Para poder hacerlo con click o popstate
function actualizarActivo(url)   {
  // Quitar active de todos
  document
  .querySelectorAll('.sidebar .sub-item, .sidebar .nav-item')
  .forEach(el => el.classList.remove('active'));
  // Buscar el botón cuya data-url coincide con la URL actual
  const elemento = document.querySelector(
  `.sidebar [data-url="${url}"]`
  );
  // Activarlo
  if (elemento)   {
    elemento.classList.add('active');
  }
}


///Función para navegar a hacer un get a un url,
///esperar la respuesta y reemplazar el contenido
async function navigateTo(url, tipo) {
    try{
      const res = await fetch(url,   {
        headers:   {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      if (!res.ok) throw new Error('Error al cargar la sección');
      
      //Laravel responde con un json con varias cosas
      const data = await res.json();
      
      //Reempazar
      document.getElementById('mainContent').innerHTML = data.content;
      document.title = data.title;
      
      if(tipo === 1){
        //Actualizo la barra de enlace, sin recargar
        window.history.pushState({}, '', url);} 
      } catch (err)   {
      console.error(err);
      }
}