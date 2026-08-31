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
document.querySelectorAll('.sidebar .nav-item[data-url], .sidebar .sub-item[data-url]').forEach(link =>   {
  link.addEventListener('click', async function(e)   {
    //Evito que el navegador haga su función por defecto
    e.preventDefault();
    //Obtengo el url, viene de la etiqueta del HTML
    const url = this.getAttribute('data-url');
    if (!url) return;
    //Gestiono los active
    actualizarActivo(url)
    //Cierro la sidebar si estaba en modo ocultar
    if (window.innerWidth <=
    MOBILE_BREAKPOINT && typeof closeSidebar === 'function')   {
      closeSidebar();
    }
    //Petición GET a url, con fetch y await
    try   {
      const res = await fetch(url,   {
        headers:   {
          'X-Requested-With': 'XMLHttpRequest'
        }
      }
      );
      if (!res.ok) throw new Error('Error al cargar la sección');
      //Laravel responde con un json con varias cosas
      const data = await res.json();
      //Reempazar
      document.getElementById('mainContent').innerHTML = data.content;
      document.title = data.title;
      //Actualizo la barra de enlace, sin recargar
      window.history.pushState(  {
      }
      , '', url);
    } catch (err)   {
      console.error(err);
    }
  });
});


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