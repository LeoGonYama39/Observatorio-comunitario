<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use App\Models\ListaOpciones\Institucion;
use App\Models\ListaOpciones\Problematica;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CatalogoController extends Controller
{
    /**
     * Diccionario central de catálogos administrables.
     */
    private function getCatalogosConfig(): array
    {
        return [
            'problematicas' => [
                'slug'        => 'problematicas',
                'titulo'      => 'Problemáticas Comunitarias',
                'singular'    => 'problemática',
                'has_bool'    => false,
                'descripcion' => 'Problemáticas sociales y urbanas vinculadas a colonias y proyectos.',
                'modelo'      => Problematica::class,
                'tabla'       => 'problematicas',
                'max_length'  => 50,
                'relaciones'  => [
                    'colonias'  => ['colonia', 'colonias'],
                    'proyectos' => ['proyecto', 'proyectos'],
                ],
            ],
        ];
    }

    private function resolveCatalogo(string $slug): array
    {
        $catalogos = $this->getCatalogosConfig();
        abort_if(!isset($catalogos[$slug]), 404);
        return $catalogos[$slug];
    }

    public function index(Request $request)
    {
        $catalogos = collect($this->getCatalogosConfig())->map(function ($conf) {
            $modelo = $conf['modelo'];
            $conf['total'] = $modelo::count();
            return (object) $conf;
        });

        $view = view('system.modules.catalogos.index', compact('catalogos'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title'   => $sections['title'],
            ]);
        }

        return $view;
    }

    public function show(Request $request, string $catalogo)
    {
        $config = (object) $this->resolveCatalogo($catalogo);
        $modelo = $config->modelo;

        // Cargar registros con el conteo de dónde se están usando (withCount)
        $relacionesCount = array_keys($config->relaciones);
        $items = $modelo::withCount($relacionesCount)->orderBy('nombre')->get();

        $view = view('system.modules.catalogos.show', compact('config', 'items'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title'   => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store(Request $request, string $catalogo)
    {
        $config = (object) $this->resolveCatalogo($catalogo);
        $modelo = $config->modelo;

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:' . $config->max_length, Rule::unique($config->tabla, 'nombre')],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede exceder los ' . $config->max_length . ' caracteres.',
            'nombre.unique'   => 'Este registro ya existe en el catálogo.',
        ]);

        $datos = ['nombre' => trim($validated['nombre'])];

        if ($config->has_bool) {
            $datos[$config->bool_field] = $request->boolean($config->bool_field);
        }

        $modelo::create($datos);

        return redirect()
            ->route('catalogos.show', $config->slug)
            ->with('success', ucfirst($config->singular) . ' agregada correctamente.');
    }

    public function update(Request $request, string $catalogo, int $id)
    {
        $config = (object) $this->resolveCatalogo($catalogo);
        $modelo = $config->modelo;
        $item   = $modelo::findOrFail($id);

        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:' . $config->max_length,
                Rule::unique($config->tabla, 'nombre')->ignore($item->id),
            ],
        ], [
            'nombre.required' => 'El nombre no puede quedar vacío.',
            'nombre.max'      => 'El nombre no puede exceder los ' . $config->max_length . ' caracteres.',
            'nombre.unique'   => 'Ya existe otro registro con ese mismo nombre.',
        ]);

        $item->nombre = trim($validated['nombre']);

        if ($config->has_bool) {
            $item->{$config->bool_field} = $request->boolean($config->bool_field);
        }

        $item->save();

        return redirect()
            ->route('catalogos.show', $config->slug)
            ->with('success', 'Registro actualizado.');
    }

    public function destroy(string $catalogo, int $id)
    {
        $config = (object) $this->resolveCatalogo($catalogo);
        $modelo = $config->modelo;
        $item   = $modelo::findOrFail($id);

        $item->delete();

        return redirect()
            ->route('catalogos.show', $config->slug)
            ->with('success', 'Registro eliminado del catálogo.');
    }
}
