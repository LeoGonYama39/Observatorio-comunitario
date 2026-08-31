<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="{{ asset('assets/logo.png') }}" alt="Centro Ibero Meneses" />
  </div>
  <div class="nav-scroll">
    <nav>
      <button class="nav-item">
        <svg
               width="18"
               height="18"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="1.8"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <rect x="3" y="3" width="7" height="7" rx="1.5" />
          <rect x="14" y="3" width="7" height="7" rx="1.5" />
          <rect x="3" y="14" width="7" height="7" rx="1.5" />
          <rect x="14" y="14" width="7" height="7" rx="1.5" />
        </svg>
        Áreas
      </button>
      <button class="nav-item parent-active">
        <svg
               width="18"
               height="18"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="1.8"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
          <circle cx="9" cy="7" r="4" />
          <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
          <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        Personas
        <svg
               class="chevron"
               width="15"
               height="15"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="2"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path d="M9 6l6 6-6 6" />
        </svg>
      </button>
      <div class="submenu">
        <a href="{{ route('p_centro.index') }}" data-url="{{ route('p_centro.index') }}" 
        class="sub-item {{ request()->routeIs('p_centro.*') ? 'active' : '' }}">
          Centro
        </a>
        <a href="{{ route('p_externo.index') }}" data-url="{{ route('p_externo.index') }}" 
        class="sub-item {{ request()->routeIs('p_externo.*') ? 'active' : '' }}">
          Externas
        </a>
        <a href="{{ route('p_comunidad.index') }}" data-url="{{ route('p_comunidad.index') }}" 
        class="sub-item {{ request()->routeIs('p_comunidad.*') ? 'active' : '' }}">
         Usuarias
        </a>
        <a href="#" class="sub-item">
          Lideres comun.
        </a>
        <a href="#" class="sub-item">
          Dir. de saberes
        </a>
      </div>
      <a
            class="nav-item {{ request()->routeIs('proyectos.*') ? 'active' : '' }}"
            href="{{ route('proyectos.index') }}" data-url="{{ route('proyectos.index') }}"
         >
        <svg
               width="18"
               height="18"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="1.8"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path d="M9 11l3 3L22 4" />
          <path
                  d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"
               />
        </svg>
        Proyectos
      </a>
      <button class="nav-item parent-active">
        <svg
               width="18"
               height="18"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="1.8"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path
                  d="M3 7a2 2 0 0 1 2-2h4l2 2.5h7a2 2 0 0 1 2 2V17a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2Z"
               />
        </svg>
        Casos
        <svg
               class="chevron"
               width="15"
               height="15"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="2"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path d="M9 6l6 6-6 6" />
        </svg>
      </button>
      <div class="submenu">
        <a href="#" class="sub-item icon-sub">
          <svg
                  width="14"
                  height="14"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke-width="1.8"
                  stroke-linecap="round"
                  stroke-linejoin="round"
               >
            <path d="M12 3v18" />
            <path d="M5 7l-3 6a3 3 0 0 0 6 0Z" />
            <path d="M19 7l-3 6a3 3 0 0 0 6 0Z" />
            <path d="M5 7h14" />
            <path d="M8 21h8" />
          </svg>
          Asesoría jurídica
        </a>
      </div>
      <button class="nav-item parent-active">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
        </svg>
        Educación
        <svg class="chevron" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 6l6 6-6 6"/>
        </svg>
      </button>
      <div class="submenu">
        <a href="{{ route('educ_basica.index') }}" data-url="{{ route('educ_basica.index') }}" class="sub-item {{ request()->
          routeIs('educ_basica.*') ? 'active' : '' }}">
              Educación básica
        </a>
        <a href="#" class="sub-item">
          Educación media-superior
        </a>
        <a href="ststema_materias.html" class="sub-item">
          Materias
        </a>
        <a href="{{ route('psicopedag.index') }}" data-url="{{ route('psicopedag.index') }}" 
        class="sub-item {{ request()->routeIs('psicopedag.*') ? 'active' : '' }}">
          Psicopedagogía
        </a>
      </div>
        <a 
            class="nav-item {{ request()->
            routeIs('talleres.*') ? 'active' : '' }}"
            href="{{ route('talleres.index') }}" data-url="{{ route('talleres.index') }}"
         >
        <svg
               width="18"
               height="18"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="1.8"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path d="M14.7 6.3a4 4 0 1 1-5.4 5.4L2 19v3h3l7.3-7.3" />
          <path d="M17.5 3.5 20.5 6.5" />
          <path d="M15 9l5-5" />
        </svg>
        Talleres
      </a>
      <a class="nav-item {{ request()->routeIs('eventos.*') ? 'active' : '' }}" 
        href="{{ route('eventos.index') }}" data-url="{{ route('eventos.index') }}">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="5" width="18" height="16" rx="2"/>
          <path d="M16 3v4"/>
          <path d="M8 3v4"/>
          <path d="M3 10h18"/>
          <circle cx="8.5" cy="14.5" r="1.2" fill="currentColor" stroke="none"/>
        </svg>
        Eventos/Charlas
      </a>
      <a class="nav-item {{ request()->routeIs('colonias.*') ? 'active' : '' }}" 
        href="{{ route('colonias.index') }}" data-url="{{ route('colonias.index') }}">
        <svg
               width="18"
               height="18"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="1.8"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path d="M3 10.5 12 3l9 7.5" />
          <path d="M5 9.5V21h14V9.5" />
          <path d="M10 21v-6h4v6" />
        </svg>
        Colonias
</a>
      <button class="nav-item">
        <svg
               width="18"
               height="18"
               viewBox="0 0 24 24"
               fill="none"
               stroke-width="1.8"
               stroke-linecap="round"
               stroke-linejoin="round"
            >
          <path d="M4 21V8l8-5 8 5v13" />
          <path d="M9 21v-7h6v7" />
          <path d="M4 12h16" />
        </svg>
        Espacios históricos
      </button>
    </nav>
  </div>
  <div class="sidebar-logout">
    <form method="POST" action="{{ route('logout') }}">
      <button class="nav-item">
        <svg
            width="18"
            height="18"
            viewBox="0 0 24 24"
            fill="none"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round"
         >
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          <path d="M16 17l5-5-5-5" />
          <path d="M21 12H9" />
        </svg>
        Cerrar sesión
      </button>
    </form>
  </div>
</aside>