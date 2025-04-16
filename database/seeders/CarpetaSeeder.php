<?php

namespace Database\Seeders;

use App\Models\AulaDocenteMateria;
use App\Models\Carpeta;
use Illuminate\Database\Seeder;

class CarpetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener todas las aulas_docentes_materias
        $aulasDocentesMaterias = AulaDocenteMateria::all();

        // Crear carpetas para cada aula_docente_materia
        foreach ($aulasDocentesMaterias as $aulaDocenteMateria) {
            Carpeta::create([
                'titulo' => 'Carpeta de '.$aulaDocenteMateria->id,
                'descripcion' => 'Descripción de la carpeta',
                'fecha_inicio' => now(),
                'fecha_final' => now()->addDays(30),
                'estado' => 'ABIERTO',
                'aulas_docentes_materias_id' => $aulaDocenteMateria->id,
            ]);
        }
    }
}
