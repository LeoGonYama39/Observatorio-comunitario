<header class="topbar">
  <a
      class="back-btn"
      title="Ir al menú principal"
      href="{{ route('dashboard') }}"
   >
    <svg
         width="17"
         height="17"
         viewBox="0 0 24 24"
         fill="none"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
      >
      <path
            d="M3 9.5 12 2l9 7.5V21a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-6h-2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Z"
         />
    </svg>
  </a>
  <button
      class="sidebar-toggle-btn"
      id="sidebarToggleBtn"
      title="Mostrar u ocultar menú"
   >
    <svg
         width="17"
         height="17"
         viewBox="0 0 24 24"
         fill="none"
         stroke-width="1.8"
         stroke-linecap="round"
         stroke-linejoin="round"
      >
      <rect x="3" y="4" width="18" height="16" rx="2.5" />
      <path d="M9.5 4v16" />
    </svg>
  </button>
  <div class="search-shell">
    <svg
         width="16"
         height="16"
         viewBox="0 0 24 24"
         fill="none"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round"
      >
      <circle cx="11" cy="11" r="7" />
      <path d="m21 21-4.3-4.3" />
    </svg>
    <input type="text" placeholder="Buscar personas, proyectos, talleres…" />
  </div>
  <div class="user-chip">
    <div class="avatar">
      LG
    </div>
    <span>
      Leo González
    </span>
  </div>
</header>