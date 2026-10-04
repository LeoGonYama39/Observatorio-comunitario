<?php

namespace App\Http\Controllers\Sup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DatosUsuario {

    public function getDatosUsuario()
{
    if (Auth::guard('centro')->check()) {
        $persona = Auth::guard('centro')->user();
        $tipo = 'centro';

    } elseif (Auth::guard('externo')->check()) {
        $persona = Auth::guard('externo')->user();
        $tipo = 'externo';

    } else {
        return [
            null,
            null,
        ];
    }

    $otros = new \stdClass();

    $otros->tipo = $tipo;
    $otros->initNombre = strtoupper(substr($persona->nombre, 0, 1));
    $otros->initApPat = strtoupper(substr($persona->ap_pat, 0, 1));

    return [
        $persona,
        $otros,
    ];
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

    //Este es igual para todos los de hsitorial, se agrega aquí
    public function getValidateHistorial(Request $request) {
        return $request->validate([
            'fecha'         => ['required', 'date'],
            'comentario'    => ['required', 'string'],
        ], [
            'fecha.required'        => 'La fecha es obligatoria',
            'fecha.date'            => 'La fecha no es válida',
            'comentario.required'   => 'El comentario es obligatorio',
            'comentario.string'     => 'El comentario tiene que ser texto',
        ]);
    }

}
