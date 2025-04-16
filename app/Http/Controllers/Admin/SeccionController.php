<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class SeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.secciones.index')->only('index');
        $this->middleware('can:admin.secciones.edit')->only(['edit', 'update']);
        $this->middleware('can:admin.secciones.create')->only(['create', 'store']);
        $this->middleware('can:admin.secciones.destroy')->only('destroy');
    }

    public $listasec = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $secciones = Seccion::paginate(6)->withQueryString();

        return Inertia::render('admin/secciones/index', [
            'secciones' => $secciones,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listasec = $this->listasec;

        return Inertia::render('admin/secciones/create', compact('listasec'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de entrada
        $request->validate([
            'nombre' => 'required|string',
            'grado_id' => 'required|string',
        ]);

        // 2. Iniciar transacción
        DB::beginTransaction();

        try {
            $lista = Seccion::where('nombre', $request->nombre)->pluck('nombre', 'grado_id')->all();

            // Corroboramos que la lista contenga datos
            if (! empty($lista)) {
                // se hace un recorrido a la lista entera
                foreach ($lista as $grid => $nomsec) {
                    // se comprueba que no contenga secciones repetidas mediante un IF
                    if (($request->nombre == $nomsec) and ($request->grado_id == $grid)) {
                        throw new \Exception('Sección ya existente');
                    }
                }
            }

            Seccion::create($request->all());

            // 3. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.secciones.index')->with('message', 'Sección creada correctamente')->with('level', 'notice');
        } catch (\Throwable $e) {
            // 4. Revertir en caso de error
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Ocurrió un error al crear el grado. '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $seccion = Seccion::findOrFail($id);

        return Inertia::render('admin/secciones/show', compact('seccion'));
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
        $seccion = Seccion::findOrFail($id);
        $seccion->delete();

        return redirect()->route('admin.secciones.index')->with('message', 'Sección eliminado correctamente')->with('level', 'notice');
    }
}
