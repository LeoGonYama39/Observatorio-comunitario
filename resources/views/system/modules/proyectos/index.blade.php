@extends('system.app')

@section('title', 'Proyectos · Centro Ibero Meneses')

@section('content')

      <div class="content-header">
        <div>
          <h1>Proyectos</h1>
          <p>Proyectos comunitarios activos y finalizados</p>
        </div>

        <button class="btn-new">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14"/><path d="M5 12h14"/>
          </svg>
          Nuevo registro
        </button>
      </div>

      <div class="table-toolbar">
        <div class="table-search">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>
          </svg>
          <input type="text" placeholder="Buscar por nombre…">
        </div>

        <button class="btn-filter">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 6h16"/><path d="M7 12h10"/><path d="M10 18h4"/>
          </svg>
          Filtro
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 9l6 6 6-6"/>
          </svg>
        </button>
      </div>

      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Líder</th>
            </tr>
          </thead>
          <tbody>
            <tr data-url="{{ route('proyectos.info') }}">
              <td>
                <div class="person-name">
                  <svg class="star-icon" width="13" height="13" viewBox="0 0 24 24" fill="#111111" stroke="#111111" stroke-width="1.5" stroke-linejoin="round">
                    <path d="M12 2.5l2.9 6.3 6.8.7-5.1 4.6 1.5 6.7L12 17.6l-6.1 3.2 1.5-6.7-5.1-4.6 6.8-.7Z"/>
                  </svg>
                  Huertos Comunitarios
                </div>
                <div class="person-role">Activo</div>
              </td>
              <td><span class="area-tag">María Torres Salinas</span></td>
            </tr>
            <tr>
              <td>
                <div class="person-name">Diagnóstico Comunitario</div>
                <div class="person-role">Activo</div>
              </td>
              <td><span class="area-tag">Roberto Gómez Iñárritu</span></td>
            </tr>
            <tr>
              <td>
                <div class="person-name">Salud Preventiva en Colonias</div>
                <div class="person-role">Finalizado</div>
              </td>
              <td><span class="area-tag">Ana Lucía Fernández Ruiz</span></td>
            </tr>
            <tr>
              <td>
                <div class="person-name">
                  <svg class="star-icon" width="13" height="13" viewBox="0 0 24 24" fill="#111111" stroke="#111111" stroke-width="1.5" stroke-linejoin="round">
                    <path d="M12 2.5l2.9 6.3 6.8.7-5.1 4.6 1.5 6.7L12 17.6l-6.1 3.2 1.5-6.7-5.1-4.6 6.8-.7Z"/>
                  </svg>
                  Biblioteca Comunitaria
                </div>
                <div class="person-role">Activo</div>
              </td>
              <td><span class="area-tag empty">—</span></td>
            </tr>
          </tbody>
        </table>
      </div>

@endsection