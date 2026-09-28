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
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $ejes = $this->getDatosIndex();

        $view = view("system.modules.ejes.index", compact('persona', 'otros', 'ejes'));

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
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $responsabilidades = $this->getResponsabilidades();

        $view = view("system.modules.ejes.create", compact('persona', 'otros', 'responsabilidades'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre'  => ['required', 'string', 'max:50'],

                'responsabilidades'            => ['nullable', 'array'],
                'responsabilidades.*'          => ['integer', 'distinct', 'exists:responsabilidad,id'],
            ], $this->getMessages());

            $eje = DB::transaction(function () use ($validated, $request) {
                $eje = Eje::create([
                    'nombre'       => trim($validated['nombre']),
                ]);

                // Tablas intermedias: sync() recibe directamente la lista de ids ya validada
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


    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $eje = $this->getDatosShow($id);

        $view = view("system.modules.ejes.show", compact('persona', 'otros', 'eje'));

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
    public function edit(Request $request, $id)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $eje = $this->getDatosShow($id);

        $view = view("system.modules.ejes.edit", compact('persona', 'otros', 'eje'));

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eje $eje)
    {
        try {
            $validated = $request->validate([
                'nombre'  => ['required', 'string', 'max:50'],
            ], $this->getMessages());

            $eje->nombre = trim($validated['nombre']);
            $eje->save();

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

    public function destroy(string $id)
    {
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

    private function getMessages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede tener más de 40 caracteres.',

            'responsabilidades.array'      => 'La difusión enviada no es válida.',
            'responsabilidades.*.exists'   => 'Una de las opciones de difusión no es válida.',
            'responsabilidades.*.distinct' => 'Hay opciones de difusión repetidas.',
        ];
    }
}
