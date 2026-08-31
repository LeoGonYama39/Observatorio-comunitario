@extends('system.app')

@section('title', 'Colonias · Centro Ibero Meneses')

@section('content')
<div class="content-header">
  <div>
    <h1>
      Colonias
    </h1>
    <p>
      Colonias de Pueblo Santa Fe
    </p>
  </div>
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
        <th>
          Incidencia social
        </th>
      </tr>
    </thead>
    <tbody>
      <tr onclick="window.location.href='colonia_detalle.html'">
        <td>
          <div class="person-name">
            Colonia 1
          </div>
          <div class="person-role">
            612 habitantes
          </div>
        </td>
        <td>
          <span class="area-tag">
            3
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Colonia 2
          </div>
          <div class="person-role">
            348 habitantes
          </div>
        </td>
        <td>
          <span class="area-tag">
            2
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Colonia 3
          </div>
          <div class="person-role">
            890 habitantes
          </div>
        </td>
        <td>
          <span class="area-tag">
            4
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Colonia 4
          </div>
          <div class="person-role">
            205 habitantes
          </div>
        </td>
        <td>
          <span class="area-tag">
            1
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection