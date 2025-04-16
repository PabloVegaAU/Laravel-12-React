<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Aula;
use App\Models\AulaAlumno;
use Illuminate\Database\Seeder;

class AulaAlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ASIGNAR ALUMNOS A AULAS
        $aulas = Aula::all();
        $alumnos = Alumno::all();

        foreach ($aulas as $aula) {
            foreach ($alumnos as $alumno) {
                AulaAlumno::create([
                    'aula_id' => $aula->id,
                    'alumno_id' => $alumno->user_id,
                    'es_actual' => true,
                    'estado' => 'ACTIVO',
                ]);
            }
        }
    }
}
