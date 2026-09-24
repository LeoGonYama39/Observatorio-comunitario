@extends('system.app')

@section('title', 'Áreas')

@section('content')
    <div class="content-header">
        <div>
            <h1>Áreas</h1>
            <p>Estructura del centro: áreas, responsabilidades y sus responsables</p>
        </div>
    </div>

    @foreach($areas as $area)
        <div class="area-block">
            <div class="area-header">
                <h2>{{ $area->nombre }}</h2>
                <div class="responsable-cell">
                    <div class="select-shell select-shell-compact">
                        <select class="form-select responsable-select" data-tipo="area" data-id="{{ $area->id }}" onchange="updateResponsable(this)">
                            @foreach($centros as $centro)
                                <option value="{{ $centro->id }}" {{ $area->centro_id == $centro->id ? 'selected' : '' }}>
                                    {{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}
                                </option>
                            @endforeach
                        </select>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"/>
                        </svg>
                    </div>
                    <span class="responsable-feedback"></span>
                </div>
            </div>

            <div class="table-card">
                <table>
                    <thead>
                    <tr>
                        <th>Responsabilidad</th>
                        <th>Responsable</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($area->responsabilidades as $resp)
                        <tr>
                            <td>{{ $resp->nombre }}</td>
                            <td>
                                <div class="responsable-cell">
                                    <div class="select-shell select-shell-compact">
                                        <select class="form-select responsable-select" data-tipo="responsabilidad" data-id="{{ $resp->id }}" onchange="updateResponsable(this)">
                                            @foreach($centros as $centro)
                                                <option value="{{ $centro->id }}" {{ $resp->centro_id == $centro->id ? 'selected' : '' }}>
                                                    {{ $centro->nombre }} {{ $centro->ap_pat }} {{ $centro->ap_mat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M6 9l6 6 6-6"/>
                                        </svg>
                                    </div>
                                    <span class="responsable-feedback"></span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endsection
