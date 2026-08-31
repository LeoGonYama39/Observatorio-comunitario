@extends('system.app')

@section('title', 'Talleres · Centro Ibero Meneses')

@section('content')
<div class="content-header">
  <div>
    <h1>
      Talleres
    </h1>
    <p>
      Talleres impartidos por el centro comunitario
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
      <tr onclick="window.location.href='taller_detalle.html'">
        <td>
          <div class="person-name">
            Alimentación Saludable
          </div>
          <div class="person-role">
            Activo
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Costura y Bordado
          </div>
          <div class="person-role">
            Pausado
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Guitarra para Principiantes
          </div>
          <div class="person-role">
            Activo
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Huertos en Casa
          </div>
          <div class="person-role">
            Cancelado
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection