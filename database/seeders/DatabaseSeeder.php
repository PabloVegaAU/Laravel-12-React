<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Desactivar restricciones de clave foránea temporalmente
        Schema::disableForeignKeyConstraints();

        try {
            DB::beginTransaction();

            // 1. Datos base del sistema
            $this->call([
                RoleSeeder::class,
                MensajeSeeder::class,
            ]);

            // 2. Estructura académica base
            $this->call([
                MateriaSeeder::class,
            ]);

            // 3. Usuarios y perfiles
            $this->call([
                UserSeeder::class,
                DocenteSeeder::class,
                AlumnoSeeder::class,
            ]);

            // 4. Aulas y relaciones
            $this->call([
                AulaSeeder::class,
                // Primero asignar docentes a materias
                AulaDocenteMateriaSeeder::class,
                // Luego asignar alumnos a aulas
                AulaAlumnoSeeder::class,
            ]);

            // 5. Contenido educativo
            $this->call([
                CarpetaSeeder::class,
                TareaSeeder::class,
                ActividadSeeder::class,
                // Respuestas de alumnos a actividades
                RespuestaSeeder::class,
            ]);

            // 6. Logros y recursos
            $this->call([
                LogroSeeder::class,
                // Asignar logros a alumnos
                AlumnoLogroSeeder::class,
            ]);

            DB::commit();

            $this->command->info('¡Base de datos sembrada exitosamente! 🌱');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error al sembrar la base de datos: '.$e->getMessage());
            throw $e;
        } finally {
            // Reactivar restricciones de clave foránea
            Schema::enableForeignKeyConstraints();
        }
    }
}
