<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Nav\DatosUsuario;
use Illuminate\Http\Request;

class NavPComunidad extends Controller
{
    public function show(Request $request)
    {
        $datosUsuario = new DatosUsuario();

        $aux = $datosUsuario->getDatosUsuario();

        $persona = $aux[0];
        $otros = $aux[1];

        if ($request->ajax()) {
            return view(
                "system.modules.p_comunidad.index",
                compact("persona", "otros")
            )->renderSections()["content"];
        }

        // Si entran escribiendo la URL o recargan con F5, entrega el layout completo
        return view(
            "system.modules.p_comunidad.index",
            compact("persona", "otros")
        );
    }
}
