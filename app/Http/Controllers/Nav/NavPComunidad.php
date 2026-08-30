<?php

namespace App\Http\Controllers\Nav;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NavPComunidad 
{
    public function show(Request $request)
    {
       if ($request->ajax()) {
            return view('system.modules.p_comunidad.index')->renderSections()['content'];
        }

        // Si entran escribiendo la URL o recargan con F5, entrega el layout completo
        return view('system.modules.p_comunidad.index');
    }
}