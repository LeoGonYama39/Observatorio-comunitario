<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Centro Ibero Meneses')</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('css/estilo_sistema.css') }}">
</head>
<body>

  @include('system.parts.sidebar')

  <div class="main-area">
    @include('system.parts.topbar')

    <main class="content" id="mainContent">
      @yield('content')
    </main>
  </div>

  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

  {{-- Script de interfaz y navegación dinámica --}}
  <script>
    // Toggle y colapso de sidebar
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const MOBILE_BREAKPOINT = 900;

    function toggleSidebar() {
      document.body.classList.toggle('sidebar-toggled');
    }

    function closeSidebar() {
      document.body.classList.remove('sidebar-toggled');
    }

    sidebarToggleBtn.addEventListener('click', toggleSidebar);
    sidebarBackdrop.addEventListener('click', closeSidebar);

    let wasMobile = window.innerWidth <= MOBILE_BREAKPOINT;
    window.addEventListener('resize', () => {
      const isMobile = window.innerWidth <= MOBILE_BREAKPOINT;
      if (isMobile !== wasMobile) {
        closeSidebar();
        wasMobile = isMobile;
      }
    });

    // Selecciona todos los elementos navegables del sidebar (.nav-item y .sub-item)
    document.querySelectorAll('.sidebar .nav-item[data-url], .sidebar .sub-item[data-url]').forEach(link => {
    link.addEventListener('click', async function(e) {
        // 1. Evita que el navegador recargue la página completa
        e.preventDefault();

        const url = this.getAttribute('data-url');
        if (!url) return;

        // 2. Gestionar clases visuales activas
        document.querySelectorAll('.sidebar .sub-item, .sidebar .nav-item').forEach(el => el.classList.remove('active'));
        this.classList.add('active');

        // 3. Cerrar sidebar en dispositivos móviles
        if (window.innerWidth <= MOBILE_BREAKPOINT && typeof closeSidebar === 'function') {
        closeSidebar();
        }

        // 4. Petición AJAX limpia
        try {
        const res = await fetch(url, {
            headers: { 
            'X-Requested-With': 'XMLHttpRequest' 
            }
        });

        if (!res.ok) throw new Error('Error al cargar la sección');
        
        const html = await res.text();
        document.getElementById('mainContent').innerHTML = html;

        // 5. Actualiza la barra de direcciones sin recargar
        window.history.pushState({ path: url }, '', url);
        } catch (err) {
        console.error(err);
        }
    });
    });

    // Soporte para botones Atrás/Adelante del navegador
    window.addEventListener('popstate', async () => {
      const res = await fetch(location.href, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      });
      if (res.ok) {
        document.getElementById('mainContent').innerHTML = await res.text();
      }
    });
  </script>
</body>
</html>