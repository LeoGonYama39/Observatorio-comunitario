<?php

namespace App\Http\Controllers\Nav;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NavProyectos 
{
    public function show(Request $request)
    {
       if ($request->ajax()) {
            return view('system.modules.proyectos.index')->renderSections()['content'];
        }

        // Si entran escribiendo la URL o recargan con F5, entrega el layout completo
        return view('system.modules.proyectos.index');
    }
}