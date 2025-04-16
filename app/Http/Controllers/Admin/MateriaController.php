<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MateriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.materias.index')->only('index');
        $this->middleware('can:admin.materias.edit')->only(['edit', 'update']);
        $this->middleware('can:admin.materias.create')->only(['create', 'store']);
        $this->middleware('can:admin.materias.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $materias = Materia::paginate(6)->withQueryString();

        return Inertia::render('admin/materias/index', [
            'materias' => $materias,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/materias/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        // 2. Iniciar una transaccion
        DB::beginTransaction();

        try {
            // 3. Crear la materia
            Materia::create($request->all());

            // 4. Confirmar la transaccion
            DB::commit();

            // 5. Redireccionar a la lista de materias
            return redirect()->route('admin.materias.index')->with('message', 'Materia creada correctamente')->with('level', 'notice');
        } catch (\Throwable $e) {
            // 6. En caso de error, deshacer la transaccion
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Ocurrió un error al crear el materia. '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $materia = Materia::findOrFail($id);

        return Inertia::render('admin/materias/show', [
            'materia' => $materia,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $materia = Materia::findOrFail($id);

        return Inertia::render('admin/materias/edit', [
            'materia' => $materia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validar los datos
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        // 2. Iniciar una transaccion
        DB::beginTransaction();

        try {
            // 3. Actualizar la materia
            $materia = Materia::findOrFail($id);
            $materia->update($request->all());

            // 4. Confirmar la transaccion
            DB::commit();

            // 5. Redireccionar a la lista de materias
            return redirect()->route('admin.materias.index')->with('message', 'Materia actualizada correctamente')->with('level', 'notice');
        } catch (\Throwable $e) {
            // 6. En caso de error, deshacer la transaccion
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors([
                'general' => 'Ocurrió un error al actualizar la materia. '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return redirect()->route('admin.materias.index')->with('message', 'Materia eliminada correctamente')->with('level', 'notice');
    }
}
