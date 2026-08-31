<!DOCTYPE html>
<html lang="es">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
      @yield('title', 'Centro Ibero Meneses')
    </title>

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

    <div class="sidebar-backdrop" id="sidebarBackdrop">
    </div>
    <script src="{{ asset('js/SidebarControll.js') }}"></script>
  </body>
</html>