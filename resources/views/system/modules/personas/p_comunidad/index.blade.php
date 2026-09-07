@extends('system.app')

@section('title', 'Personas usuarias · Centro Ibero Meneses')

@section('content')

      <div class="content-header">
        <div>
          <h1>Personas usuarias</h1>
          <p>Personas de la comunidad</p>
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
              <th>Edad</th>
              <th>Colonia</th>
              <th>Categoría</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($usuarias as $usuaria)
            <tr data-url="{{ route('personas-usuarias.show', $usuaria->id) }}" data-edad="{{ $usuaria->edad }}" data-colonia="{{ $usuaria->colonia }}"
            data-categ="{{ $usuaria->categ_categ }}">
              <td>
                <div class="person-name">
                  {{ $usuaria->nombre }} {{ $usuaria->ap_pat }} {{ $usuaria->ap_mat }}
                </div>
                <div class="person-role">
                  {{ ucfirst(str_replace('_', ' ', $usuaria->genero)); }}
                </div>
              </td>
              <td>
                <span class="area-tag {{ $usuaria->edad ? '' : 'empty'}}">
                  {{ $usuaria->edad ? $usuaria->edad . ' años' : '—' }}
                </span>
              </td>
              <td>
                <span class="area-tag">
                  {{ $usuaria->colonia}}
                </span>
              </td>
              <td>
                <span class="area-tag">
                  {{ $usuaria->categoria }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>


@endsection