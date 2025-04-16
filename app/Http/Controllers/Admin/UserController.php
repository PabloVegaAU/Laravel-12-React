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
        return Inertia::render('admin/users/create');
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
        $user = User::with('perfil')->findOrFail($id);

        // 2. Renderizar vista
        return Inertia::render('admin/users/show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 1. Obtener usuario con perfil
        $user = User::with('perfil')->findOrFail($id);

        // 2. Renderizar json
        return response()->json($user); // retorna un objeto json con los dato
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // 1. Obtener usuario
            $user = User::findOrFail($id);

            // 2. Validación
            $sin = [
                'email' => 'required|string|email|max:100',
                'name' => 'required|string',
                'apellido' => 'required|string',
                'fecha' => 'required',
                'dni' => 'required|string|max:8',
                'edad' => 'required|string|max:2',
                'sexo' => 'required|string',
                'direccion' => 'required|max:100',
                'distrito' => 'required|string',
            ];
            $con = [
                'email' => 'required|string|email|max:100',
                'password' => 'required|string',
                'name' => 'required|string',
                'apellido' => 'required|string',
                'fecha' => 'required',
                'dni' => 'required|string|max:8',
                'edad' => 'required|string|max:2',
                'sexo' => 'required|string',
                'direccion' => 'required|max:100',
                'distrito' => 'required|string',
            ];

            $con_correo = [
                'email' => 'required|string|email|max:100|unique:users',
                'name' => 'required|string',
                'apellido' => 'required|string',
                'fecha' => 'required',
                'dni' => 'required|string|max:8',
                'edad' => 'required|string|max:2',
                'sexo' => 'required|string',
                'direccion' => 'required|max:100',
                'distrito' => 'required|string',
            ];

            if ($user->email == $request->email) {
                if ($request->password == '') {
                    // validacion sin password, ya que no se presentaron cambios en la contraseña
                    $request->validate($sin);
                    // actualiza solo modelo user
                    $user->update(['name' => $request->name, 'email' => $request->email]);
                } else {
                    // validacion con cambios realizados en la contraseña
                    $request->validate($con);
                    // Actualiza solo modelo user
                    $user->update(['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)]);
                }
            } else {
                $request->validate($con_correo);
            }

            // actualiza solo el modelo profile
            $user->perfil()->update($request->only('nombre', 'apellido', 'dni', 'fecha_nac', 'edad', 'sexo', 'direccion', 'distrito'));

            if ($request->roles) { // si esta marcado
                // 1 = id admin

                if ($user->roles->isEmpty()) { // EN CASO NO EXISTA LA RELACION
                    $user->roles()->sync(1);
                } else {

                    foreach ($user->roles as $role) {   // si el usuario a editar era un docente
                        // mantiene el docente y se añade el admin
                        if ($role->id == 2) {
                            $user->roles()->sync([2, 1]);
                        }

                        if ($role->id == 3) {
                            throw new \Exception('No se puede eliminar el rol de admin');
                        }
                    }
                }
            } else { // si no esta marcado // LE ESTAMOS QUITANDO EL ROL DE DOCENTE
                foreach ($user->roles as $role) {
                    // si el usuario a editar era un docente
                    // mantiene el docente y se quita el admin
                    if ($role->id == 2) {
                        $user->roles()->sync(2);
                    }
                }
            }

            return redirect()->route('admin.users.index')
                ->with('message', 'Usuario actualizado con éxito')
                ->with('level', 'notice');
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
