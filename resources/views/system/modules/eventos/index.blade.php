@extends('system.app')

@section('title', 'Eventos · Centro Ibero Meneses')

@section('content')
<div class="content-header">
  <div>
    <h1>
      Eventos/Charlas
    </h1>
    <p>
      Eventos y charlas organizadas por el centro comunitario
    </p>
  </div>
  <button class="btn-new">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M12 5v14"/>
      <path d="M5 12h14"/>
    </svg>
    Nuevo registro
  </button>
</div>
<div class="table-toolbar">
  <div class="table-search">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="11" cy="11" r="7"/>
      <path d="m21 21-4.3-4.3"/>
    </svg>
    <input type="text" placeholder="Buscar por nombre…">
  </div>
  <button class="btn-filter">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <path d="M4 6h16"/>
      <path d="M7 12h10"/>
      <path d="M10 18h4"/>
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
        <th>
          Nombre
        </th>
      </tr>
    </thead>
    <tbody>
      <tr onclick="window.location.href='evento_detalle.html'">
        <td>
          <div class="person-name">
            Charla: concienciación sobre la diabetes
          </div>
          <div class="person-role">
            -
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Feria de la salud
          </div>
          <div class="person-role">
            -
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Conoce tus derechos laborales
          </div>
          <div class="person-role">
            -
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Feria cultural
          </div>
          <div class="person-role">
            -
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection