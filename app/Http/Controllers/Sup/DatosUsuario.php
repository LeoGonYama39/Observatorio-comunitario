<?php

namespace App\Http\Controllers\Sup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DatosUsuario {

    public function getDatosUsuario() {

    $otros = new \stdClass();
    $aux = [];

        if (Auth::guard("centro")->check()) {
            $persona = Auth::guard("centro")->user();
            $otros->tipo = "centro";
        } elseif (Auth::guard("externo")->check()) {
            $persona = Auth::guard("externo")->user();
            $otros->tipo = "externo";
        }

        $otros->initNombre = strtoupper(substr($persona->nombre, 0, 1));
        $otros->initApPat = strtoupper(substr($persona->ap_pat, 0, 1));

        $aux[0] = $persona;
        $aux[1] = $otros;
        return $aux;
    }

    public function getEnumValues($tabla, $columna)
    {
        $resultado = DB::select("
        SELECT COLUMN_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = ?
        AND COLUMN_NAME = ?
    ", [$tabla, $columna]);

        if (empty($resultado)) {
            return [];
        }

        $tipo = $resultado[0]->COLUMN_TYPE;

        preg_match("/^enum\((.*)\)$/", $tipo, $coincidencia);

        if (empty($coincidencia)) {
            return [];
        }

        return str_getcsv($coincidencia[1], ',', "'");
    }

}
