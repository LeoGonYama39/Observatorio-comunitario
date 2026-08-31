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


//Evento Click para cada elemento del sidebar
//Linkeo cada botón


// Listener para las filas de las tablas
document.addEventListener('click', function(e) {
    
    const row = e.target.closest('tr[data-url]');
    if (!row){
      return; 
    } else {
      e.preventDefault();
      const url = row.getAttribute('data-url');
    navigateTo(url);
    } 
});


// Listener para regresar al index
document.addEventListener('click', function(e) {
    const link = e.target.closest('a.return-index');
    if (!link){
return;
    } else {
      e.preventDefault();
    const url = link.getAttribute('data-url');
    navigateTo(url);
    }
    
});

///Función para navegar a hacer un get a un url,
///esperar la respuesta y reemplazar el contenido

async function navigateTo(url) {
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
      
      //Actualizo la barra de enlace, sin recargar
      window.history.pushState({}, '', url);} catch (err)   {
      console.error(err);
    }
}


// Soporte para botones Atrás/Adelante del navegador
//Agrego evento a popstate
window.addEventListener('popstate', async () =>   {
  //Obtengo el nuevo url al que salté con atrás o adelante
  const url = location.href;
  //Gestiono los active
  actualizarActivo(url);
  //GET a url
  const res = await fetch(url,   {
    headers:   {
      'X-Requested-With': 'XMLHttpRequest'
    }
  }
  );
  //Lo mismo que con click
  if (res.ok)   {
    const data = await res.json();
    document.getElementById('mainContent').innerHTML = data.content;
    document.title = data.title;
  }
});


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

//Control de los submenus
document.querySelectorAll('.sidebar .nav-item.has-submenu').forEach(item => {
    item.addEventListener('click', function(e) {
        e.preventDefault();
        this.classList.toggle('parent-active');
    });
});

function clearActiveStates() {
    document.querySelectorAll('.sidebar .nav-item').forEach(el => {
        el.classList.remove('active', 'section-active');
    });
    document.querySelectorAll('.sidebar .sub-item').forEach(el => {
        el.classList.remove('active');
    });
}

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

        navigateTo(this.getAttribute('data-url'));
    });
});