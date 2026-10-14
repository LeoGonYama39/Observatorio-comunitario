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

    gestionMenuParent(elemento);

    //GET a url
    navigateTo(url, 2);
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
        gestionMenuParent(this);

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
// Espera antes de mostrar el "cargando": si la respuesta llega rápido no se ve parpadear
const LOADING_DELAY_MS = 200;
// Controla la navegación en curso, para cancelarla si el usuario hace clic en otra opción
let navigationController = null;
 
//Reemplaza el contenido de #mainContent con una de las plantillas de loading.blade.php
//('loadingTemplate' o 'loadErrorTemplate'). Si recibe onRetry, lo engancha al botón "Reintentar".
function showMainContentState(templateId, onRetry) {
  const template = document.getElementById(templateId);
  const mainContent = document.getElementById('mainContent');
  if (!template || !mainContent) { return; }
 
  mainContent.innerHTML = '';
  mainContent.appendChild(template.content.cloneNode(true));
 
  if (onRetry) {
    const retryBtn = mainContent.querySelector('[data-retry]');
    if (retryBtn) { retryBtn.addEventListener('click', onRetry); }
  }
}
 
///Función para navegar a hacer un get a un url,
///esperar la respuesta y reemplazar el contenido
async function navigateTo(url, tipo) {
    // Si todavía hay una navegación en curso, se cancela: así una respuesta lenta
    // no pisa a la más reciente
    if (navigationController) { navigationController.abort(); }
    navigationController = new AbortController();
    const controller = navigationController;
 
    const loadingTimer = setTimeout(() => showMainContentState('loadingTemplate'), LOADING_DELAY_MS);
 
    try{
      const res = await fetch(url,   {
        headers:   {
          'X-Requested-With': 'XMLHttpRequest'
        },
        signal: controller.signal
      });
 
      if (!res.ok) throw new Error('Error al cargar la sección');
 
      //Laravel responde con un json con varias cosas
      const data = await res.json();

      // Si mientras tanto el usuario pidió otra sección, esta respuesta ya no importa
      if (controller.signal.aborted) { return; }
 
      //Reempazar
      document.getElementById('mainContent').innerHTML = data.content;
      document.title = data.title;
 
      //Reinicializar los scripts que dependen de elementos del contenido nuevo
      //(slider de población objetivo, selector de casos, etc.)
      if (typeof initPageScripts === 'function') {
        initPageScripts();
      }
 
      if(tipo === 1){
        //Actualizo la barra de enlace, sin recargar
        window.history.pushState({}, '', url);
      }
    } catch (err)   {
      // Cancelada a propósito por otra navegación: no es un error
      if (err.name === 'AbortError') { return; }
 
      console.error(err);
      // Sin esto, el "cargando" se quedaría para siempre
      showMainContentState('loadErrorTemplate', () => navigateTo(url, tipo));
    } finally {
      clearTimeout(loadingTimer);
      if (navigationController === controller) { navigationController = null; }
    }
}


function gestionMenuParent(elemento){
    if (elemento.classList.contains('sub-item')) {
        elemento.classList.add('active');

        // Busca el nav-item padre (el submenu siempre es su hermano justo después)
        const submenu = elemento.closest('.submenu');
        const parentNavItem = submenu ? submenu.previousElementSibling : null;
        if (parentNavItem) parentNavItem.classList.add('section-active');
    } else {
        elemento.classList.add('active');
    }
}
