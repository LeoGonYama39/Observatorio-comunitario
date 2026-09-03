@extends('system.app')

@section('title', 'Atención individual · Centro Ibero Meneses')

@section('content')
<div class="content-header">
  <div>
    <h1>
      Atención individual
    </h1>
    <p>
      Casos de atención psicopedagógica del centro
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
    <input type="text" placeholder="Buscar por paciente…">
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
          Estudiante
        </th>
        <th>
          Última actualización
        </th>
        <th>
          Tipo de atención
        </th>
      </tr>
    </thead>
    <tbody>
      <tr data-url="{{ route('aten_pers.info') }}">
        <td>
          <div class="person-name">
            Rosa Elena Camposeco Vidal
          </div>
          <div class="person-role">
            Activo
          </div>
        </td>
        <td>
          <span class="area-tag">
            22 jul 2026
          </span>
        </td>
        <td>
          <span class="area-tag">
            Psicoeducativa 
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Manuel Ortiz Beltrán
          </div>
          <div class="person-role">
            Cerrado
          </div>
        </td>
        <td>
          <span class="area-tag">
            10 jun 2026
          </span>
        </td>
        <td>
          <span class="area-tag">
            Académica
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Guadalupe Salcido Nájera
          </div>
          <div class="person-role">
            Inactivo
          </div>
        </td>
        <td>
          <span class="area-tag">
            5 jul 2026
          </span>
        </td>
        <td>
          <span class="area-tag">
            Psicoeducativa
          </span>
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Fernando Castellanos Uc
          </div>
          <div class="person-role">
            Activo
          </div>
        </td>
        <td>
          <span class="area-tag">
            28 jun 2026
          </span>
        </td>
        <td>
          <span class="area-tag">
            Evaluación psicológica
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection