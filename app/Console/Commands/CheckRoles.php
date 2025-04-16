<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CheckRoles extends Command
{
    protected $signature = 'app:check-roles';

    protected $description = 'Verifica los roles y permisos del sistema';

    public function handle()
    {
        $this->info('=== Verificación de Roles y Permisos ===');

        // Verificar tablas
        $this->info('\nTablas de permisos:');
        $tables = ['roles', 'permissions', 'model_has_roles', 'model_has_permissions', 'role_has_permissions'];

        foreach ($tables as $table) {
            $exists = DB::getSchemaBuilder()->hasTable($table) ? '✓ Existe' : '✗ No existe';
            $this->line("- {$table}: {$exists}");
        }

        // Verificar roles
        $roles = Role::all();
        $this->info('\nRoles existentes:');

        if ($roles->isEmpty()) {
            $this->warn('No hay roles en la base de datos.');

            if ($this->confirm('¿Desea crear roles básicos?', true)) {
                Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
                Role::firstOrCreate(['name' => 'docente', 'guard_name' => 'web']);
                Role::firstOrCreate(['name' => 'alumno', 'guard_name' => 'web']);
                $this->info('Roles creados exitosamente.');
                $roles = Role::all();
            }
        }

        $this->table(
            ['ID', 'Nombre', 'Guard Name', 'Creado'],
            $roles->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name,
                    'created_at' => $role->created_at->format('Y-m-d H:i:s'),
                ];
            })
        );

        // Verificar usuario con ID 6
        $user = User::find(6);
        if ($user) {
            $this->info("\nUsuario ID 6: {$user->name} ({$user->email})");

            $roles = $user->getRoleNames();
            $this->info('Roles asignados: '.($roles->isEmpty() ? 'Ninguno' : $roles->implode(', ')));

            if ($roles->isEmpty() && $this->confirm('¿Desea asignar el rol de admin a este usuario?', true)) {
                $user->assignRole('admin');
                $this->info('Rol asignado correctamente.');
            }
        } else {
            $this->warn('No se encontró el usuario con ID 6');
        }
    }
}
