<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\AulaDocenteMateria;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\Materia;
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
        $users = User::with('perfil')
            ->doesntHave('Alumno')
            ->doesntHave('Docente')
            ->orderBy('name')
            ->get();

        $currentYear = now()->year;
        $aulas = Aula::with(['seccion', 'grado'])->where('anio', $currentYear)->get();
        $materias = Materia::all();

        return response()->json([
            'users' => $users,
            'aulas' => $aulas,
            'materias' => $materias,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de entrada
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'aulas' => 'required|array|min:1',
            'aulas.*' => 'integer|exists:aulas,id',
            'materias' => 'required|array|min:1',
            'materias.*' => 'integer|exists:materias,id',
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

            // 6. Asociar aulas-docentes-materias
            foreach ($validated['aulas'] as $aulaId) {
                foreach ($validated['materias'] as $materiaId) {
                    AulaDocenteMateria::create([
                        'aula_id' => $aulaId,
                        'docente_id' => $user->docente->user_id,
                        'materia_id' => $materiaId
                    ]);
                }
            }

            // 7. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.docentes.index')
                ->with('message', 'El docente fue creado correctamente')
                ->with('level', 'notice');
        } catch (\Throwable $e) {
            // 8. Revertir en caso de error
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
            'perfil',
            'aulasDocentesMaterias',
            'aulasDocentesMaterias.aula',
            'aulasDocentesMaterias.aula.grado',
            'aulasDocentesMaterias.aula.seccion',
            'aulasDocentesMaterias.materia',
        ])->findOrFail($id);

        return Inertia::render('admin/docentes/show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $currentYear = now()->year;

        // 1. Obtener el docente con sus relaciones
        $docente = Docente::with([
            'user:id,name,email,avatar',
            'user.perfil:user_id,user_id,nombre,apellido',
            'aulasDocentesMaterias' => function ($query) use ($currentYear) {
                $query->whereHas('aula', fn ($q) => $q->where('anio', $currentYear))
                    ->with([
                        'aula:id,grado_id,seccion_id,anio',
                        'aula.grado:id,nombre,nivel',
                        'aula.seccion:id,nombre',
                        'materia:id,nombre'
                    ]);
            }
        ])->findOrFail($id);

        // 2. Obtener la estructura jerárquica: nivel -> grado -> secciones -> materias
        $niveles = Grado::query()
            ->select('id', 'nombre', 'nivel')
            ->with(['aulas' => function ($query) use ($currentYear, $id) {
                $query->select('id', 'grado_id', 'seccion_id', 'anio')
                    ->where('anio', $currentYear)
                    ->with([
                        'seccion:id,nombre',
                        'docentesMaterias' => function ($q) use ($id) {
                            $q->where('docente_id', $id)
                                ->select('id', 'aula_id', 'materia_id')
                                ->with('materia:id,nombre');
                        }
                    ]);
            }])
            ->whereHas('aulas', fn ($q) => $q->where('anio', $currentYear))
            ->orderBy('nivel')
            ->orderBy('nombre')
            ->get()
            ->groupBy('nivel')
            ->map(function ($grados, $nivel) {
                return $grados->map(function ($grado) {
                    $secciones = $grado->aulas
                        ->unique('seccion_id')
                        ->map(function ($aula) {
                            $materias = $aula->docentesMaterias
                                ->map(fn ($dm) => [
                                    'id' => $dm->materia->id,
                                    'nombre' => $dm->materia->nombre
                                ]);

                            return [
                                'id' => $aula->seccion->id,
                                'nombre' => $aula->seccion->nombre,
                                'aula_id' => $aula->id,
                                'materias' => $materias
                            ];
                        })
                        ->filter()
                        ->values();

                    return [
                        'id' => $grado->id,
                        'nombre' => $grado->nombre,
                        'secciones' => $secciones
                    ];
                })
                    ->filter()
                    ->values();
            })
            ->filter()
            ->toArray();

        // 3. Obtener materias asignadas al docente
        $materiasAsignadas = $docente->aulasDocentesMaterias->map(fn ($adm) => [
            'aula_id' => $adm->aula_id,
            'materia_id' => $adm->materia_id,
            'materia_nombre' => $adm->materia->nombre
        ]);

        return Inertia::render('admin/docentes/edit', [
            'docente' => $docente,
            'niveles' => $niveles,
            'materias' => Materia::select('id', 'nombre')->get(),
            'materiasAsignadas' => $materiasAsignadas,
            'currentYear' => $currentYear,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'aulas_materias' => 'required|array',
            'aulas_materias.*.aula_id' => 'required|integer|exists:aulas,id',
            'aulas_materias.*.materia_ids' => 'required|array|min:1',
            'aulas_materias.*.materia_ids.*' => 'integer|exists:materias,id',
        ]);

        DB::beginTransaction();

        try {
            $docente = Docente::with(['aulasDocentesMaterias'])->findOrFail($id);

            // Eliminar relaciones existentes
            $docente->aulasDocentesMaterias()->delete();

            // Crear nuevas relaciones
            $created = [];
            foreach ($request->aulas_materias as $aulaMateria) {
                foreach ($aulaMateria['materia_ids'] as $materiaId) {
                    $relacion = AulaDocenteMateria::create([
                        'aula_id' => $aulaMateria['aula_id'],
                        'docente_id' => $docente->user_id,
                        'materia_id' => $materiaId
                    ]);
                    $created[] = $relacion->toArray();
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.docentes.edit', $docente->user_id)
                ->with('message', 'Docente actualizado correctamente')
                ->with('level', 'notice');

        } catch (\Throwable $e) {
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
