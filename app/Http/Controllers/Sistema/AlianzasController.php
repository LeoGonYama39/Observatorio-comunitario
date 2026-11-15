<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\SupportController;
use App\Models\ListaOpciones\Institucion;
use App\Models\Personas\PCentro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AlianzasController extends Controller
{
    public function index(Request $request)
    {
        $aliados = $this->getDatosIndex();
        $view = view("system.modules.alianzas.index", compact('aliados'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }


    public function create(Request $request)
    {
        $view = view("system.modules.alianzas.create");

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }


    public function store(Request $request) {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
        try {
            $validated = $this->getValidate($request);

            $aliado = Institucion::create([
                'nombre'            => $limpiar($validated['nombre']),
                'nombre_contacto'   => $limpiar($validated['nombre_contacto']),
                'area'              => $limpiar($validated['area']),
                'correo'            => $limpiar($validated['correo']),
                'telefono'          => $limpiar($validated['telefono']),
                'universidad'       => $request->boolean('universidad'),
            ]);

            return redirect()
                ->route('alianzas.show', $aliado->id)
                ->with('success', 'Aliado registrado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }


    public function show(Request $request, int $id)
    {
        $aliado = $this->getDatosShow($id);
        $view = view("system.modules.alianzas.show", compact('aliado'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }


    public function edit(Request $request, int $id)
    {
        $aliado = $this->getDatosShow($id);
        $view = view("system.modules.alianzas.edit", compact('aliado'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update(Request $request, Institucion $alianza)
    {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
        try {
            $validated = $this->getValidate($request);

            $alianza->nombre            = $limpiar($validated['nombre']);
            $alianza->nombre_contacto   = $limpiar($validated['nombre_contacto']);
            $alianza->area              = $limpiar($validated['area']);
            $alianza->correo            = $limpiar($validated['correo']);
            $alianza->telefono          = $limpiar($validated['telefono']);
            $alianza->universidad = $request->boolean('universidad');

            $alianza->save();

            return redirect()
                ->route('alianzas.show', $alianza->id)
                ->with('success', 'Registro actualizado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $aliado = Institucion::findOrFail($id);
            $nombre = $aliado->nombre;
            $aliado->delete();

            return redirect()
                ->route('alianzas.index')
                ->with('success', "Aliando ({$nombre}) eliminado con éxito.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('alianzas.index')
                ->with('error', 'El registro que intentas eliminar no existe.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
        }
    }

    //------------------------------
    //          Funciones
    //------------------------------

    //Obtiene los datos para la tabla index
    private function getDatosIndex()
    {
        return Institucion::select(
            'id',
            'nombre',
            'area',
        )->get();
    }

    //Obtiene los datos para ficha show
    private function getDatosShow(int $id)
    {
        return Institucion::find($id);
    }

    private function getValidate(Request $request) {
        return $request->validate([
            'nombre'            => ['required', 'string', 'max:50'],
            'nombre_contacto'   => ['nullable', 'string', 'max:50'],
            'area'              => ['nullable', 'string', 'max:50'],
            'correo'            => ['nullable', 'email', 'max:100'],
            'telefono'          => ['nullable', 'string', 'max:20'],
            'universidad'       => ['nullable', 'boolean'],
        ],[
            'nombre.required' => 'El nombre del aliado/institución es obligatorio.',
            'nombre.string' => 'El nombre del aliado/institución debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del aliado/institución no puede tener más de 50 caracteres.',

            'nombre_contacto.string' => 'El nombre del contacto debe ser una cadena de texto.',
            'nombre_contacto.max' => 'El nombre del contacto no puede tener más de 50 caracteres.',

            'area.string' => 'El área debe ser una cadena de texto.',
            'area.max' => 'El área no puede tener más de 50 caracteres.',

            'correo.string' => 'El coore debe ser una cadena de texto.',
            'correo.max' => 'El corre no puede tener más de 100 caracteres.',
            'correo.email' => 'Ingresa un correo válido.',

            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
        ]);
    }
}
