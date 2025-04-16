<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumno;
use App\Models\Level;
use App\Models\Seccion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.alumnos.index')->only('index');
        $this->middleware('can:admin.alumnos.edit')->only(['edit', 'update']);
        $this->middleware('can:admin.alumnos.create')->only(['create', 'store']);
        $this->middleware('can:admin.alumnos.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $alumnos = Alumno::with(['user.perfil', 'seccion.grado'])
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('admin/alumnos/index', [
            'alumnos' => $alumnos,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::with('perfil')->doesntHave('docente')->doesntHave('alumno')->orderBy('name')->get();
        $secciones = Seccion::with('grado')->get();

        return Inertia::render('admin/alumnos/create', compact('users', 'secciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de entrada
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'seccion_id' => 'required|exists:seccions,id',
        ]);

        // 2. Iniciar transacción
        DB::beginTransaction();

        try {
            // 3. Buscar usuario
            $user = User::findOrFail($request->user_id);

            // 4. Verificar si el usuario ya está asignado como alumno o docente
            if ($user->alumno) {
                throw new \Exception('El usuario ya fue asignado como alumno');
            } elseif ($user->docente) {
                throw new \Exception('El usuario ya fue asignado como docente');
            }

            // 5. Verificar si el usuario tiene rol de administrador o docente
            foreach ($user->roles as $role) {
                if ($role->id == 1 || $role->id == 2) { // Si ya tiene rol de admin o docente
                    throw new \Exception('El usuario seleccionado tiene rol administrador o docente, no se puede asignar como alumno');
                }
            }

            // 6. Asignar rol de alumno
            $user->roles()->sync([3]);

            // 7. Crear registro de alumno
            Alumno::create($request->all());

            // 8. Crear nivel de usuario
            Level::create([
                'user_id' => $request->user_id,
                'level' => 1,
                'exp' => 0,
                'exp_ac' => 0,
            ]);

            // 9. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.alumnos.index')
                ->with('message', 'El alumno fue creado correctamente')
                ->with('level', 'notice');
        } catch (\Throwable $e) {
            // 10. Revertir en caso de error
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Ocurrió un error al crear el alumno. '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $alumno = Alumno::with(['user', 'seccion.grado'])->findOrFail($id);

        return Inertia::render('admin/alumnos/show', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alumno = Alumno::with('user')->findOrFail($id);
        $secciones = Seccion::with('grado')->get();

        return Inertia::render('admin/alumnos/edit', compact('alumno', 'secciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Iniciar transacción
        DB::beginTransaction();

        try {
            // 1. Validación de entrada
            $request->validate([
                'seccion_id' => 'required|exists:seccions,id',
            ]);

            // 2. Buscar alumno
            $alumno = Alumno::findOrFail($id);

            // 3. Actualizar registro de alumno
            $alumno->update($request->all());

            // 3. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.alumnos.index')
                ->with('message', 'El alumno fue actualizado correctamente')
                ->with('level', 'notice');
        } catch (\Throwable $e) {
            // 4. Revertir en caso de error
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'general' => 'Ocurrió un error al crear el alumno. '.$e->getMessage(),
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->user->roles()->sync(null);
        $alumno->delete();

        return redirect()->route('admin.alumnos.index')->with('message', 'El alumno fue eliminado correctamente')->with('level', 'notice');
    }
}
