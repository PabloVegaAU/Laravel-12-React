<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.users.index')->only('index');
        $this->middleware('can:admin.users.edit')->only(['edit', 'update']);
        $this->middleware('can:admin.users.create')->only(['create', 'store']);
        $this->middleware('can:admin.users.show')->only('show');
        $this->middleware('can:admin.users.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('sort') && in_array($request->sort, ['id', 'name', 'email', 'created_at'])) {
            $query->orderBy($request->sort, $request->direction === 'desc' ? 'desc' : 'asc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $users = $query->paginate(6)->withQueryString();

        return Inertia::render('admin/users/index', [
            'users' => $users,
            'filters' => $request->only(['search', 'sort', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación — si falla, redirect back con errores
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'apellido' => 'required|string',
            'fecha' => 'required|date',
            'dni' => 'required|string|max:8|unique:perfiles',
            'edad' => 'required|integer|min:0|max:99',
            'sexo' => 'required|string|in:m,f',
            'direccion' => 'required|string|max:100',
            'distrito' => 'required|string',
            'rol' => 'nullable|array',
            'rol.*' => 'integer|exists:roles,id',
        ]);

        // 2. Iniciar transacción
        DB::beginTransaction();

        try {
            // 3. Crear usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // 4. Crear perfil relacionado
            $user->perfil()->create([
                'nombre' => $validated['name'],
                'apellido' => $validated['apellido'],
                'DNI' => $validated['dni'],
                'fecha_nac' => $validated['fecha'],
                'edad' => $validated['edad'],
                'sexo' => $validated['sexo'],
                'direccion' => $validated['direccion'],
                'distrito' => $validated['distrito'],
            ]);

            // 5. Sincronizar roles si vienen
            if (! empty($validated['rol'])) {
                $user->roles()->sync($validated['rol']);
            }

            // 6. Confirmar transacción
            DB::commit();

            return redirect()->route('admin.users.index')->with('message', 'Usuario creado con éxito')->with('level', 'notice');
        } catch (\Throwable $e) {
            // 8. En caso de error, deshacer cambios y volver con mensaje
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()  // mantiene los datos que el usuario escribió
                ->withErrors(['general' => 'Ocurrió un error al crear el usuario. '.$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 1. Obtener usuario con perfil
        $user = User::with(['perfil', 'roles'])->findOrFail($id);

        // 2. Renderizar json
        return response()->json(['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 1. Obtener usuario con perfil
        $user = User::with(['perfil', 'roles'])->findOrFail($id);

        // 2. Renderizar json
        return response()->json(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            // 1. Obtener usuario con relaciones
            $user = User::with('perfil', 'roles')->findOrFail($id);

            // 2. Reglas de validación base
            $baseRules = [
                'name' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
                'fecha_nac' => 'required|date',
                'dni' => 'required|string|max:8|unique:perfiles,dni,'.$user->id.',user_id',
                'edad' => 'required|integer|min:1|max:99',
                'sexo' => 'required|in:m,f',
                'direccion' => 'required|string|max:255',
                'distrito' => 'required|string|max:255',
                'email' => 'required|string|email|max:100|unique:users,email,'.$user->id,
                'roles' => 'sometimes|array',
                'roles.*' => 'exists:roles,id'
            ];

            // 3. Validar datos básicos
            $request->validate($baseRules);

            // 4. Validar contraseña si se proporciona
            if ($request->filled('password')) {
                $request->validate([
                    'password' => 'required|string|min:8'
                ]);
            }

            // 5. Actualizar usuario
            $userData = $request->only(['name', 'email']);
            if ($request->filled('password')) {
                $userData['password'] = bcrypt($request->password);
            }
            $user->update($userData);

            // 6. Actualizar perfil
            $perfilData = [
                'nombre' => $request->name,  // Cambiado de 'name' a 'nombre'
                'apellido' => $request->apellido,
                'dni' => $request->dni,
                'fecha_nac' => $request->fecha_nac,
                'edad' => $request->edad,
                'sexo' => $request->sexo,
                'direccion' => $request->direccion,
                'distrito' => $request->distrito
            ];
            $user->perfil()->updateOrCreate(['user_id' => $user->id], $perfilData);

            // 7. Sincronizar roles
            if ($request->has('roles')) {
                // Validar que no se intente quitar el rol de admin si es el único admin
                $isAdmin = $user->hasRole('admin');
                $willRemoveAdmin = ! in_array(1, $request->roles);

                if ($isAdmin && $willRemoveAdmin && User::role('admin')->count() <= 1) {
                    throw new \Exception('No se puede quitar el rol de administrador al último administrador');
                }

                $user->syncRoles($request->roles);
            }

            // 8. Confirmar transacción
            DB::commit();

            return redirect()
                ->route('admin.users.index')
                ->with([
                    'message' => 'Usuario actualizado con éxito',
                    'level' => 'success'
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['general' => 'Error al actualizar el usuario: '.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('message', 'Usuario eliminado correctamente')
            ->with('level', 'notice');
    }
}
