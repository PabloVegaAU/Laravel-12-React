<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Seccion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.docentes.index')->only('index');
        $this->middleware('can:admin.docentes.edit')->only(['edit', 'update']);
        $this->middleware('can:admin.docentes.create')->only(['create', 'store']);
        $this->middleware('can:admin.docentes.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $docentes = Docente::with(['user.perfil'])->paginate(6)->withQueryString();

        return Inertia::render('admin/docentes/index', [
            'docentes' => $docentes,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::with('perfil')->doesntHave('alumno')->doesntHave('docente')->orderBy('name')->get();
        $secciones = Seccion::with('grado')->get();
        $materias = Materia::all();

        return Inertia::render('admin/docentes/create', compact('users', 'secciones', 'materias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de entrada
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'materias' => 'required|array|min:1',
            'materias.*' => 'integer|exists:materias,id',
            'secciones' => 'required|array|min:1',
            'secciones.*' => 'integer|exists:seccions,id',
        ]);

        // 2. Iniciar transacción
        DB::beginTransaction();

        try {
            $user = User::findOrFail($validated['user_id']);

            // 3. Verificaciones previas
            if ($user->alumno) {
                throw new \Exception('El usuario ya fue asignado como alumno');
            }

            if ($user->docente) {
                throw new \Exception('El usuario ya fue asignado como docente');
            }

            // 4. Asignación de roles
            $roles = $user->roles->pluck('id')->toArray();

            if (in_array(1, $roles)) {
                // Si es admin, mantener su rol y agregar rol docente
                $user->roles()->syncWithoutDetaching([1, 2]);
            } elseif (empty($roles)) {
                // Si no tiene ningún rol, asignar solo docente
                $user->roles()->sync([2]);
            }

            // 5. Crear registro de docente
            $user->docente()->create();

            // 6. Asociar secciones
            foreach ($validated['secciones'] as $seccion) {
                DB::table('docente_seccion')->insert([
                    'user_id' => $user->id,
                    'seccion_id' => $seccion,
                ]);
            }

            // 7. Asociar materias
            foreach ($validated['materias'] as $materia) {
                DB::table('docente_materia')->insert([
                    'user_id' => $user->id,
                    'materia_id' => $materia,
                ]);
            }

            // 8. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.docentes.index')
                ->with('message', 'El docente fue creado correctamente')
                ->with('level', 'notice');
        } catch (\Throwable $e) {
            // 9. Revertir en caso de error
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Ocurrió un error al crear el docente. '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $docente = Docente::with([
            'user',
            'secciones.grado',
            'materias',
        ])->findOrFail($id);

        return Inertia::render('admin/docentes/show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $docente = Docente::with(['user', 'secciones', 'materias'])->findOrFail($id);

        $secciones = Seccion::with('grado')->get();
        $materias = Materia::all();

        return Inertia::render('admin/docentes/edit', compact('docente', 'secciones', 'materias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validación de entrada
        $validated = $request->validate([
            'materias' => 'required|array|min:1',
            'materias.*' => 'integer|exists:materias,id',
            'secciones' => 'required|array|min:1',
            'secciones.*' => 'integer|exists:seccions,id',
        ]);

        // 2. Iniciar transacción
        DB::beginTransaction();

        try {
            // 3. Buscar docente
            $docente = Docente::findOrFail($id);

            // 4. Actualizar relaciones
            $docente->materias()->sync($validated['materias']);
            $docente->secciones()->sync($validated['secciones']);

            // 5. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.docentes.index')
                ->with('message', 'El docente fue actualizado correctamente')
                ->with('level', 'notice');
        } catch (\Throwable $e) {
            // 9. Revertir en caso de error
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Ocurrió un error al actualizar el docente. '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $docente = Docente::findOrFail($id);
        $docente->delete();

        return redirect()->route('admin.docentes.index')->with('message', 'El docente fue eliminado correctamente')->with('level', 'notice');
    }
}
