<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Datos base del sistema
        $this->call(RoleSeeder::class);
        $this->call(MensajeSeeder::class);
        // 2. Estructura académica base
        $this->call(MateriaSeeder::class);
        // 3. Usuarios y perfiles
        $this->call(UserSeeder::class);
        $this->call(DocenteSeeder::class);
        $this->call(AlumnoSeeder::class);
        // 4. Aulas y relaciones
        $this->call(AulaSeeder::class);
        $this->call(AulaAlumnoSeeder::class);
        $this->call(AulaDocenteMateriaSeeder::class);
        // 5. Contenido educativo
        $this->call(CarpetaSeeder::class);
        $this->call(TareaSeeder::class);
        $this->call(ActividadSeeder::class);
        // 6. Logros y recursos
        $this->call(LogroSeeder::class);
        $this->call(AlumnoLogroSeeder::class);
        // 7. Respuestas de estudiantes
        $this->call(RespuestaSeeder::class);
    }
}
