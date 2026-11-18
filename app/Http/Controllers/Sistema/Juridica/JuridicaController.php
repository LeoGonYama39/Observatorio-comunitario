<?php

namespace App\Http\Controllers\Sistema\Juridica;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\SupportController;
use App\Models\Juridica\AFamiliar;
use App\Models\Juridica\AJuridica;
use App\Models\Juridica\Conflicto;
use App\Models\Juridica\Rama;
use Illuminate\Http\Request;

class JuridicaController extends Controller
{
    public function index(Request $request, string $tipo)
    {
        $support = new SupportController();

        $config = $this->configJuridica($tipo);
        $tipoAsesoria = $config['tipo'];
        $ruta = $config['ruta'];
        $label = $config['label'];
        $asesorias = $this->getDatosIndex($config['modelo']);

        //opciones para filtro
        $estados = $support->getEnumValues('asesoria', 'estado');
        $ramas = Rama::all();
        $conflictos = Conflicto::all();

        $view = view("system.modules.juridica.index",
            compact('config',
                'tipoAsesoria',
                'ruta',
                'label',
                'asesorias',
                'estados',
                'ramas',
                'conflictos'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $id)
    {
        $view = view("system.modules.juridica.asesorias-familiares.show");

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //------------------------------------------
    //              Funciones
    //------------------------------------------

    //Agarra el default de las rutas (definido en web.php) para saber si será del tipo
    //jurídica (individual) o familiar.
    private function configJuridica(string $tipo): array {
        return match ($tipo) {
            'juridica' => [
                'tipo' => 'juridica',
                'modelo'=> AJuridica::class,
                'ruta'  => 'a-juridicas',
                'label' => 'asesorías jurídicas'
            ],
            'familiar' => [
                'tipo' => 'familiar',
                'modelo' => AFamiliar::class,
                'ruta'  => 'a-familiares',
                'label' => 'asesorías familiares'
            ],
            default => abort(404),
        };
    }

    private function getDatosIndex(string $modelo) {
        return $modelo::with('asesoria')->get();
    }
}
