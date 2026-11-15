@extends('system.app')

@section('title', 'Catálogos del sistema')

@section('content')
    <div class="content-header">
        <div>
            <h1>Catálogos del sistema</h1>
            <p>Administra las listas desplegables y opciones seleccionables de los módulos</p>
        </div>
    </div>

    <div class="table-card">
        <table>
            <thead>
            <tr>
                <th>Catálogo</th>
                <th>Descripción</th>
                <th>Registros</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($catalogos as $cat)
                <tr data-url="{{ route('catalogos.show', $cat->slug) }}">
                    <td class="name">{{ $cat->titulo }}</td>
                    <td>{{ $cat->descripcion }}</td>
                    <td>
                        <span class="meta-badge on">{{ $cat->total }} {{ $cat->total === 1 ? 'opción' : 'opciones' }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
