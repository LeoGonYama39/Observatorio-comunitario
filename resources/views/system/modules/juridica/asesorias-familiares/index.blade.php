@extends('system.app')

@section('title', 'Asesorías familiares')

@section('content')
<div class="content-header">
  <div>
    <h1>
      Asesorías familiares
    </h1>
    <p>
      Registro de asesorías familiares
    </p>
  </div>
  <a href="" data-url="" class="btn-new">
    <svg
            width="16"
            height="16"
            viewBox="0 0 24 24"
            fill="none"
            stroke-width="2.2"
            stroke-linecap="round"
            stroke-linejoin="round"
         >
      <path d="M12 5v14" />
      <path d="M5 12h14" />
    </svg>
    Nuevo registro
</a>
</div>
<div class="table-toolbar">
  <div class="table-search">
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
    <input type="text" placeholder="Buscar por nombre…" />
  </div>
  <button class="btn-filter">
    <svg
            width="15"
            height="15"
            viewBox="0 0 24 24"
            fill="none"
            stroke-width="1.8"
            stroke-linecap="round"
            stroke-linejoin="round"
         >
      <path d="M4 6h16" />
      <path d="M7 12h10" />
      <path d="M10 18h4" />
    </svg>
    Filtro
    <svg
            width="13"
            height="13"
            viewBox="0 0 24 24"
            fill="none"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
         >
      <path d="M6 9l6 6 6-6" />
    </svg>
  </button>
</div>
<div class="table-card">
  <table>
    <thead>
      <tr>
        <th>
            Familia
        </th>
        <th>
            Conflicto
        </th>
        <th>
            Rama
        </th>
        <th>
            Periodo
        </th>
      </tr>
    </thead>
    <tbody>
      <tr data-url="{{ route('a-familiares.show', 1) }}" >
        <td>
          <div class="person-name">
            González Castellanos
          </div>
          <div class="person-role">
            Acompañamiento
          </div>
        </td>
        <td>
          <span class="area-tag">
            Venta de bienes inmuebles
          </span>
        </td>
        <td>
          <span class="area-tag">
            Notarial y registral
          </span>
        </td>
        <td>
          <span class="area-tag">
            Otoño 2026
          </span>
        </td>
      </tr>
      <tr data-url="{{ route('a-familiares.show', 1) }}">
        <td>
          <div class="person-name">
             Robles Zoto
          </div>
          <div class="person-role">
            Asunto concluido
          </div>
        </td>
        <td>
          <span class="area-tag">
            Sucesión testamentaria
          </span>
        </td>
        <td>
          <span class="area-tag">
            Civil
          </span>
        </td>
        <td>
          <span class="area-tag">
            Otoño 2026
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection