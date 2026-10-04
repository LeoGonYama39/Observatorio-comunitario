<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Areas\Eje;
use App\Models\Areas\Responsabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EjesController extends Controller
{
    public function index(Request $request) {
        $ejes = $this->getDatosIndex();

        $view = view("system.modules.ejes.index", compact('ejes'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function create(Request $request) {
        $responsabilidades = $this->getResponsabilidades();

        $view = view("system.modules.ejes.create", compact('responsabilidades'));

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
        try {
            $validated = $this->getValidated($request, $this->getMessages());

            $eje = DB::transaction(function () use ($validated, $request) {
                $eje = Eje::create([
                    'nombre'       => trim($validated['nombre']),
                ]);

                $eje->responsabilidades()->sync($validated['responsabilidades'] ?? []);

                return $eje;
            });

            return redirect()
                ->route('ejes.show', $eje->id)
                ->with('success', 'Eje registrado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }


    public function show(Request $request, $id) {
        $eje = $this->getDatosShow($id);

        $view = view("system.modules.ejes.show", compact('eje'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function edit(Request $request, $id) {
        $eje = $this->getDatosShow($id);
        $responsabilidades = $this->getResponsabilidades();

        $view = view("system.modules.ejes.edit", compact('eje', 'responsabilidades'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }


    public function update(Request $request, Eje $eje) {
        try {
            $validated = $this->getValidated($request, $this->getMessages());

            DB::transaction(function () use ($eje, $validated, $request) {
                $eje->nombre = trim($validated['nombre']);
                $eje->save();
                $eje->responsabilidades()->sync($validated['responsabilidades'] ?? []);
            });

            return redirect()
                ->route('ejes.show', $eje->id)
                ->with('success', 'Eje editado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy(string $id) {
        try {
            $eje = Eje::findOrFail($id);
            $ejeNombre = trim($eje->nombre);
            $eje->delete();

            return redirect()
                ->route('ejes.index')
                ->with('success', "Eje ({$ejeNombre}) eliminado con éxito.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('ejes.index')
                ->with('error', 'El registro que intentas eliminar no existe.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
        }
    }


    //--------------------------
    //      Funciones
    //--------------------------

    private function getDatosIndex()
    {
        return Eje::orderBy('nombre')->get();
    }

    private function getDatosShow($id)
    {
        return Eje::find($id);
    }

    private function getResponsabilidades() {
        return Responsabilidad::select('id', 'nombre')->get();
    }

    private function getValidated($request, $messages) {
        return $request->validate([
                'nombre'  => ['required', 'string', 'max:50'],

                'responsabilidades'            => ['nullable', 'array'],
                'responsabilidades.*'          => ['integer', 'distinct', 'exists:responsabilidad,id'],
            ], $messages);
    }

    private function getMessages(): array {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede tener más de 40 caracteres.',

            'responsabilidades.array'      => 'La difusión enviada no es válida.',
            'responsabilidades.*.exists'   => 'Una de las opciones de difusión no es válida.',
            'responsabilidades.*.distinct' => 'Hay opciones de difusión repetidas.',
        ];
    }
}
