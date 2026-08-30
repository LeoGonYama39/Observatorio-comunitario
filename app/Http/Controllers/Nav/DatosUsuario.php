<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatosUsuario extends Controller {
    
    public function getDatosUsuario() {

    $otros = new \stdClass();
    $aux = [];

        if (Auth::guard("centro")->check()) {
            $persona = Auth::guard("centro")->user();
            $otros->tipo = "centro";
        } elseif (Auth::guard("externo")->check()) {
            $persona = Auth::guard("externo")->user();
            $otros->tipo = "externo";
        } else {

        }

        $otros->initNombre = strtoupper(substr($persona->nombre, 0, 1));
        $otros->initApPat = strtoupper(substr($persona->ap_pat, 0, 1));

        $aux[0] = $persona;
        $aux[1] = $otros;   
        return $aux;
    }

}
