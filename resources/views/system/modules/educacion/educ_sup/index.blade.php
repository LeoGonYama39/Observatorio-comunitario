@extends('system.app')

@section('title', 'Educación media-superior · Centro Ibero Meneses')

@section('content')
<div class="content-header">
  <div>
    <h1>
      Educación media-superior
    </h1>
    <p>
      Alumnos de cursos de educación media-superior
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
        <th>
          Curso actual
        </th>
        <th>
          Avance
        </th>
      </tr>
    </thead>
    <tbody>
      <tr data-url="{{ route('educ_sup.info') }}">
        <td>
          <div class="person-name">
            Leonel Lora Vázquez
          </div>
          <div class="person-role">
            Activo
          </div>
        </td>
        <td class="area-tag">
          Rumbo a la uni
        </td>
        <td class="area-tag">
          1/12 acreditadas
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Javier Olvera Robles
          </div>
          <div class="person-role">
            Completo
          </div>
        </td>
        <td class="area-tag">
          EXACER
        </td>
        <td class="area-tag">
          10/10 acreditadas
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Giovanni Corona Ordoñez
          </div>
          <div class="person-role">
            Baja
          </div>
        </td>
        <td class="area-tag">
          Prepa en línea
        </td>
        <td class="area-tag">
          8/9 acreditadas
        </td>
      </tr>
      <tr>
        <td>
          <div class="person-name">
            Diego Salinas Jiménez
          </div>
          <div class="person-role">
            Activo
          </div>
        </td>
        <td class="area-tag">
          ECOEMS
        </td>
        <td class="area-tag">
          7/20 acreditadas
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection