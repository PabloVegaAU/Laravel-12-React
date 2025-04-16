<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class GradoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.grados.index')->only('index');
        $this->middleware('can:admin.grados.edit')->only(['edit', 'update']);
        $this->middleware('can:admin.grados.create')->only(['store', 'create']);
        $this->middleware('can:admin.grados.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $grados = Grado::query();

        if ($request->has('search')) {
            $grados->where('nombre', 'like', '%'.$request->search.'%');
        }

        if ($request->has('sort')) {
            $grados->orderBy($request->sort, $request->direction);
        }

        $grados = $grados->paginate(11)->withQueryString();

        return Inertia::render('admin/grados/index', [
            'grados' => $grados,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/grados/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de entrada
        $request->validate([
            'nombre' => 'required|string',
            'nivel' => 'required|string',
        ]);

        // 2. Iniciar transacción
        DB::beginTransaction();

        try {
            // 1.5 Verificar si el grado ya existe
            $exists = Grado::where('nombre', $request->nombre)->where('nivel', $request->nivel)->first();
            if ($exists) {
                throw new \Exception('El grado ya existe');
            }

            Grado::create($request->all());

            // 3. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.grados.index')->with('message', 'Grado creado correctamente')->with('level', 'notice');
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
        $grado = Grado::findOrFail($id);

        return Inertia::render('admin/grados/show', compact('grado'));
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
        $grado = Grado::findOrFail($id);
        $grado->delete();

        return redirect()->route('admin.grados.index')->with('message', 'Grado eliminado correctamente')->with('level', 'notice');
    }
}
