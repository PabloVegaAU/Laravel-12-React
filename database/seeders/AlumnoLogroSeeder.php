<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\AlumnoLogro;
use App\Models\Logro;
use Illuminate\Database\Seeder;

class AlumnoLogroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtener logros existentes
        $logros = Logro::all();

        // Asignar logros a alumnos existentes
        $alumnos = Alumno::all();

        foreach ($alumnos as $alumno) {
            foreach ($logros as $logro) {
                AlumnoLogro::firstOrCreate([
                    'alumno_id' => $alumno->user_id,
                    'logro_id' => $logro->id,
                ]);
            }
        }
    }
}
