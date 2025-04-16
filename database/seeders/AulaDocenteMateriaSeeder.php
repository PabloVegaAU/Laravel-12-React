<?php

namespace Database\Seeders;

use App\Models\Aula;
use App\Models\AulaDocenteMateria;
use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Database\Seeder;

class AulaDocenteMateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ASIGNAR DOCENTES Y MATERIAS A AULAS
        $aulas = Aula::all();
        $docentes = Docente::all();
        $materias = Materia::all();

        foreach ($aulas as $aula) {
            foreach ($docentes as $docente) {
                foreach ($materias as $materia) {
                    AulaDocenteMateria::firstOrCreate([
                        'aula_id' => $aula->id,
                        'docente_id' => $docente->user_id,
                        'materia_id' => $materia->id,
                    ]);
                }
            }
        }
    }
}
