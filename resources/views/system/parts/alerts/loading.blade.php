{{--
  Plantillas que usa SidebarControll.js mientras #mainContent espera la respuesta del servidor.
  Van FUERA de #mainContent (ese contenedor se reemplaza en cada navegación), y se incluyen
  una sola vez en app.blade.php:  @include('system.parts.loading')
  El contenido de un <template> no se dibuja ni se ejecuta hasta que el JS lo clona.
--}}
<template id="loadingTemplate">
  <div class="loading-state" role="status" aria-live="polite">
    <div class="loading-spinner" aria-hidden="true"></div>
    <p class="loading-text">Cargando…</p>
  </div>
</template>

<template id="loadErrorTemplate">
  <div class="empty-state" role="alert">
    <div class="empty-state-icon">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="9"/>
        <path d="M12 8v5"/>
        <path d="M12 16.5h.01"/>
      </svg>
    </div>
    <h2>No se pudo cargar la sección</h2>
    <p>Revisa tu conexión e inténtalo de nuevo.</p>
    <button type="button" class="btn-outline" data-retry>
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 12a9 9 0 1 1-3-6.7"/>
        <path d="M21 4v5h-5"/>
      </svg>
      Reintentar
    </button>
  </div>
</template>